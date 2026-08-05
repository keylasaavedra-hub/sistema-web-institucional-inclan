<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VideoController extends Controller
{
    public function index(Request $request): View
    {
        $categoria = trim((string) $request->input('categoria'));

        $videos = Video::query()
            ->publicados()
            ->when(
                $categoria !== '',
                fn ($query) => $query->where('categoria', $categoria)
            )
            ->orderByDesc('destacado')
            ->orderBy('orden')
            ->orderByDesc('fecha_publicacion')
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        $categorias = Video::query()
            ->publicados()
            ->whereNotNull('categoria')
            ->distinct()
            ->orderBy('categoria')
            ->pluck('categoria');

        return view('videos.index', compact(
            'videos',
            'categorias',
            'categoria'
        ));
    }

    public function mostrar(Video $video): View
    {
        abort_unless($video->estado, 404);

        return view('videos.mostrar', compact('video'));
    }
}