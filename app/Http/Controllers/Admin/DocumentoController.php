<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AreaInstitucional;
use App\Models\CategoriaDocumento;
use App\Models\Documento;
use App\Models\VersionDocumento;
use App\Services\AuditoriaService;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class DocumentoController extends Controller
{
    public function index(Request $request): View
    {
        $buscar = trim((string) $request->input('buscar'));
        $categoriaId = $request->integer('categoria_documento_id');
        $areaId = $request->integer('area_id');
        $estado = $request->input('estado');
        $visibilidad = $request->input('visibilidad');

        $documentos = Documento::query()
            ->with([
                'categoria:id,nombre',
                'area:id,nombre',
                'usuario:id,name,apellidos',
            ])
            ->withCount('versiones')
            ->when($buscar !== '', function ($query) use ($buscar) {
                $query->where(function ($subquery) use ($buscar) {
                    $subquery
                        ->where('titulo', 'like', "%{$buscar}%")
                        ->orWhere('descripcion', 'like', "%{$buscar}%")
                        ->orWhere('nombre_original', 'like', "%{$buscar}%")
                        ->orWhere('version', 'like', "%{$buscar}%");
                });
            })
            ->when(
                $categoriaId > 0,
                fn ($query) => $query->where(
                    'categoria_documento_id',
                    $categoriaId
                )
            )
            ->when(
                $areaId > 0,
                fn ($query) => $query->where(
                    'area_id',
                    $areaId
                )
            )
            ->when(
                in_array(
                    $estado,
                    ['activo', 'inactivo'],
                    true
                ),
                fn ($query) => $query->where(
                    'estado',
                    $estado
                )
            )
            ->when(
                in_array(
                    $visibilidad,
                    ['publico', 'interno'],
                    true
                ),
                fn ($query) => $query->where(
                    'es_publico',
                    $visibilidad === 'publico'
                )
            )
            ->orderByDesc('fecha_publicacion')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        $categorias = CategoriaDocumento::query()
            ->where('estado', true)
            ->orderBy('nombre')
            ->get();

        $areas = AreaInstitucional::query()
            ->where('estado', true)
            ->orderBy('nombre')
            ->get();

        return view('admin.documentos.index', compact(
            'documentos',
            'categorias',
            'areas',
            'buscar',
            'categoriaId',
            'areaId',
            'estado',
            'visibilidad'
        ));
    }

    public function crear(): View
    {
        $categorias = CategoriaDocumento::query()
            ->where('estado', true)
            ->orderBy('nombre')
            ->get();

        $areas = AreaInstitucional::query()
            ->where('estado', true)
            ->orderBy('nombre')
            ->get();

        return view('admin.documentos.crear', compact(
            'categorias',
            'areas'
        ));
    }

    public function guardar(
        Request $request
    ): RedirectResponse {
        $datos = $this->validarDocumento(
            $request,
            true
        );

        $rutaGuardada = null;

        DB::beginTransaction();

        try {
            $archivo = $request->file('archivo');

            $rutaGuardada = $archivo->store(
                'documentos',
                'public'
            );

            $documento = Documento::create([
                'categoria_documento_id' =>
                    $datos['categoria_documento_id'],

                'area_id' =>
                    $datos['area_id'] ?? null,

                'usuario_id' =>
                    auth()->id(),

                'titulo' =>
                    $datos['titulo'],

                'descripcion' =>
                    $datos['descripcion'] ?? null,

                'archivo' =>
                    $rutaGuardada,

                'nombre_original' =>
                    $archivo->getClientOriginalName(),

                'tipo_archivo' =>
                    $archivo->getMimeType(),

                'tamano_bytes' =>
                    $archivo->getSize(),

                'version' =>
                    $datos['version'],

                'fecha_publicacion' =>
                    $datos['fecha_publicacion']
                    ?? now()->toDateString(),

                'es_publico' =>
                    $request->boolean('es_publico'),

                'estado' =>
                    $datos['estado'],
            ]);

            $versionInicial = $documento
                ->versiones()
                ->create([
                    'usuario_id' =>
                        auth()->id(),

                    'version' =>
                        $datos['version'],

                    'archivo' =>
                        $rutaGuardada,

                    'nombre_original' =>
                        $archivo->getClientOriginalName(),

                    'tipo_archivo' =>
                        $archivo->getMimeType(),

                    'tamano_bytes' =>
                        $archivo->getSize(),

                    'descripcion_cambio' =>
                        'Versión inicial del documento.',
                ]);

            AuditoriaService::registrar(
                modulo: 'Documentos',
                accion: 'crear',
                modelo: $documento,
                valoresAnteriores: null,
                valoresNuevos: [
                    'documento' =>
                        $this->datosAuditoriaDocumento(
                            $documento
                        ),

                    'version_inicial' =>
                        $this->datosAuditoriaVersion(
                            $versionInicial
                        ),
                ],
                descripcion: sprintf(
                    'Se creó el documento "%s" con la versión %s.',
                    $documento->titulo,
                    $documento->version
                )
            );

            DB::commit();

            return redirect()
                ->route('admin.documentos.index')
                ->with(
                    'success',
                    'El documento fue registrado correctamente.'
                );
        } catch (QueryException $error) {
            DB::rollBack();

            if ($rutaGuardada) {
                Storage::disk('public')
                    ->delete($rutaGuardada);
            }

            report($error);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'No se pudo registrar el documento.'
                );
        } catch (Throwable $error) {
            DB::rollBack();

            if ($rutaGuardada) {
                Storage::disk('public')
                    ->delete($rutaGuardada);
            }

            report($error);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'No se pudo registrar el documento.'
                );
        }
    }

    public function editar(
        Documento $documento
    ): View {
        $documento->load([
            'categoria',
            'area',
            'usuario',
            'versiones.usuario',
        ]);

        $categorias = CategoriaDocumento::query()
            ->where('estado', true)
            ->orderBy('nombre')
            ->get();

        $areas = AreaInstitucional::query()
            ->where('estado', true)
            ->orderBy('nombre')
            ->get();

        return view('admin.documentos.editar', compact(
            'documento',
            'categorias',
            'areas'
        ));
    }

    public function actualizar(
        Request $request,
        Documento $documento
    ): RedirectResponse {
        $datos = $this->validarDocumento(
            $request,
            false
        );

        $valoresAnteriores =
            $this->datosAuditoriaDocumento(
                $documento
            );

        $estadoAnterior = $documento->estado;
        $visibilidadAnterior =
            (bool) $documento->es_publico;

        DB::beginTransaction();

        try {
            $documento->update([
                'categoria_documento_id' =>
                    $datos['categoria_documento_id'],

                'area_id' =>
                    $datos['area_id'] ?? null,

                'titulo' =>
                    $datos['titulo'],

                'descripcion' =>
                    $datos['descripcion'] ?? null,

                'fecha_publicacion' =>
                    $datos['fecha_publicacion'] ?? null,

                'es_publico' =>
                    $request->boolean('es_publico'),

                'estado' =>
                    $datos['estado'],
            ]);

            $documento->refresh();

            $estadoCambio =
                $estadoAnterior !== $documento->estado;

            $visibilidadCambio =
                $visibilidadAnterior
                !== (bool) $documento->es_publico;

            $accion = 'actualizar';

            if ($estadoCambio) {
                $accion = 'cambiar_estado';
            } elseif ($visibilidadCambio) {
                $accion = 'cambiar_visibilidad';
            }

            $descripcion = sprintf(
                'Se actualizaron los datos del documento "%s".',
                $documento->titulo
            );

            if ($estadoCambio) {
                $descripcion = sprintf(
                    'Se actualizó el documento "%s" y su estado cambió de %s a %s.',
                    $documento->titulo,
                    $estadoAnterior,
                    $documento->estado
                );
            } elseif ($visibilidadCambio) {
                $descripcion = sprintf(
                    'Se actualizó el documento "%s" y su visibilidad cambió de %s a %s.',
                    $documento->titulo,
                    $visibilidadAnterior
                        ? 'público'
                        : 'interno',
                    $documento->es_publico
                        ? 'público'
                        : 'interno'
                );
            }

            AuditoriaService::registrar(
                modulo: 'Documentos',
                accion: $accion,
                modelo: $documento,
                valoresAnteriores:
                    $valoresAnteriores,
                valoresNuevos:
                    $this->datosAuditoriaDocumento(
                        $documento
                    ),
                descripcion: $descripcion
            );

            DB::commit();

            return redirect()
                ->route(
                    'admin.documentos.editar',
                    $documento->id
                )
                ->with(
                    'success',
                    'Los datos del documento fueron actualizados.'
                );
        } catch (Throwable $error) {
            DB::rollBack();

            report($error);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'No se pudo actualizar el documento.'
                );
        }
    }

    public function nuevaVersion(
        Request $request,
        Documento $documento
    ): RedirectResponse {
        $datos = $request->validate([
            'version' => [
                'required',
                'string',
                'max:20',

                Rule::unique(
                    'versiones_documento',
                    'version'
                )->where(
                    fn ($query) =>
                        $query->where(
                            'documento_id',
                            $documento->id
                        )
                ),
            ],

            'archivo_version' => [
                'required',
                'file',
                'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip',
                'max:20480',
            ],

            'descripcion_cambio' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ], [
            'version.required' =>
                'La versión es obligatoria.',

            'version.unique' =>
                'Esa versión ya existe para este documento.',

            'archivo_version.required' =>
                'Selecciona el archivo de la nueva versión.',

            'archivo_version.mimes' =>
                'El archivo debe ser PDF, Word, Excel, PowerPoint, TXT o ZIP.',

            'archivo_version.max' =>
                'El archivo no debe superar los 20 MB.',
        ]);

        $archivo = $request->file(
            'archivo_version'
        );

        $rutaNueva = null;

        $valoresAnteriores =
            $this->datosAuditoriaDocumento(
                $documento
            );

        DB::beginTransaction();

        try {
            $rutaNueva = $archivo->store(
                "documentos/{$documento->id}/versiones",
                'public'
            );

            $version = VersionDocumento::create([
                'documento_id' =>
                    $documento->id,

                'usuario_id' =>
                    auth()->id(),

                'version' =>
                    $datos['version'],

                'archivo' =>
                    $rutaNueva,

                'nombre_original' =>
                    $archivo->getClientOriginalName(),

                'tipo_archivo' =>
                    $archivo->getMimeType(),

                'tamano_bytes' =>
                    $archivo->getSize(),

                'descripcion_cambio' =>
                    $datos['descripcion_cambio'] ?? null,
            ]);

            $documento->update([
                'archivo' =>
                    $rutaNueva,

                'nombre_original' =>
                    $archivo->getClientOriginalName(),

                'tipo_archivo' =>
                    $archivo->getMimeType(),

                'tamano_bytes' =>
                    $archivo->getSize(),

                'version' =>
                    $datos['version'],

                'usuario_id' =>
                    auth()->id(),
            ]);

            $documento->refresh();

            AuditoriaService::registrar(
                modulo: 'Documentos',
                accion: 'nueva_version',
                modelo: $documento,
                valoresAnteriores: [
                    'documento' =>
                        $valoresAnteriores,
                ],
                valoresNuevos: [
                    'documento' =>
                        $this->datosAuditoriaDocumento(
                            $documento
                        ),

                    'nueva_version' =>
                        $this->datosAuditoriaVersion(
                            $version
                        ),
                ],
                descripcion: sprintf(
                    'Se registró la versión %s del documento "%s".',
                    $version->version,
                    $documento->titulo
                )
            );

            DB::commit();

            return redirect()
                ->route(
                    'admin.documentos.editar',
                    $documento->id
                )
                ->with(
                    'success',
                    'La nueva versión fue registrada correctamente.'
                );
        } catch (Throwable $error) {
            DB::rollBack();

            if ($rutaNueva) {
                Storage::disk('public')
                    ->delete($rutaNueva);
            }

            report($error);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'No se pudo registrar la nueva versión.'
                );
        }
    }

    public function descargarActual(
        Documento $documento
    ): StreamedResponse {
        abort_unless(
            Storage::disk('public')
                ->exists($documento->archivo),
            404,
            'El archivo actual no fue encontrado.'
        );

        return Storage::disk('public')
            ->download(
                $documento->archivo,
                $documento->nombre_original
            );
    }

    public function descargarVersion(
        VersionDocumento $version
    ): StreamedResponse {
        abort_unless(
            Storage::disk('public')
                ->exists($version->archivo),
            404,
            'El archivo de esta versión no fue encontrado.'
        );

        return Storage::disk('public')
            ->download(
                $version->archivo,
                $version->nombre_original
            );
    }

    public function eliminar(
        Documento $documento
    ): RedirectResponse {
        $documento->load('versiones');

        $rutas = $documento->versiones
            ->pluck('archivo')
            ->push($documento->archivo)
            ->filter()
            ->unique()
            ->values();

        $valoresAnteriores = [
            'documento' =>
                $this->datosAuditoriaDocumento(
                    $documento
                ),

            'versiones' =>
                $documento->versiones
                    ->map(
                        fn (VersionDocumento $version) =>
                            $this->datosAuditoriaVersion(
                                $version
                            )
                    )
                    ->values()
                    ->all(),
        ];

        $titulo = $documento->titulo;
        $documentoId = $documento->id;

        try {
            DB::transaction(function () use (
                $documento,
                $valoresAnteriores,
                $titulo
            ) {
                AuditoriaService::registrar(
                    modulo: 'Documentos',
                    accion: 'eliminar',
                    modelo: $documento,
                    valoresAnteriores:
                        $valoresAnteriores,
                    valoresNuevos: null,
                    descripcion: sprintf(
                        'Se eliminó el documento "%s" y su historial de versiones.',
                        $titulo
                    )
                );

                $documento->delete();
            });

            foreach ($rutas as $ruta) {
                Storage::disk('public')
                    ->delete($ruta);
            }

            Storage::disk('public')
                ->deleteDirectory(
                    "documentos/{$documentoId}"
                );

            return redirect()
                ->route('admin.documentos.index')
                ->with(
                    'success',
                    'El documento fue eliminado correctamente.'
                );
        } catch (Throwable $error) {
            report($error);

            return back()->with(
                'error',
                'No se pudo eliminar el documento.'
            );
        }
    }

    private function validarDocumento(
        Request $request,
        bool $archivoObligatorio
    ): array {
        return $request->validate([
            'categoria_documento_id' => [
                'required',
                'integer',

                Rule::exists(
                    'categorias_documento',
                    'id'
                )->where(
                    fn ($query) =>
                        $query->where(
                            'estado',
                            true
                        )
                ),
            ],

            'area_id' => [
                'nullable',
                'integer',

                Rule::exists(
                    'areas_institucionales',
                    'id'
                )->where(
                    fn ($query) =>
                        $query->where(
                            'estado',
                            true
                        )
                ),
            ],

            'titulo' => [
                'required',
                'string',
                'max:200',
            ],

            'descripcion' => [
                'nullable',
                'string',
                'max:3000',
            ],

            'version' => [
                $archivoObligatorio
                    ? 'required'
                    : 'nullable',
                'string',
                'max:20',
            ],

            'fecha_publicacion' => [
                'nullable',
                'date',
            ],

            'es_publico' => [
                'nullable',
                'boolean',
            ],

            'estado' => [
                'required',
                Rule::in([
                    'activo',
                    'inactivo',
                ]),
            ],

            'archivo' => [
                $archivoObligatorio
                    ? 'required'
                    : 'nullable',

                'file',
                'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip',
                'max:20480',
            ],
        ], [
            'categoria_documento_id.required' =>
                'Selecciona una categoría.',

            'categoria_documento_id.exists' =>
                'La categoría seleccionada no es válida.',

            'area_id.exists' =>
                'El área seleccionada no es válida.',

            'titulo.required' =>
                'El título es obligatorio.',

            'titulo.max' =>
                'El título no debe superar los 200 caracteres.',

            'version.required' =>
                'La versión inicial es obligatoria.',

            'estado.required' =>
                'Selecciona un estado.',

            'estado.in' =>
                'El estado seleccionado no es válido.',

            'archivo.required' =>
                'Selecciona el archivo del documento.',

            'archivo.mimes' =>
                'El archivo debe ser PDF, Word, Excel, PowerPoint, TXT o ZIP.',

            'archivo.max' =>
                'El archivo no debe superar los 20 MB.',
        ]);
    }

    private function datosAuditoriaDocumento(
        Documento $documento
    ): array {
        return [
            'id' =>
                $documento->id,

            'categoria_documento_id' =>
                $documento->categoria_documento_id,

            'area_id' =>
                $documento->area_id,

            'usuario_id' =>
                $documento->usuario_id,

            'titulo' =>
                $documento->titulo,

            'descripcion' =>
                $documento->descripcion,

            'archivo' =>
                $documento->archivo,

            'nombre_original' =>
                $documento->nombre_original,

            'tipo_archivo' =>
                $documento->tipo_archivo,

            'tamano_bytes' =>
                $documento->tamano_bytes,

            'version' =>
                $documento->version,

            'fecha_publicacion' =>
                $documento->fecha_publicacion,

            'es_publico' =>
                (bool) $documento->es_publico,

            'estado' =>
                $documento->estado,

            'created_at' =>
                $documento->created_at,

            'updated_at' =>
                $documento->updated_at,
        ];
    }

    private function datosAuditoriaVersion(
        VersionDocumento $version
    ): array {
        return [
            'id' =>
                $version->id,

            'documento_id' =>
                $version->documento_id,

            'usuario_id' =>
                $version->usuario_id,

            'version' =>
                $version->version,

            'archivo' =>
                $version->archivo,

            'nombre_original' =>
                $version->nombre_original,

            'tipo_archivo' =>
                $version->tipo_archivo,

            'tamano_bytes' =>
                $version->tamano_bytes,

            'descripcion_cambio' =>
                $version->descripcion_cambio,

            'created_at' =>
                $version->created_at,

            'updated_at' =>
                $version->updated_at,
        ];
    }
}