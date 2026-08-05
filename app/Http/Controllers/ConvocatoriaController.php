<?php

namespace App\Http\Controllers;

use App\Models\Convocatoria;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConvocatoriaController extends Controller
{
    public function index(Request $request): View
    {
        $convocatorias = Convocatoria::query()
            ->with(['area', 'cargo'])
            ->where('estado', 'publicada')
            ->where(function ($query) {
                $query
                    ->whereNull('fecha_publicacion')
                    ->orWhere('fecha_publicacion', '<=', now());
            })
            ->when(
                $request->filled('buscar'),
                function ($query) use ($request) {
                    $buscar = trim($request->buscar);

                    $query->where(function ($subquery) use ($buscar) {
                        $subquery
                            ->where('titulo', 'like', "%{$buscar}%")
                            ->orWhere('descripcion', 'like', "%{$buscar}%")
                            ->orWhere('perfil', 'like', "%{$buscar}%")
                            ->orWhere('codigo', 'like', "%{$buscar}%");
                    });
                }
            )
            ->when(
                $request->filled('tipo'),
                fn ($query) => $query->where('tipo', $request->tipo)
            )
            ->orderByDesc('destacada')
            ->orderByDesc('fecha_publicacion')
            ->paginate(9)
            ->withQueryString();

        return view('convocatorias.index', [
            'convocatorias' => $convocatorias,
        ]);
    }

    public function mostrar(Convocatoria $convocatoria): View
    {
        abort_unless(
            $convocatoria->estado === 'publicada',
            404
        );

        abort_if(
            $convocatoria->fecha_publicacion
            && $convocatoria->fecha_publicacion->isFuture(),
            404
        );

        $convocatoria->load(['area', 'cargo']);

        return view('convocatorias.mostrar', [
            'convocatoria' => $convocatoria,
        ]);
    }
}