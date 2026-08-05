<?php

namespace App\Http\Controllers;

use App\Models\CategoriaDocumento;
use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentoController extends Controller
{
    public function index(Request $request): View
    {
        $documentos = Documento::query()
            ->with([
                'categoria:id,nombre',
                'area:id,nombre',
            ])
            ->where('es_publico', true)
            ->where('estado', 'activo')
            ->when(
                $request->filled('buscar'),
                function ($consulta) use ($request) {
                    $buscar = trim($request->buscar);

                    $consulta->where(function ($subconsulta) use ($buscar) {
                        $subconsulta
                            ->where('titulo', 'like', "%{$buscar}%")
                            ->orWhere('descripcion', 'like', "%{$buscar}%")
                            ->orWhere('nombre_original', 'like', "%{$buscar}%");
                    });
                }
            )
            ->when(
                $request->filled('categoria'),
                function ($consulta) use ($request) {
                    $consulta->where(
                        'categoria_documento_id',
                        $request->categoria
                    );
                }
            )
            ->orderByDesc('fecha_publicacion')
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        $categorias = CategoriaDocumento::query()
            ->where('estado', true)
            ->orderBy('nombre')
            ->get([
                'id',
                'nombre',
            ]);

        return view('documentos.index', [
            'documentos' => $documentos,
            'categorias' => $categorias,
        ]);
    }

    public function descargar(Documento $documento): StreamedResponse
    {
        abort_unless(
            $documento->es_publico
                && $documento->estado === 'activo',
            404
        );

        abort_unless(
            Storage::disk('public')->exists($documento->archivo),
            404,
            'El archivo solicitado no fue encontrado.'
        );

        return Storage::disk('public')->download(
            $documento->archivo,
            $documento->nombre_original
        );
    }
}