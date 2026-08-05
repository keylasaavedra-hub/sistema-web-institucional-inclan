<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoriaPublicacion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoriaPublicacionController extends Controller
{
    public function index(): View
    {
        $categorias = CategoriaPublicacion::query()
            ->withCount('publicaciones')
            ->orderBy('nombre')
            ->get();

        return view(
            'admin.categorias-publicacion.index',
            compact('categorias')
        );
    }

    public function guardar(Request $request): RedirectResponse
    {
        $datos = $this->validar($request);

        CategoriaPublicacion::create([
            'nombre' => $datos['nombre'],
            'descripcion' => $datos['descripcion'] ?? null,
            'estado' => $request->boolean('estado'),
        ]);

        return redirect()
            ->route('admin.categorias-publicacion.index')
            ->with(
                'success',
                'La categoría fue registrada correctamente.'
            );
    }

    public function actualizar(
        Request $request,
        CategoriaPublicacion $categoria
    ): RedirectResponse {
        $datos = $this->validar($request, $categoria);

        $categoria->update([
            'nombre' => $datos['nombre'],
            'descripcion' => $datos['descripcion'] ?? null,
            'estado' => $request->boolean('estado'),
        ]);

        return redirect()
            ->route('admin.categorias-publicacion.index')
            ->with(
                'success',
                'La categoría fue actualizada correctamente.'
            );
    }

    public function cambiarEstado(
        CategoriaPublicacion $categoria
    ): RedirectResponse {
        $categoria->update([
            'estado' => ! $categoria->estado,
        ]);

        $mensaje = $categoria->estado
            ? 'La categoría fue activada correctamente.'
            : 'La categoría fue desactivada correctamente.';

        return redirect()
            ->route('admin.categorias-publicacion.index')
            ->with('success', $mensaje);
    }

    public function eliminar(
        CategoriaPublicacion $categoria
    ): RedirectResponse {
        if ($categoria->publicaciones()->exists()) {
            return redirect()
                ->route('admin.categorias-publicacion.index')
                ->with(
                    'error',
                    'No se puede eliminar la categoría porque tiene publicaciones asociadas.'
                );
        }

        $categoria->delete();

        return redirect()
            ->route('admin.categorias-publicacion.index')
            ->with(
                'success',
                'La categoría fue eliminada correctamente.'
            );
    }

    private function validar(
        Request $request,
        ?CategoriaPublicacion $categoria = null
    ): array {
        return $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique(
                    'categorias_publicacion',
                    'nombre'
                )->ignore($categoria?->id),
            ],
            'descripcion' => [
                'nullable',
                'string',
                'max:200',
            ],
            'estado' => [
                'nullable',
                'boolean',
            ],
        ], [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.max' => 'El nombre no debe superar los 100 caracteres.',
            'nombre.unique' => 'Ya existe una categoría con ese nombre.',
            'descripcion.max' => 'La descripción no debe superar los 200 caracteres.',
        ]);
    }
}