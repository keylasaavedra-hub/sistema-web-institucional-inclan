<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoriaPublicacion;
use App\Models\Publicacion;
use App\Services\AuditoriaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Throwable;

class PublicacionController extends Controller
{
    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('buscar'));
        $categoriaId = $request->integer('categoria_publicacion_id');
        $estado = $request->input('estado');
        $destacada = $request->input('destacada');

        $publicaciones = Publicacion::query()
            ->with([
                'categoria:id,nombre',
                'usuario:id,name,apellidos',
            ])
            ->when($buscar !== '', function ($query) use ($buscar) {
                $query->where(function ($subquery) use ($buscar) {
                    $subquery
                        ->where('titulo', 'like', "%{$buscar}%")
                        ->orWhere('contenido', 'like', "%{$buscar}%")
                        ->orWhere('slug', 'like', "%{$buscar}%");
                });
            })
            ->when(
                $categoriaId > 0,
                fn($query) => $query->where(
                    'categoria_publicacion_id',
                    $categoriaId
                )
            )
            ->when(
                in_array(
                    $estado,
                    ['borrador', 'publicado', 'archivado'],
                    true
                ),
                fn($query) => $query->where('estado', $estado)
            )
            ->when(
                in_array($destacada, ['si', 'no'], true),
                fn($query) => $query->where(
                    'destacada',
                    $destacada === 'si'
                )
            )
            ->orderByDesc('destacada')
            ->orderByDesc('fecha_publicacion')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        $categorias = CategoriaPublicacion::query()
            ->activas()
            ->orderBy('nombre')
            ->get();

        return view('admin.publicaciones.index', compact(
            'publicaciones',
            'categorias',
            'buscar',
            'categoriaId',
            'estado',
            'destacada'
        ));
    }

    public function crear(): View
    {
        $categorias = CategoriaPublicacion::query()
            ->activas()
            ->orderBy('nombre')
            ->get();

        return view(
            'admin.publicaciones.crear',
            compact('categorias')
        );
    }

    public function guardar(Request $request): RedirectResponse
    {
        $datos = $this->validar($request);

        $rutaPortada = null;
        $rutaAdjunto = null;

        DB::beginTransaction();

        try {
            if ($request->hasFile('imagen_portada')) {
                $rutaPortada = $request
                    ->file('imagen_portada')
                    ->store(
                        'publicaciones/portadas',
                        'public'
                    );
            }

            if ($request->hasFile('archivo_adjunto')) {
                $rutaAdjunto = $request
                    ->file('archivo_adjunto')
                    ->store(
                        'publicaciones/adjuntos',
                        'public'
                    );
            }

            $publicacion = Publicacion::create([
                'categoria_publicacion_id' =>
                $datos['categoria_publicacion_id'],

                'usuario_id' => auth()->id(),
                'titulo' => $datos['titulo'],
                'slug' => $this->generarSlug($datos['titulo']),
                'contenido' => $datos['contenido'],
                'imagen_portada' => $rutaPortada,
                'archivo_adjunto' => $rutaAdjunto,

                'fecha_publicacion' =>
                $datos['fecha_publicacion'] ?? null,

                'fecha_vencimiento' =>
                $datos['fecha_vencimiento'] ?? null,

                'destacada' =>
                $request->boolean('destacada'),

                'estado' => $datos['estado'],
            ]);

            AuditoriaService::registrar(
                modulo: 'Publicaciones',
                accion: 'crear',
                modelo: $publicacion,
                valoresAnteriores: null,
                valoresNuevos: $this->datosAuditoria(
                    $publicacion
                ),
                descripcion: sprintf(
                    'Se creó la publicación "%s" con estado %s.',
                    $publicacion->titulo,
                    $publicacion->estado
                )
            );

            DB::commit();

            return redirect()
                ->route('admin.publicaciones.index')
                ->with(
                    'success',
                    'La publicación fue registrada correctamente.'
                );
        } catch (Throwable $error) {
            DB::rollBack();

            if ($rutaPortada) {
                Storage::disk('public')->delete(
                    $rutaPortada
                );
            }

            if ($rutaAdjunto) {
                Storage::disk('public')->delete(
                    $rutaAdjunto
                );
            }

            report($error);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'No se pudo registrar la publicación.'
                );
        }
    }

    public function editar(
        Publicacion $publicacion
    ): View {
        $publicacion->load([
            'categoria',
            'usuario',
        ]);

        $categorias = CategoriaPublicacion::query()
            ->activas()
            ->orderBy('nombre')
            ->get();

        return view(
            'admin.publicaciones.editar',
            compact(
                'publicacion',
                'categorias'
            )
        );
    }

    public function actualizar(
        Request $request,
        Publicacion $publicacion
    ): RedirectResponse {
        $datos = $this->validar($request);

        $valoresAnteriores = $this->datosAuditoria(
            $publicacion
        );

        $estadoAnterior = $publicacion->estado;
        $portadaAnterior = $publicacion->imagen_portada;
        $adjuntoAnterior = $publicacion->archivo_adjunto;

        $portadaNueva = null;
        $adjuntoNuevo = null;

        DB::beginTransaction();

        try {
            $rutaPortada = $portadaAnterior;
            $rutaAdjunto = $adjuntoAnterior;

            if ($request->hasFile('imagen_portada')) {
                $portadaNueva = $request
                    ->file('imagen_portada')
                    ->store(
                        'publicaciones/portadas',
                        'public'
                    );

                $rutaPortada = $portadaNueva;
            }

            if ($request->hasFile('archivo_adjunto')) {
                $adjuntoNuevo = $request
                    ->file('archivo_adjunto')
                    ->store(
                        'publicaciones/adjuntos',
                        'public'
                    );

                $rutaAdjunto = $adjuntoNuevo;
            }

            if ($request->boolean('eliminar_portada')) {
                $rutaPortada = null;
            }

            if ($request->boolean('eliminar_adjunto')) {
                $rutaAdjunto = null;
            }

            $publicacion->update([
                'categoria_publicacion_id' =>
                $datos['categoria_publicacion_id'],

                'usuario_id' => auth()->id(),
                'titulo' => $datos['titulo'],

                'slug' => $this->generarSlug(
                    $datos['titulo'],
                    $publicacion->id
                ),

                'contenido' => $datos['contenido'],
                'imagen_portada' => $rutaPortada,
                'archivo_adjunto' => $rutaAdjunto,

                'fecha_publicacion' =>
                $datos['fecha_publicacion'] ?? null,

                'fecha_vencimiento' =>
                $datos['fecha_vencimiento'] ?? null,

                'destacada' =>
                $request->boolean('destacada'),

                'estado' => $datos['estado'],
            ]);

            $publicacion->refresh();

            $estadoCambio = $estadoAnterior
                !== $publicacion->estado;

            AuditoriaService::registrar(
                modulo: 'Publicaciones',
                accion: $estadoCambio
                    ? 'cambiar_estado'
                    : 'actualizar',
                modelo: $publicacion,
                valoresAnteriores: $valoresAnteriores,
                valoresNuevos: $this->datosAuditoria(
                    $publicacion
                ),
                descripcion: $estadoCambio
                    ? sprintf(
                        'Se actualizó la publicación "%s" y su estado cambió de %s a %s.',
                        $publicacion->titulo,
                        $estadoAnterior,
                        $publicacion->estado
                    )
                    : sprintf(
                        'Se actualizó la publicación "%s".',
                        $publicacion->titulo
                    )
            );

            DB::commit();

            if (
                (
                    $portadaNueva
                    || $request->boolean(
                        'eliminar_portada'
                    )
                )
                && $portadaAnterior
            ) {
                Storage::disk('public')->delete(
                    $portadaAnterior
                );
            }

            if (
                (
                    $adjuntoNuevo
                    || $request->boolean(
                        'eliminar_adjunto'
                    )
                )
                && $adjuntoAnterior
            ) {
                Storage::disk('public')->delete(
                    $adjuntoAnterior
                );
            }

            return redirect()
                ->route(
                    'admin.publicaciones.editar',
                    $publicacion->id
                )
                ->with(
                    'success',
                    'La publicación fue actualizada correctamente.'
                );
        } catch (Throwable $error) {
            DB::rollBack();

            if ($portadaNueva) {
                Storage::disk('public')->delete(
                    $portadaNueva
                );
            }

            if ($adjuntoNuevo) {
                Storage::disk('public')->delete(
                    $adjuntoNuevo
                );
            }

            report($error);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'No se pudo actualizar la publicación.'
                );
        }
    }

    public function eliminar(
        Publicacion $publicacion
    ): RedirectResponse {
        $rutas = collect([
            $publicacion->imagen_portada,
            $publicacion->archivo_adjunto,
        ])->filter();

        $valoresAnteriores = $this->datosAuditoria(
            $publicacion
        );

        $titulo = $publicacion->titulo;

        try {
            DB::transaction(function () use (
                $publicacion,
                $valoresAnteriores,
                $titulo
            ) {
                AuditoriaService::registrar(
                    modulo: 'Publicaciones',
                    accion: 'eliminar',
                    modelo: $publicacion,
                    valoresAnteriores: $valoresAnteriores,
                    valoresNuevos: null,
                    descripcion: sprintf(
                        'Se eliminó la publicación "%s".',
                        $titulo
                    )
                );

                $publicacion->delete();
            });

            foreach ($rutas as $ruta) {
                Storage::disk('public')->delete($ruta);
            }

            return redirect()
                ->route('admin.publicaciones.index')
                ->with(
                    'success',
                    'La publicación fue eliminada correctamente.'
                );
        } catch (Throwable $error) {
            report($error);

            return back()->with(
                'error',
                'No se pudo eliminar la publicación.'
            );
        }
    }

    private function validar(Request $request): array
    {
        return $request->validate([
            'categoria_publicacion_id' => [
                'required',
                'integer',
                Rule::exists(
                    'categorias_publicacion',
                    'id'
                )->where(
                    fn($query) =>
                    $query->where('estado', true)
                ),
            ],

            'titulo' => [
                'required',
                'string',
                'max:200',
            ],

            'contenido' => [
                'required',
                'string',
                'max:30000',
            ],

            'imagen_portada' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'archivo_adjunto' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip',
                'max:20480',
            ],

            'fecha_publicacion' => [
                'nullable',
                'date',
            ],

            'fecha_vencimiento' => [
                'nullable',
                'date',
                'after_or_equal:fecha_publicacion',
            ],

            'destacada' => [
                'nullable',
                'boolean',
            ],

            'estado' => [
                'required',
                Rule::in([
                    'borrador',
                    'publicado',
                    'archivado',
                ]),
            ],

            'eliminar_portada' => [
                'nullable',
                'boolean',
            ],

            'eliminar_adjunto' => [
                'nullable',
                'boolean',
            ],
        ], [
            'categoria_publicacion_id.required' =>
            'Selecciona una categoría.',

            'categoria_publicacion_id.exists' =>
            'La categoría seleccionada no es válida.',

            'titulo.required' =>
            'El título es obligatorio.',

            'titulo.max' =>
            'El título no debe superar los 200 caracteres.',

            'contenido.required' =>
            'El contenido es obligatorio.',

            'contenido.max' =>
            'El contenido es demasiado extenso.',

            'imagen_portada.image' =>
            'La portada debe ser una imagen.',

            'imagen_portada.mimes' =>
            'La portada debe ser JPG, JPEG, PNG o WEBP.',

            'imagen_portada.max' =>
            'La portada no debe superar los 5 MB.',

            'archivo_adjunto.mimes' =>
            'El adjunto debe ser PDF, Word, Excel, PowerPoint, TXT o ZIP.',

            'archivo_adjunto.max' =>
            'El adjunto no debe superar los 20 MB.',

            'fecha_vencimiento.after_or_equal' =>
            'La fecha de vencimiento no puede ser anterior a la publicación.',

            'estado.required' =>
            'Selecciona un estado.',

            'estado.in' =>
            'El estado seleccionado no es válido.',
        ]);
    }

    private function generarSlug(
        string $titulo,
        ?int $ignorarId = null
    ): string {
        $base = Str::slug($titulo);

        $slug = $base !== ''
            ? $base
            : 'publicacion';

        $contador = 2;

        while (
            Publicacion::query()
            ->when(
                $ignorarId,
                fn($query) =>
                $query->whereKeyNot($ignorarId)
            )
            ->where('slug', $slug)
            ->exists()
        ) {
            $slug = "{$base}-{$contador}";
            $contador++;
        }

        return $slug;
    }

    private function datosAuditoria(
        Publicacion $publicacion
    ): array {
        return [
            'id' => $publicacion->id,

            'categoria_publicacion_id' =>
            $publicacion->categoria_publicacion_id,

            'usuario_id' =>
            $publicacion->usuario_id,

            'titulo' =>
            $publicacion->titulo,

            'slug' =>
            $publicacion->slug,

            'contenido' =>
            $publicacion->contenido,

            'imagen_portada' =>
            $publicacion->imagen_portada,

            'archivo_adjunto' =>
            $publicacion->archivo_adjunto,

            'fecha_publicacion' =>
            $publicacion->fecha_publicacion,

            'fecha_vencimiento' =>
            $publicacion->fecha_vencimiento,

            'destacada' =>
            (bool) $publicacion->destacada,

            'estado' =>
            $publicacion->estado,

            'created_at' =>
            $publicacion->created_at,

            'updated_at' =>
            $publicacion->updated_at,
        ];
    }
}
