<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class VideoController extends Controller
{
    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('buscar'));
        $estado = $request->input('estado');
        $categoria = $request->input('categoria');

        $videos = Video::query()
            ->when($buscar !== '', function ($query) use ($buscar) {
                $query->where(function ($subquery) use ($buscar) {
                    $subquery
                        ->where('titulo', 'like', "%{$buscar}%")
                        ->orWhere('descripcion', 'like', "%{$buscar}%")
                        ->orWhere('url_youtube', 'like', "%{$buscar}%");
                });
            })
            ->when(
                in_array($estado, ['publicado', 'oculto'], true),
                fn ($query) => $query->where(
                    'estado',
                    $estado === 'publicado'
                )
            )
            ->when(
                filled($categoria),
                fn ($query) => $query->where('categoria', $categoria)
            )
            ->orderByDesc('destacado')
            ->orderBy('orden')
            ->orderByDesc('fecha_publicacion')
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        $categorias = Video::query()
            ->whereNotNull('categoria')
            ->distinct()
            ->orderBy('categoria')
            ->pluck('categoria');

        return view('admin.videos.index', compact(
            'videos',
            'categorias',
            'buscar',
            'estado',
            'categoria'
        ));
    }

    public function crear(): View
    {
        return view('admin.videos.crear');
    }

    public function guardar(Request $request): RedirectResponse
    {
        $datos = $this->validar($request);

        $youtubeId = $this->extraerYoutubeId($datos['url_youtube']);

        if (!$youtubeId) {
            return back()
                ->withInput()
                ->withErrors([
                    'url_youtube' => 'No se pudo reconocer un video válido de YouTube.',
                ]);
        }

        $rutaMiniatura = null;

        if ($request->hasFile('miniatura')) {
            $rutaMiniatura = $request
                ->file('miniatura')
                ->store('videos/miniaturas', 'public');
        }

        Video::create([
            'usuario_id' => auth()->id(),
            'titulo' => $datos['titulo'],
            'descripcion' => $datos['descripcion'] ?? null,
            'url_youtube' => $datos['url_youtube'],
            'youtube_id' => $youtubeId,
            'miniatura' => $rutaMiniatura,
            'categoria' => $datos['categoria'],
            'fecha_publicacion' => $datos['fecha_publicacion'] ?? now()->toDateString(),
            'orden' => $datos['orden'] ?? 0,
            'destacado' => $request->boolean('destacado'),
            'estado' => $request->boolean('estado'),
        ]);

        return redirect()
            ->route('admin.videos.index')
            ->with('success', 'El video fue registrado correctamente.');
    }

    public function editar(Video $video): View
    {
        return view('admin.videos.editar', compact('video'));
    }

    public function actualizar(
        Request $request,
        Video $video
    ): RedirectResponse {
        $datos = $this->validar($request);

        $youtubeId = $this->extraerYoutubeId($datos['url_youtube']);

        if (!$youtubeId) {
            return back()
                ->withInput()
                ->withErrors([
                    'url_youtube' => 'No se pudo reconocer un video válido de YouTube.',
                ]);
        }

        $rutaMiniatura = $video->miniatura;

        if ($request->hasFile('miniatura')) {
            $nuevaMiniatura = $request
                ->file('miniatura')
                ->store('videos/miniaturas', 'public');

            if ($rutaMiniatura) {
                Storage::disk('public')->delete($rutaMiniatura);
            }

            $rutaMiniatura = $nuevaMiniatura;
        }

        $video->update([
            'titulo' => $datos['titulo'],
            'descripcion' => $datos['descripcion'] ?? null,
            'url_youtube' => $datos['url_youtube'],
            'youtube_id' => $youtubeId,
            'miniatura' => $rutaMiniatura,
            'categoria' => $datos['categoria'],
            'fecha_publicacion' => $datos['fecha_publicacion'] ?? null,
            'orden' => $datos['orden'] ?? 0,
            'destacado' => $request->boolean('destacado'),
            'estado' => $request->boolean('estado'),
        ]);

        return redirect()
            ->route('admin.videos.editar', $video)
            ->with('success', 'El video fue actualizado correctamente.');
    }

    public function eliminar(Video $video): RedirectResponse
    {
        if ($video->miniatura) {
            Storage::disk('public')->delete($video->miniatura);
        }

        $video->delete();

        return redirect()
            ->route('admin.videos.index')
            ->with('success', 'El video fue eliminado correctamente.');
    }

    private function validar(Request $request): array
    {
        return $request->validate([
            'titulo' => [
                'required',
                'string',
                'max:180',
            ],
            'descripcion' => [
                'nullable',
                'string',
                'max:3000',
            ],
            'url_youtube' => [
                'required',
                'url',
                'max:500',
            ],
            'categoria' => [
                'required',
                'string',
                'max:60',
            ],
            'fecha_publicacion' => [
                'nullable',
                'date',
            ],
            'orden' => [
                'nullable',
                'integer',
                'min:0',
                'max:9999',
            ],
            'destacado' => [
                'nullable',
                'boolean',
            ],
            'estado' => [
                'nullable',
                'boolean',
            ],
            'miniatura' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ], [
            'titulo.required' => 'El título del video es obligatorio.',
            'titulo.max' => 'El título no debe superar los 180 caracteres.',
            'url_youtube.required' => 'El enlace de YouTube es obligatorio.',
            'url_youtube.url' => 'Ingresa una dirección válida de YouTube.',
            'categoria.required' => 'La categoría es obligatoria.',
            'fecha_publicacion.date' => 'La fecha de publicación no es válida.',
            'miniatura.image' => 'La miniatura debe ser una imagen.',
            'miniatura.mimes' => 'La miniatura debe ser JPG, JPEG, PNG o WEBP.',
            'miniatura.max' => 'La miniatura no debe superar los 5 MB.',
        ]);
    }

    private function extraerYoutubeId(string $url): ?string
    {
        $patrones = [
            '/youtube\.com\/watch\?v=([a-zA-Z0-9_-]{11})/',
            '/youtu\.be\/([a-zA-Z0-9_-]{11})/',
            '/youtube\.com\/shorts\/([a-zA-Z0-9_-]{11})/',
            '/youtube\.com\/embed\/([a-zA-Z0-9_-]{11})/',
            '/youtube\.com\/live\/([a-zA-Z0-9_-]{11})/',
        ];

        foreach ($patrones as $patron) {
            if (preg_match($patron, $url, $coincidencias)) {
                return $coincidencias[1];
            }
        }

        return null;
    }
}