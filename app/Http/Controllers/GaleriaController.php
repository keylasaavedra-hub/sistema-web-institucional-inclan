<?php

namespace App\Http\Controllers;

use App\Models\Galeria;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GaleriaController extends Controller
{
    public function index(Request $request): View
    {
        $anio = $request->integer('anio');

        $galerias = Galeria::query()
            ->activas()
            ->fotografias()
            ->withCount([
                'archivosActivos',
            ])
            ->when(
                $anio > 0,
                fn ($query) => $query->where('anio', $anio)
            )
            ->orderByDesc('anio')
            ->orderBy('orden')
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        $anios = Galeria::query()
            ->activas()
            ->fotografias()
            ->whereNotNull('anio')
            ->distinct()
            ->orderByDesc('anio')
            ->pluck('anio');

        return view('galerias.index', compact(
            'galerias',
            'anios',
            'anio'
        ));
    }

    public function mostrar(Galeria $galeria): View
    {
        abort_unless(
            $galeria->estado && $galeria->tipo === 'fotografias',
            404
        );

        $galeria->load([
            'archivosActivos',
        ]);

        return view('galerias.mostrar', compact('galeria'));
    }
}