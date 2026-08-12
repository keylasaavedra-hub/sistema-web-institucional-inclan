<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | COMPLETAR TABLA CONVENIOS EXISTENTE
        |--------------------------------------------------------------------------
        */

        if (Schema::hasTable('convenios')) {

            if (! Schema::hasColumn('convenios', 'slug')) {
                Schema::table('convenios', function (Blueprint $table) {
                    $table->string('slug')
                        ->nullable()
                        ->unique()
                        ->after('id');
                });
            }

            if (! Schema::hasColumn('convenios', 'tipo')) {
                Schema::table('convenios', function (Blueprint $table) {
                    $table->string('tipo', 200)
                        ->nullable()
                        ->after('nombre');
                });
            }

            if (! Schema::hasColumn('convenios', 'estado_texto')) {
                Schema::table('convenios', function (Blueprint $table) {
                    $table->string('estado_texto', 100)
                        ->default('Vigente')
                        ->after('descripcion');
                });
            }

            if (! Schema::hasColumn('convenios', 'objetivos')) {
                Schema::table('convenios', function (Blueprint $table) {
                    $table->json('objetivos')
                        ->nullable()
                        ->after('fecha_fin');
                });
            }

            if (! Schema::hasColumn('convenios', 'beneficios')) {
                Schema::table('convenios', function (Blueprint $table) {
                    $table->json('beneficios')
                        ->nullable()
                        ->after('objetivos');
                });
            }

            if (! Schema::hasColumn('convenios', 'orden')) {
                Schema::table('convenios', function (Blueprint $table) {
                    $table->unsignedInteger('orden')
                        ->default(0)
                        ->after('beneficios');
                });
            }
        }

        /*
        |--------------------------------------------------------------------------
        | ARCHIVOS / GALERÍA DE CADA CONVENIO
        |--------------------------------------------------------------------------
        */

        if (! Schema::hasTable('convenio_archivos')) {
            Schema::create(
                'convenio_archivos',
                function (Blueprint $table) {
                    $table->id();

                    $table->foreignId('convenio_id')
                        ->constrained('convenios')
                        ->cascadeOnDelete();

                    $table->string('archivo');

                    $table->string('tipo', 50)
                        ->default('imagen');

                    $table->unsignedInteger('orden')
                        ->default(0);

                    $table->boolean('estado')
                        ->default(true);

                    $table->foreignId('usuario_id')
                        ->nullable()
                        ->constrained('users')
                        ->nullOnDelete();

                    $table->timestamps();

                    $table->index(
                        [
                            'convenio_id',
                            'estado',
                            'orden',
                        ],
                        'conv_arch_conv_estado_orden_idx'
                    );
                }
            );
        }
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | SOLO REVERTIR LO AGREGADO POR ESTA MIGRACIÓN
        |--------------------------------------------------------------------------
        */

        Schema::dropIfExists('convenio_archivos');

        if (Schema::hasTable('convenios')) {

            $columnas = [
                'slug',
                'tipo',
                'estado_texto',
                'objetivos',
                'beneficios',
                'orden',
            ];

            foreach ($columnas as $columna) {
                if (Schema::hasColumn('convenios', $columna)) {
                    Schema::table(
                        'convenios',
                        function (Blueprint $table) use ($columna) {
                            $table->dropColumn($columna);
                        }
                    );
                }
            }
        }
    }
};