<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ImagenPromocion;
use App\Models\NivelEducativo;
use App\Models\Promocion;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Throwable;

class PromocionController extends Controller
{
    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('buscar'));
        $estado = $request->input('estado');
        $nivelId = $request->integer('nivel_educativo_id');
        $anio = $request->integer('anio');

        $promociones = Promocion::query()
            ->with('nivelEducativo')
            ->withCount([
                'imagenes',
                'imagenesActivas',
            ])
            ->when($buscar !== '', function ($query) use ($buscar) {
                $query->where(function ($subquery) use ($buscar) {
                    $subquery
                        ->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('lema', 'like', "%{$buscar}%")
                        ->orWhere('descripcion', 'like', "%{$buscar}%");
                });
            })
            ->when(
                in_array($estado, ['publicada', 'oculta'], true),
                fn ($query) => $query->where(
                    'estado',
                    $estado === 'publicada'
                )
            )
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
            ->distinct()
            ->orderByDesc('anio')
            ->pluck('anio');

        return view('admin.promociones.index', compact(
            'promociones',
            'niveles',
            'anios',
            'buscar',
            'estado',
            'nivelId',
            'anio'
        ));
    }

    public function crear(): View
    {
        $niveles = NivelEducativo::query()
            ->activos()
            ->orderBy('id')
            ->get();

        return view('admin.promociones.crear', compact('niveles'));
    }

    public function guardar(Request $request): RedirectResponse
    {
        $datos = $this->validar($request);

        $rutasGuardadas = [];

        DB::beginTransaction();

        try {
            $rutaPortada = null;

            if ($request->hasFile('imagen_portada')) {
                $rutaPortada = $request
                    ->file('imagen_portada')
                    ->store('promociones/portadas', 'public');

                $rutasGuardadas[] = $rutaPortada;
            }

            $promocion = Promocion::create([
                'nivel_educativo_id' => $datos['nivel_educativo_id'],
                'usuario_id' => auth()->id(),
                'nombre' => $datos['nombre'],
                'anio' => $datos['anio'],
                'lema' => $datos['lema'] ?? null,
                'descripcion' => $datos['descripcion'] ?? null,
                'imagen_portada' => $rutaPortada,
                'estado' => $request->boolean('estado'),
            ]);

            foreach ($request->file('imagenes', []) as $indice => $imagen) {
                $ruta = $imagen->store(
                    "promociones/{$promocion->id}",
                    'public'
                );

                $rutasGuardadas[] = $ruta;

                $promocion->imagenes()->create([
                    'ruta' => $ruta,
                    'nombre_original' => $imagen->getClientOriginalName(),
                    'mime_type' => $imagen->getMimeType(),
                    'tamano_bytes' => $imagen->getSize(),
                    'titulo' => null,
                    'descripcion' => null,
                    'orden' => $indice,
                    'estado' => true,
                ]);
            }

            if (!$promocion->imagen_portada) {
                $primeraImagen = $promocion->imagenes()->first();

                if ($primeraImagen) {
                    $promocion->update([
                        'imagen_portada' => $primeraImagen->ruta,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.promociones.index')
                ->with(
                    'success',
                    'La promoción fue registrada correctamente.'
                );
        } catch (QueryException $error) {
            DB::rollBack();

            foreach ($rutasGuardadas as $ruta) {
                Storage::disk('public')->delete($ruta);
            }

            if ((string) $error->getCode() === '23000') {
                return back()
                    ->withInput()
                    ->withErrors([
                        'nombre' => 'Ya existe una promoción con ese nombre, año y nivel educativo.',
                    ]);
            }

            report($error);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'No se pudo registrar la promoción.'
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
                    'No se pudo registrar la promoción.'
                );
        }
    }

    public function editar(Promocion $promocion): View
    {
        $promocion->load([
            'nivelEducativo',
            'imagenes',
        ]);

        $niveles = NivelEducativo::query()
            ->activos()
            ->orderBy('id')
            ->get();

        return view('admin.promociones.editar', compact(
            'promocion',
            'niveles'
        ));
    }

    public function actualizar(
        Request $request,
        Promocion $promocion
    ): RedirectResponse {
        $datos = $this->validar($request, $promocion);

        $rutasNuevas = [];
        $portadaAnterior = $promocion->imagen_portada;

        DB::beginTransaction();

        try {
            $rutaPortada = $portadaAnterior;

            if ($request->hasFile('imagen_portada')) {
                $rutaPortada = $request
                    ->file('imagen_portada')
                    ->store('promociones/portadas', 'public');

                $rutasNuevas[] = $rutaPortada;
            }

            $promocion->update([
                'nivel_educativo_id' => $datos['nivel_educativo_id'],
                'nombre' => $datos['nombre'],
                'anio' => $datos['anio'],
                'lema' => $datos['lema'] ?? null,
                'descripcion' => $datos['descripcion'] ?? null,
                'imagen_portada' => $rutaPortada,
                'estado' => $request->boolean('estado'),
            ]);

            $ultimoOrden = (int) $promocion
                ->imagenes()
                ->max('orden');

            foreach ($request->file('imagenes', []) as $indice => $imagen) {
                $ruta = $imagen->store(
                    "promociones/{$promocion->id}",
                    'public'
                );

                $rutasNuevas[] = $ruta;

                $promocion->imagenes()->create([
                    'ruta' => $ruta,
                    'nombre_original' => $imagen->getClientOriginalName(),
                    'mime_type' => $imagen->getMimeType(),
                    'tamano_bytes' => $imagen->getSize(),
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
                !$promocion->imagenes()
                    ->where('ruta', $portadaAnterior)
                    ->exists()
            ) {
                Storage::disk('public')->delete($portadaAnterior);
            }

            return redirect()
                ->route('admin.promociones.editar', $promocion)
                ->with(
                    'success',
                    'La promoción fue actualizada correctamente.'
                );
        } catch (QueryException $error) {
            DB::rollBack();

            foreach ($rutasNuevas as $ruta) {
                Storage::disk('public')->delete($ruta);
            }

            if ((string) $error->getCode() === '23000') {
                return back()
                    ->withInput()
                    ->withErrors([
                        'nombre' => 'Ya existe otra promoción con ese nombre, año y nivel educativo.',
                    ]);
            }

            report($error);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'No se pudo actualizar la promoción.'
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
                    'No se pudo actualizar la promoción.'
                );
        }
    }

    public function cambiarEstadoImagen(
        ImagenPromocion $imagen
    ): RedirectResponse {
        $imagen->update([
            'estado' => !$imagen->estado,
        ]);

        return back()->with(
            'success',
            $imagen->estado
                ? 'La imagen fue habilitada.'
                : 'La imagen fue ocultada.'
        );
    }

    public function eliminarImagen(
        ImagenPromocion $imagen
    ): RedirectResponse {
        $promocion = $imagen->promocion;
        $ruta = $imagen->ruta;

        DB::transaction(function () use ($imagen, $promocion, $ruta) {
            $imagen->delete();

            if ($promocion->imagen_portada === $ruta) {
                $nuevaPortada = $promocion
                    ->imagenesActivas()
                    ->first();

                $promocion->update([
                    'imagen_portada' => $nuevaPortada?->ruta,
                ]);
            }
        });

        Storage::disk('public')->delete($ruta);

        return back()->with(
            'success',
            'La imagen fue eliminada correctamente.'
        );
    }

    public function eliminar(
        Promocion $promocion
    ): RedirectResponse {
        $promocion->load('imagenes');

        $rutas = $promocion->imagenes
            ->pluck('ruta')
            ->filter()
            ->values();

        if (
            $promocion->imagen_portada &&
            !$rutas->contains($promocion->imagen_portada)
        ) {
            $rutas->push($promocion->imagen_portada);
        }

        DB::transaction(function () use ($promocion) {
            $promocion->delete();
        });

        foreach ($rutas as $ruta) {
            Storage::disk('public')->delete($ruta);
        }

        Storage::disk('public')->deleteDirectory(
            "promociones/{$promocion->id}"
        );

        return redirect()
            ->route('admin.promociones.index')
            ->with(
                'success',
                'La promoción fue eliminada correctamente.'
            );
    }

    private function validar(
        Request $request,
        ?Promocion $promocion = null
    ): array {
        return $request->validate([
            'nivel_educativo_id' => [
                'required',
                'integer',
                Rule::exists('niveles_educativos', 'id')
                    ->where(fn ($query) => $query->where('estado', true)),
            ],
            'nombre' => [
                'required',
                'string',
                'max:180',
            ],
            'anio' => [
                'required',
                'integer',
                'min:1900',
                'max:' . (now()->year + 1),
            ],
            'lema' => [
                'nullable',
                'string',
                'max:255',
            ],
            'descripcion' => [
                'nullable',
                'string',
                'max:3000',
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
            'imagenes' => [
                $promocion ? 'nullable' : 'required',
                'array',
                $promocion ? 'max:20' : 'min:1',
                'max:20',
            ],
            'imagenes.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ], [
            'nivel_educativo_id.required' => 'Selecciona un nivel educativo.',
            'nivel_educativo_id.exists' => 'El nivel educativo seleccionado no es válido.',
            'nombre.required' => 'El nombre de la promoción es obligatorio.',
            'nombre.max' => 'El nombre no debe superar los 180 caracteres.',
            'anio.required' => 'El año es obligatorio.',
            'anio.integer' => 'El año debe ser un número válido.',
            'anio.min' => 'El año ingresado no es válido.',
            'anio.max' => 'El año ingresado no es válido.',
            'lema.max' => 'El lema no debe superar los 255 caracteres.',
            'imagen_portada.image' => 'La portada debe ser una imagen.',
            'imagen_portada.mimes' => 'La portada debe ser JPG, JPEG, PNG o WEBP.',
            'imagen_portada.max' => 'La portada no debe superar los 5 MB.',
            'imagenes.required' => 'Debes seleccionar al menos una imagen.',
            'imagenes.array' => 'Las imágenes seleccionadas no son válidas.',
            'imagenes.min' => 'Debes seleccionar al menos una imagen.',
            'imagenes.max' => 'Solo puedes subir hasta 20 imágenes por vez.',
            'imagenes.*.image' => 'Todos los archivos deben ser imágenes.',
            'imagenes.*.mimes' => 'Las imágenes deben ser JPG, JPEG, PNG o WEBP.',
            'imagenes.*.max' => 'Cada imagen debe pesar como máximo 5 MB.',
        ]);
    }
}