<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('convocatorias', function (Blueprint $table) {
            $table->boolean('resultados_publicados')
                ->default(false)
                ->after('destacada');

            $table->dateTime('fecha_publicacion_resultados')
                ->nullable()
                ->after('resultados_publicados');

            $table->index(
                [
                    'resultados_publicados',
                    'fecha_publicacion_resultados',
                ],
                'convocatorias_resultados_publicados_index'
            );
        });
    }

    public function down(): void
    {
        Schema::table('convocatorias', function (Blueprint $table) {
            $table->dropIndex(
                'convocatorias_resultados_publicados_index'
            );

            $table->dropColumn([
                'resultados_publicados',
                'fecha_publicacion_resultados',
            ]);
        });
    }
};