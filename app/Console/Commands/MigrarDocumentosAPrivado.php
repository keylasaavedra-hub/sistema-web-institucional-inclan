<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MigrarDocumentosAPrivado extends Command
{
    protected $signature = 'documentos:migrar-privado';

    protected $description =
        'Mueve los archivos de documentos del disco público al almacenamiento privado';

    public function handle(): int
    {
        $discoPublico = Storage::disk('public');
        $discoPrivado = Storage::disk('local');

        $archivos = $discoPublico->allFiles('documentos');

        if (empty($archivos)) {
            $this->info(
                'No se encontraron archivos públicos de documentos para migrar.'
            );

            return self::SUCCESS;
        }

        $this->info(
            'Archivos encontrados: ' . count($archivos)
        );

        $movidos = 0;
        $omitidos = 0;
        $errores = 0;

        foreach ($archivos as $ruta) {
            try {
                if ($discoPrivado->exists($ruta)) {
                    $this->warn(
                        "Ya existe en privado: {$ruta}"
                    );

                    $omitidos++;

                    continue;
                }

                $contenido = $discoPublico->get(
                    $ruta
                );

                $guardado = $discoPrivado->put(
                    $ruta,
                    $contenido
                );

                if (! $guardado) {
                    $this->error(
                        "No se pudo copiar: {$ruta}"
                    );

                    $errores++;

                    continue;
                }

                if (! $discoPrivado->exists($ruta)) {
                    $this->error(
                        "No se pudo verificar la copia: {$ruta}"
                    );

                    $errores++;

                    continue;
                }

                $discoPublico->delete($ruta);

                $this->line(
                    "Migrado: {$ruta}"
                );

                $movidos++;
            } catch (\Throwable $error) {
                report($error);

                $this->error(
                    "Error migrando: {$ruta}"
                );

                $errores++;
            }
        }

        $this->newLine();

        $this->info(
            "Migrados: {$movidos}"
        );

        $this->info(
            "Omitidos: {$omitidos}"
        );

        if ($errores > 0) {
            $this->error(
                "Errores: {$errores}"
            );

            return self::FAILURE;
        }

        $this->info(
            'Migración de documentos completada correctamente.'
        );

        return self::SUCCESS;
    }
}