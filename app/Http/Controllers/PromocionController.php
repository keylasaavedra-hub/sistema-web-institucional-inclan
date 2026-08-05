<?php

namespace App\Http\Controllers;

use App\Models\NivelEducativo;
use App\Models\Promocion;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PromocionController extends Controller
{
    public function index(Request $request): View
    {
        $nivelId = $request->integer('nivel');
        $anio = $request->integer('anio');

        $promociones = Promocion::query()
            ->publicadas()
            ->with([
                'nivelEducativo',
                'imagenesActivas',
            ])
            ->when(
                $nivelId > 0,
                fn ($query) => $query->where(
                    'nivel_educativo_id',
                    $nivelId
                )
            )
            ->when(
                $anio > 0,
                fn ($query) => $query->where('anio', $anio)
            )
            ->orderByDesc('anio')
            ->orderBy('nivel_educativo_id')
            ->orderBy('nombre')
            ->paginate(12)
            ->withQueryString();

        $niveles = NivelEducativo::query()
            ->activos()
            ->orderBy('id')
            ->get();

        $anios = Promocion::query()
            ->publicadas()
            ->distinct()
            ->orderByDesc('anio')
            ->pluck('anio');

        return view('promociones.index', compact(
            'promociones',
            'niveles',
            'anios',
            'nivelId',
            'anio'
        ));
    }

    public function mostrar(Promocion $promocion): View
    {
        abort_unless($promocion->estado, 404);

        $promocion->load([
            'nivelEducativo',
            'imagenesActivas',
        ]);

        $relacionadas = Promocion::query()
            ->publicadas()
            ->with('nivelEducativo')
            ->whereKeyNot($promocion->id)
            ->where('nivel_educativo_id', $promocion->nivel_educativo_id)
            ->orderByDesc('anio')
            ->limit(3)
            ->get();

        return view('promociones.mostrar', compact(
            'promocion',
            'relacionadas'
        ));
    }
}