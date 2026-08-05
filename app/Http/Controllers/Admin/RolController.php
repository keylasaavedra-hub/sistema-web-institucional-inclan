<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permiso;
use App\Models\Rol;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RolController extends Controller
{
    public function index(): View
    {
        $roles = Rol::query()
            ->withCount([
                'usuarios',
                'permisos',
            ])
            ->orderBy('nombre')
            ->get();

        return view('admin.roles.index', compact('roles'));
    }

    public function crear(): View
    {
        $permisos = Permiso::query()
            ->activos()
            ->orderBy('modulo')
            ->orderBy('nombre')
            ->get()
            ->groupBy('modulo');

        return view('admin.roles.crear', compact('permisos'));
    }

    public function guardar(Request $request): RedirectResponse
    {
        $datos = $this->validar($request);

        DB::transaction(function () use ($datos) {
            $rol = Rol::create([
                'nombre' => $datos['nombre'],
                'descripcion' => $datos['descripcion'] ?? null,
                'estado' => true,
            ]);

            $rol->permisos()->sync($datos['permisos'] ?? []);
        });

        return redirect()
            ->route('admin.roles.index')
            ->with(
                'success',
                'El rol fue registrado correctamente.'
            );
    }

    public function editar(Rol $rol): View
    {
        $rol->load('permisos:id');

        $permisos = Permiso::query()
            ->activos()
            ->orderBy('modulo')
            ->orderBy('nombre')
            ->get()
            ->groupBy('modulo');

        $permisosAsignados = $rol->permisos
            ->pluck('id')
            ->all();

        return view('admin.roles.editar', compact(
            'rol',
            'permisos',
            'permisosAsignados'
        ));
    }

    public function actualizar(
        Request $request,
        Rol $rol
    ): RedirectResponse {
        $datos = $this->validar($request, $rol);

        if (
            $rol->nombre === 'Administrador' &&
            ! in_array(
                Permiso::where('codigo', 'seguridad.administrar')->value('id'),
                $datos['permisos'] ?? [],
                true
            )
        ) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'El rol Administrador debe conservar el permiso de seguridad.'
                );
        }

        DB::transaction(function () use ($rol, $datos) {
            $rol->update([
                'nombre' => $datos['nombre'],
                'descripcion' => $datos['descripcion'] ?? null,
            ]);

            $rol->permisos()->sync($datos['permisos'] ?? []);
        });

        return redirect()
            ->route('admin.roles.editar', $rol)
            ->with(
                'success',
                'El rol y sus permisos fueron actualizados correctamente.'
            );
    }

    public function cambiarEstado(Rol $rol): RedirectResponse
    {
        if ($rol->nombre === 'Administrador') {
            return redirect()
                ->route('admin.roles.index')
                ->with(
                    'error',
                    'El rol Administrador no puede ser desactivado.'
                );
        }

        if ($rol->estado && $rol->usuarios()->where('estado', true)->exists()) {
            return redirect()
                ->route('admin.roles.index')
                ->with(
                    'error',
                    'No puedes desactivar un rol que tiene usuarios activos.'
                );
        }

        $rol->update([
            'estado' => ! $rol->estado,
        ]);

        return redirect()
            ->route('admin.roles.index')
            ->with(
                'success',
                $rol->estado
                    ? 'El rol fue activado correctamente.'
                    : 'El rol fue desactivado correctamente.'
            );
    }

    public function eliminar(Rol $rol): RedirectResponse
    {
        if ($rol->nombre === 'Administrador') {
            return redirect()
                ->route('admin.roles.index')
                ->with(
                    'error',
                    'El rol Administrador no puede ser eliminado.'
                );
        }

        if ($rol->usuarios()->exists()) {
            return redirect()
                ->route('admin.roles.index')
                ->with(
                    'error',
                    'No se puede eliminar un rol asignado a usuarios.'
                );
        }

        DB::transaction(function () use ($rol) {
            $rol->permisos()->detach();
            $rol->delete();
        });

        return redirect()
            ->route('admin.roles.index')
            ->with(
                'success',
                'El rol fue eliminado correctamente.'
            );
    }

    private function validar(
        Request $request,
        ?Rol $rol = null
    ): array {
        return $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('roles', 'nombre')
                    ->ignore($rol?->id),
            ],
            'descripcion' => [
                'nullable',
                'string',
                'max:200',
            ],
            'permisos' => [
                'nullable',
                'array',
            ],
            'permisos.*' => [
                'integer',
                Rule::exists('permisos', 'id')
                    ->where(
                        fn ($query) => $query->where('estado', true)
                    ),
            ],
        ], [
            'nombre.required' => 'El nombre del rol es obligatorio.',
            'nombre.unique' => 'Ya existe un rol con ese nombre.',
            'nombre.max' => 'El nombre no debe superar los 100 caracteres.',
            'descripcion.max' => 'La descripción no debe superar los 200 caracteres.',
            'permisos.array' => 'La selección de permisos no es válida.',
            'permisos.*.exists' => 'Uno de los permisos seleccionados no es válido.',
        ]);
    }
}