<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UsuarioController extends Controller
{
    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('buscar'));
        $rolId = $request->integer('rol_id');
        $estado = $request->input('estado');

        $usuarios = User::query()
            ->with('rol:id,nombre')
            ->when($buscar !== '', function ($query) use ($buscar) {
                $query->where(function ($subquery) use ($buscar) {
                    $subquery
                        ->where('dni', 'like', "%{$buscar}%")
                        ->orWhere('name', 'like', "%{$buscar}%")
                        ->orWhere('apellidos', 'like', "%{$buscar}%")
                        ->orWhere('email', 'like', "%{$buscar}%");
                });
            })
            ->when(
                $rolId > 0,
                fn ($query) => $query->where('rol_id', $rolId)
            )
            ->when(
                in_array($estado, ['activo', 'inactivo'], true),
                fn ($query) => $query->where(
                    'estado',
                    $estado === 'activo'
                )
            )
            ->orderByDesc('estado')
            ->orderBy('name')
            ->orderBy('apellidos')
            ->paginate(15)
            ->withQueryString();

        $roles = Rol::query()
            ->activos()
            ->orderBy('nombre')
            ->get();

        return view('admin.usuarios.index', compact(
            'usuarios',
            'roles',
            'buscar',
            'rolId',
            'estado'
        ));
    }

    public function crear(): View
    {
        $roles = Rol::query()
            ->activos()
            ->orderBy('nombre')
            ->get();

        return view('admin.usuarios.crear', compact('roles'));
    }

    public function guardar(Request $request): RedirectResponse
    {
        $datos = $this->validarCreacion($request);

        User::create([
            'dni' => $datos['dni'],
            'name' => $datos['name'],
            'apellidos' => $datos['apellidos'],
            'email' => strtolower($datos['email']),
            'telefono' => $datos['telefono'] ?? null,
            'password' => Hash::make($datos['password']),
            'rol_id' => $datos['rol_id'],
            'estado' => $request->boolean('estado'),
            'email_verified_at' => now(),
        ]);

        return redirect()
            ->route('admin.usuarios.index')
            ->with(
                'success',
                'El usuario fue registrado correctamente.'
            );
    }

    public function editar(User $usuario): View
    {
        $usuario->load('rol');

        $roles = Rol::query()
            ->activos()
            ->orderBy('nombre')
            ->get();

        return view('admin.usuarios.editar', compact(
            'usuario',
            'roles'
        ));
    }

    public function actualizar(
        Request $request,
        User $usuario
    ): RedirectResponse {
        $datos = $this->validarActualizacion($request, $usuario);

        if (
            $usuario->is(auth()->user()) &&
            ! $request->boolean('estado')
        ) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'No puedes desactivar tu propia cuenta.'
                );
        }

        $actualizacion = [
            'dni' => $datos['dni'],
            'name' => $datos['name'],
            'apellidos' => $datos['apellidos'],
            'email' => strtolower($datos['email']),
            'telefono' => $datos['telefono'] ?? null,
            'rol_id' => $datos['rol_id'],
            'estado' => $request->boolean('estado'),
        ];

        if (! empty($datos['password'])) {
            $actualizacion['password'] = Hash::make($datos['password']);
        }

        $usuario->update($actualizacion);

        return redirect()
            ->route('admin.usuarios.editar', $usuario)
            ->with(
                'success',
                'El usuario fue actualizado correctamente.'
            );
    }

    public function cambiarEstado(User $usuario): RedirectResponse
    {
        if ($usuario->is(auth()->user())) {
            return redirect()
                ->route('admin.usuarios.index')
                ->with(
                    'error',
                    'No puedes desactivar tu propia cuenta.'
                );
        }

        $usuario->update([
            'estado' => ! $usuario->estado,
        ]);

        return redirect()
            ->route('admin.usuarios.index')
            ->with(
                'success',
                $usuario->estado
                    ? 'El usuario fue activado correctamente.'
                    : 'El usuario fue desactivado correctamente.'
            );
    }

    public function eliminar(User $usuario): RedirectResponse
    {
        if ($usuario->is(auth()->user())) {
            return redirect()
                ->route('admin.usuarios.index')
                ->with(
                    'error',
                    'No puedes eliminar tu propia cuenta.'
                );
        }

        if ($usuario->esAdministrador()) {
            $administradoresActivos = User::query()
                ->where('estado', true)
                ->whereHas('rol', function ($query) {
                    $query->where('nombre', 'Administrador');
                })
                ->count();

            if ($administradoresActivos <= 1) {
                return redirect()
                    ->route('admin.usuarios.index')
                    ->with(
                        'error',
                        'No se puede eliminar el último administrador activo.'
                    );
            }
        }

        $usuario->delete();

        return redirect()
            ->route('admin.usuarios.index')
            ->with(
                'success',
                'El usuario fue eliminado correctamente.'
            );
    }

    private function validarCreacion(Request $request): array
    {
        return $request->validate([
            'dni' => [
                'required',
                'digits:8',
                'unique:users,dni',
            ],
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'apellidos' => [
                'required',
                'string',
                'max:100',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'telefono' => [
                'nullable',
                'string',
                'max:20',
            ],
            'rol_id' => [
                'required',
                'integer',
                Rule::exists('roles', 'id')
                    ->where(fn ($query) => $query->where('estado', true)),
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'estado' => [
                'nullable',
                'boolean',
            ],
        ], $this->mensajes());
    }

    private function validarActualizacion(
        Request $request,
        User $usuario
    ): array {
        return $request->validate([
            'dni' => [
                'required',
                'digits:8',
                Rule::unique('users', 'dni')->ignore($usuario->id),
            ],
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'apellidos' => [
                'required',
                'string',
                'max:100',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($usuario->id),
            ],
            'telefono' => [
                'nullable',
                'string',
                'max:20',
            ],
            'rol_id' => [
                'required',
                'integer',
                Rule::exists('roles', 'id')
                    ->where(fn ($query) => $query->where('estado', true)),
            ],
            'password' => [
                'nullable',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'estado' => [
                'nullable',
                'boolean',
            ],
        ], $this->mensajes());
    }

    private function mensajes(): array
    {
        return [
            'dni.required' => 'El DNI es obligatorio.',
            'dni.digits' => 'El DNI debe contener exactamente 8 dígitos.',
            'dni.unique' => 'El DNI ya está registrado.',
            'name.required' => 'Los nombres son obligatorios.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingresa un correo electrónico válido.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'rol_id.required' => 'Selecciona un rol.',
            'rol_id.exists' => 'El rol seleccionado no es válido.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ];
    }
}