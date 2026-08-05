<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consultas', function (Blueprint $table) {
            if (! Schema::hasColumn('consultas', 'apellidos')) {
                $table->string('apellidos', 100)->after('nombres');
            }

            if (! Schema::hasColumn('consultas', 'telefono')) {
                $table->string('telefono', 20)->nullable()->after('correo');
            }

            if (! Schema::hasColumn('consultas', 'respuesta')) {
                $table->text('respuesta')->nullable()->after('estado');
            }

            if (! Schema::hasColumn('consultas', 'respondido_en')) {
                $table->dateTime('respondido_en')->nullable()->after('respuesta');
            }

            if (! Schema::hasColumn('consultas', 'fecha_atencion')) {
                $table->dateTime('fecha_atencion')->nullable()->after('respondido_en');
            }

            if (! Schema::hasColumn('consultas', 'fecha_cierre')) {
                $table->dateTime('fecha_cierre')->nullable()->after('fecha_atencion');
            }
        });
    }

    public function down(): void
    {
        /*
         * No se eliminan columnas porque algunas forman parte
         * de la estructura original de la tabla consultas.
         */
    }
};