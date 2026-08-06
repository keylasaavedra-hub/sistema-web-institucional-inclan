<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permiso;
use App\Models\Rol;
use App\Services\AuditoriaService;
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

        $permisosSeleccionados = $this->normalizarPermisos(
            $datos['permisos'] ?? []
        );

        DB::transaction(function () use (
            $datos,
            $permisosSeleccionados
        ) {
            $rol = Rol::create([
                'nombre' => $datos['nombre'],
                'descripcion' => $datos['descripcion'] ?? null,
                'estado' => true,
            ]);

            $rol->permisos()->sync($permisosSeleccionados);

            $permisosNuevos = $this->obtenerDatosPermisos(
                $permisosSeleccionados
            );

            AuditoriaService::registrar(
                modulo: 'Roles y permisos',
                accion: 'crear',
                modelo: $rol,
                valoresNuevos: [
                    'rol' => $rol->getAttributes(),
                    'permisos' => $permisosNuevos,
                ],
                descripcion: sprintf(
                    'Se registró el rol %s con %d permiso(s).',
                    $rol->nombre,
                    count($permisosSeleccionados)
                )
            );
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
            ->map(fn ($id) => (int) $id)
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

        $esAdministrador = $rol->nombre === 'Administrador';

        $permisosSeleccionados = $this->normalizarPermisos(
            $datos['permisos'] ?? []
        );

        $permisoSeguridadId = (int) Permiso::query()
            ->where('codigo', 'seguridad.administrar')
            ->value('id');

        if (
            $esAdministrador &&
            $datos['nombre'] !== 'Administrador'
        ) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'El nombre del rol Administrador no puede modificarse.'
                );
        }

        if (
            $esAdministrador &&
            (
                $permisoSeguridadId <= 0 ||
                ! in_array(
                    $permisoSeguridadId,
                    $permisosSeleccionados,
                    true
                )
            )
        ) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'El rol Administrador debe conservar el permiso de seguridad.'
                );
        }

        DB::transaction(function () use (
            $rol,
            $datos,
            $esAdministrador,
            $permisosSeleccionados
        ) {
            $rol->load('permisos');

            $valoresAnteriores = [
                'rol' => $rol->getAttributes(),
                'permisos' => $rol->permisos
                    ->map(fn (Permiso $permiso) => [
                        'id' => $permiso->id,
                        'codigo' => $permiso->codigo,
                        'nombre' => $permiso->nombre,
                        'modulo' => $permiso->modulo,
                    ])
                    ->values()
                    ->all(),
            ];

            $rol->update([
                'nombre' => $esAdministrador
                    ? 'Administrador'
                    : $datos['nombre'],
                'descripcion' => $datos['descripcion'] ?? null,
            ]);

            $rol->permisos()->sync($permisosSeleccionados);

            $rol->refresh();

            $valoresNuevos = [
                'rol' => $rol->getAttributes(),
                'permisos' => $this->obtenerDatosPermisos(
                    $permisosSeleccionados
                ),
            ];

            AuditoriaService::registrar(
                modulo: 'Roles y permisos',
                accion: 'actualizar',
                modelo: $rol,
                valoresAnteriores: $valoresAnteriores,
                valoresNuevos: $valoresNuevos,
                descripcion: sprintf(
                    'Se actualizó el rol %s y sus permisos.',
                    $rol->nombre
                )
            );
        });

        return redirect()
            ->route('admin.roles.editar', $rol)
            ->with(
                'success',
                'El rol y sus permisos fueron actualizados correctamente.'
            );
    }

    public function cambiarEstado(
        Rol $rol
    ): RedirectResponse {
        if ($rol->nombre === 'Administrador') {
            return redirect()
                ->route('admin.roles.index')
                ->with(
                    'error',
                    'El rol Administrador no puede ser desactivado.'
                );
        }

        if (
            $rol->estado &&
            $rol->usuarios()
                ->where('estado', true)
                ->exists()
        ) {
            return redirect()
                ->route('admin.roles.index')
                ->with(
                    'error',
                    'No puedes desactivar un rol que tiene usuarios activos.'
                );
        }

        DB::transaction(function () use ($rol) {
            $estadoAnterior = (bool) $rol->estado;
            $estadoNuevo = ! $estadoAnterior;

            $rol->update([
                'estado' => $estadoNuevo,
            ]);

            $rol->refresh();

            AuditoriaService::registrar(
                modulo: 'Roles y permisos',
                accion: $estadoNuevo
                    ? 'activar'
                    : 'desactivar',
                modelo: $rol,
                valoresAnteriores: [
                    'estado' => $estadoAnterior,
                ],
                valoresNuevos: [
                    'estado' => $estadoNuevo,
                ],
                descripcion: sprintf(
                    'Se %s el rol %s.',
                    $estadoNuevo
                        ? 'activó'
                        : 'desactivó',
                    $rol->nombre
                )
            );
        });

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
            $rol->load('permisos');

            $valoresAnteriores = [
                'rol' => $rol->getAttributes(),
                'permisos' => $rol->permisos
                    ->map(fn (Permiso $permiso) => [
                        'id' => $permiso->id,
                        'codigo' => $permiso->codigo,
                        'nombre' => $permiso->nombre,
                        'modulo' => $permiso->modulo,
                    ])
                    ->values()
                    ->all(),
            ];

            $nombreRol = $rol->nombre;
            $cantidadPermisos = $rol->permisos->count();

            AuditoriaService::registrar(
                modulo: 'Roles y permisos',
                accion: 'eliminar',
                modelo: $rol,
                valoresAnteriores: $valoresAnteriores,
                descripcion: sprintf(
                    'Se eliminó el rol %s, que tenía %d permiso(s).',
                    $nombreRol,
                    $cantidadPermisos
                )
            );

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
                        fn ($query) => $query->where(
                            'estado',
                            true
                        )
                    ),
            ],
        ], [
            'nombre.required' => 'El nombre del rol es obligatorio.',
            'nombre.unique' => 'Ya existe un rol con ese nombre.',
            'nombre.max' => 'El nombre no debe superar los 100 caracteres.',
            'descripcion.max' => 'La descripción no debe superar los 200 caracteres.',
            'permisos.array' => 'La selección de permisos no es válida.',
            'permisos.*.integer' => 'Uno de los permisos seleccionados no es válido.',
            'permisos.*.exists' => 'Uno de los permisos seleccionados no es válido.',
        ]);
    }

    private function normalizarPermisos(
        array $permisos
    ): array {
        return array_values(
            array_unique(
                array_map(
                    'intval',
                    $permisos
                )
            )
        );
    }

    private function obtenerDatosPermisos(
        array $permisosIds
    ): array {
        if (empty($permisosIds)) {
            return [];
        }

        return Permiso::query()
            ->whereIn('id', $permisosIds)
            ->orderBy('modulo')
            ->orderBy('nombre')
            ->get([
                'id',
                'codigo',
                'nombre',
                'modulo',
            ])
            ->map(fn (Permiso $permiso) => [
                'id' => $permiso->id,
                'codigo' => $permiso->codigo,
                'nombre' => $permiso->nombre,
                'modulo' => $permiso->modulo,
            ])
            ->values()
            ->all();
    }
}