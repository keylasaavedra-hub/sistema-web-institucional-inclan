<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auditoria;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditoriaController extends Controller
{
    public function index(Request $request): View
    {
        $modulo = trim((string) $request->input('modulo'));
        $accion = trim((string) $request->input('accion'));
        $usuarioId = $request->integer('usuario_id');
        $fechaDesde = $request->input('fecha_desde');
        $fechaHasta = $request->input('fecha_hasta');
        $buscar = trim((string) $request->input('buscar'));

        $auditorias = Auditoria::query()
            ->with('usuario:id,name,apellidos,dni')
            ->when(
                $modulo !== '',
                fn ($query) => $query->where('modulo', $modulo)
            )
            ->when(
                $accion !== '',
                fn ($query) => $query->where('accion', $accion)
            )
            ->when(
                $usuarioId > 0,
                fn ($query) => $query->where('user_id', $usuarioId)
            )
            ->when(
                $fechaDesde,
                fn ($query) => $query->whereDate(
                    'created_at',
                    '>=',
                    $fechaDesde
                )
            )
            ->when(
                $fechaHasta,
                fn ($query) => $query->whereDate(
                    'created_at',
                    '<=',
                    $fechaHasta
                )
            )
            ->when($buscar !== '', function ($query) use ($buscar) {
                $query->where(function ($subquery) use ($buscar) {
                    $subquery
                        ->where('descripcion', 'like', "%{$buscar}%")
                        ->orWhere('tabla', 'like', "%{$buscar}%")
                        ->orWhere('registro_id', 'like', "%{$buscar}%")
                        ->orWhere('ip', 'like', "%{$buscar}%")
                        ->orWhereHas('usuario', function ($usuarioQuery) use ($buscar) {
                            $usuarioQuery
                                ->where('name', 'like', "%{$buscar}%")
                                ->orWhere('apellidos', 'like', "%{$buscar}%")
                                ->orWhere('dni', 'like', "%{$buscar}%");
                        });
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $modulos = Auditoria::query()
            ->whereNotNull('modulo')
            ->distinct()
            ->orderBy('modulo')
            ->pluck('modulo');

        $acciones = Auditoria::query()
            ->whereNotNull('accion')
            ->distinct()
            ->orderBy('accion')
            ->pluck('accion');

        $usuarios = User::query()
            ->orderBy('name')
            ->orderBy('apellidos')
            ->get([
                'id',
                'name',
                'apellidos',
                'dni',
            ]);

        return view('admin.auditorias.index', compact(
            'auditorias',
            'modulos',
            'acciones',
            'usuarios',
            'modulo',
            'accion',
            'usuarioId',
            'fechaDesde',
            'fechaHasta',
            'buscar'
        ));
    }

    public function mostrar(
        Auditoria $auditoria
    ): View {
        $auditoria->load(
            'usuario:id,name,apellidos,dni,email'
        );

        return view(
            'admin.auditorias.mostrar',
            compact('auditoria')
        );
    }
}