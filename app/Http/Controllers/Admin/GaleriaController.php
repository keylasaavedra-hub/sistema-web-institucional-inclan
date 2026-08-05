<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArchivoGaleria;
use App\Models\Galeria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class GaleriaController extends Controller
{
    /**
     * Listado administrativo de galerías.
     */
    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('buscar'));
        $estado = $request->input('estado');

        $galerias = Galeria::query()
            ->withCount([
                'archivos',
                'archivosActivos',
            ])
            ->when($buscar !== '', function ($query) use ($buscar) {
                $query->where(function ($subquery) use ($buscar) {
                    $subquery
                        ->where('titulo', 'like', "%{$buscar}%")
                        ->orWhere('descripcion', 'like', "%{$buscar}%")
                        ->orWhere('anio', 'like', "%{$buscar}%");
                });
            })
            ->when(
                in_array($estado, ['activo', 'inactivo'], true),
                fn ($query) => $query->where(
                    'estado',
                    $estado === 'activo'
                )
            )
            ->orderByDesc('anio')
            ->orderBy('orden')
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return view('admin.galerias.index', compact(
            'galerias',
            'buscar',
            'estado'
        ));
    }

    /**
     * Formulario para crear una galería.
     */
    public function crear(): View
    {
        return view('admin.galerias.crear');
    }

    /**
     * Guardar una galería y sus fotografías.
     */
    public function guardar(Request $request): RedirectResponse
    {
        $datos = $request->validate([
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
            'tipo' => [
                'required',
                'in:fotografias',
            ],
            'anio' => [
                'nullable',
                'integer',
                'min:1900',
                'max:' . (now()->year + 1),
            ],
            'orden' => [
                'nullable',
                'integer',
                'min:0',
                'max:9999',
            ],
            'estado' => [
                'nullable',
                'boolean',
            ],

            'imagen_portada' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'fotografias' => [
                'required',
                'array',
                'min:1',
                'max:20',
            ],
            'fotografias.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ], [
            'titulo.required' => 'El título de la galería es obligatorio.',
            'titulo.max' => 'El título no debe superar los 180 caracteres.',
            'tipo.required' => 'Debes seleccionar el tipo de galería.',
            'tipo.in' => 'El tipo de galería seleccionado no es válido.',
            'anio.integer' => 'El año debe ser un número válido.',
            'anio.min' => 'El año ingresado no es válido.',
            'anio.max' => 'El año ingresado no es válido.',

            'imagen_portada.image' => 'La portada debe ser una imagen.',
            'imagen_portada.mimes' => 'La portada debe ser JPG, JPEG, PNG o WEBP.',
            'imagen_portada.max' => 'La portada no debe superar los 5 MB.',

            'fotografias.required' => 'Debes seleccionar al menos una fotografía.',
            'fotografias.array' => 'Las fotografías seleccionadas no son válidas.',
            'fotografias.min' => 'Debes seleccionar al menos una fotografía.',
            'fotografias.max' => 'Solo puedes subir hasta 20 fotografías por vez.',
            'fotografias.*.image' => 'Todos los archivos deben ser imágenes.',
            'fotografias.*.mimes' => 'Las fotografías deben ser JPG, JPEG, PNG o WEBP.',
            'fotografias.*.max' => 'Cada fotografía debe pesar como máximo 5 MB.',
        ]);

        $rutasGuardadas = [];

        DB::beginTransaction();

        try {
            $rutaPortada = null;

            if ($request->hasFile('imagen_portada')) {
                $rutaPortada = $request
                    ->file('imagen_portada')
                    ->store('galerias/portadas', 'public');

                $rutasGuardadas[] = $rutaPortada;
            }

            $galeria = Galeria::create([
                'usuario_id' => auth()->id(),
                'titulo' => $datos['titulo'],
                'descripcion' => $datos['descripcion'] ?? null,
                'tipo' => $datos['tipo'],
                'anio' => $datos['anio'] ?? now()->year,
                'imagen_portada' => $rutaPortada,
                'orden' => $datos['orden'] ?? 0,
                'estado' => $request->boolean('estado'),
            ]);

            foreach ($request->file('fotografias', []) as $indice => $fotografia) {
                $ruta = $fotografia->store(
                    "galerias/{$galeria->id}",
                    'public'
                );

                $rutasGuardadas[] = $ruta;

                $galeria->archivos()->create([
                    'tipo_archivo' => 'imagen',
                    'ruta' => $ruta,
                    'nombre_original' => $fotografia->getClientOriginalName(),
                    'mime_type' => $fotografia->getMimeType(),
                    'tamano_bytes' => $fotografia->getSize(),
                    'titulo' => null,
                    'descripcion' => null,
                    'orden' => $indice,
                    'estado' => true,
                ]);
            }

            /*
             * Cuando no se selecciona una portada independiente,
             * se utiliza la primera fotografía del álbum.
             */
            if (!$galeria->imagen_portada) {
                $primeraFotografia = $galeria
                    ->archivos()
                    ->where('tipo_archivo', 'imagen')
                    ->first();

                if ($primeraFotografia) {
                    $galeria->update([
                        'imagen_portada' => $primeraFotografia->ruta,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.galerias.index')
                ->with(
                    'success',
                    'La galería fue creada correctamente.'
                );
        } catch (Throwable $error) {
            DB::rollBack();

            foreach ($rutasGuardadas as $ruta) {
                Storage::disk('public')->delete($ruta);
            }

            report($error);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'No se pudo crear la galería. Inténtalo nuevamente.'
                );
        }
    }

    /**
     * Formulario para editar una galería.
     */
    public function editar(Galeria $galeria): View
    {
        $galeria->load('archivos');

        return view(
            'admin.galerias.editar',
            compact('galeria')
        );
    }

    /**
     * Actualizar información general y agregar fotografías.
     */
    public function actualizar(
        Request $request,
        Galeria $galeria
    ): RedirectResponse {
        $datos = $request->validate([
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
            'tipo' => [
                'required',
                'in:fotografias',
            ],
            'anio' => [
                'nullable',
                'integer',
                'min:1900',
                'max:' . (now()->year + 1),
            ],
            'orden' => [
                'nullable',
                'integer',
                'min:0',
                'max:9999',
            ],
            'estado' => [
                'nullable',
                'boolean',
            ],
            'imagen_portada' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'fotografias' => [
                'nullable',
                'array',
                'max:20',
            ],
            'fotografias.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        $rutasNuevas = [];
        $portadaAnterior = $galeria->imagen_portada;

        DB::beginTransaction();

        try {
            $rutaPortada = $portadaAnterior;

            if ($request->hasFile('imagen_portada')) {
                $rutaPortada = $request
                    ->file('imagen_portada')
                    ->store('galerias/portadas', 'public');

                $rutasNuevas[] = $rutaPortada;
            }

            $galeria->update([
                'titulo' => $datos['titulo'],
                'descripcion' => $datos['descripcion'] ?? null,
                'tipo' => $datos['tipo'],
                'anio' => $datos['anio'] ?? now()->year,
                'imagen_portada' => $rutaPortada,
                'orden' => $datos['orden'] ?? 0,
                'estado' => $request->boolean('estado'),
            ]);

            $ultimoOrden = (int) $galeria
                ->archivos()
                ->max('orden');

            foreach ($request->file('fotografias', []) as $indice => $fotografia) {
                $ruta = $fotografia->store(
                    "galerias/{$galeria->id}",
                    'public'
                );

                $rutasNuevas[] = $ruta;

                $galeria->archivos()->create([
                    'tipo_archivo' => 'imagen',
                    'ruta' => $ruta,
                    'nombre_original' => $fotografia->getClientOriginalName(),
                    'mime_type' => $fotografia->getMimeType(),
                    'tamano_bytes' => $fotografia->getSize(),
                    'titulo' => null,
                    'descripcion' => null,
                    'orden' => $ultimoOrden + $indice + 1,
                    'estado' => true,
                ]);
            }

            DB::commit();

            if (
                $request->hasFile('imagen_portada') &&
                $portadaAnterior &&
                $portadaAnterior !== $rutaPortada &&
                !$galeria->archivos()
                    ->where('ruta', $portadaAnterior)
                    ->exists()
            ) {
                Storage::disk('public')->delete($portadaAnterior);
            }

            return redirect()
                ->route('admin.galerias.editar', $galeria)
                ->with(
                    'success',
                    'La galería fue actualizada correctamente.'
                );
        } catch (Throwable $error) {
            DB::rollBack();

            foreach ($rutasNuevas as $ruta) {
                Storage::disk('public')->delete($ruta);
            }

            report($error);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'No se pudo actualizar la galería.'
                );
        }
    }

    /**
     * Cambiar el estado de una fotografía.
     */
    public function cambiarEstadoArchivo(
        ArchivoGaleria $archivo
    ): RedirectResponse {
        $archivo->update([
            'estado' => !$archivo->estado,
        ]);

        return back()->with(
            'success',
            $archivo->estado
                ? 'La fotografía fue habilitada.'
                : 'La fotografía fue ocultada.'
        );
    }

    /**
     * Eliminar una fotografía.
     */
    public function eliminarArchivo(
        ArchivoGaleria $archivo
    ): RedirectResponse {
        $galeria = $archivo->galeria;
        $ruta = $archivo->ruta;

        DB::transaction(function () use ($archivo, $galeria, $ruta) {
            $archivo->delete();

            if ($galeria->imagen_portada === $ruta) {
                $nuevaPortada = $galeria
                    ->archivosActivos()
                    ->first();

                $galeria->update([
                    'imagen_portada' => $nuevaPortada?->ruta,
                ]);
            }
        });

        Storage::disk('public')->delete($ruta);

        return back()->with(
            'success',
            'La fotografía fue eliminada correctamente.'
        );
    }

    /**
     * Eliminar una galería completa.
     */
    public function eliminar(
        Galeria $galeria
    ): RedirectResponse {
        $galeria->load('archivos');

        $rutas = $galeria->archivos
            ->pluck('ruta')
            ->filter()
            ->values();

        if (
            $galeria->imagen_portada &&
            !$rutas->contains($galeria->imagen_portada)
        ) {
            $rutas->push($galeria->imagen_portada);
        }

        DB::transaction(function () use ($galeria) {
            $galeria->delete();
        });

        foreach ($rutas as $ruta) {
            Storage::disk('public')->delete($ruta);
        }

        Storage::disk('public')->deleteDirectory(
            "galerias/{$galeria->id}"
        );

        return redirect()
            ->route('admin.galerias.index')
            ->with(
                'success',
                'La galería fue eliminada correctamente.'
            );
    }
}