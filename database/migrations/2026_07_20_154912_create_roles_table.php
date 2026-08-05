<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();

            $table->string('titulo', 180);
            $table->string('slug', 200)->unique();

            $table->string('categoria', 80);
            $table->text('descripcion')->nullable();

            $table->string('archivo_original', 255);
            $table->string('archivo_ruta', 255);
            $table->string('archivo_tipo', 100)->nullable();
            $table->unsignedBigInteger('archivo_tamanio')->nullable();

            $table->date('fecha_publicacion')->nullable();
            $table->unsignedInteger('descargas')->default(0);

            $table->boolean('destacado')->default(false);
            $table->boolean('activo')->default(true);

            $table->timestamps();

            $table->index('categoria');
            $table->index('fecha_publicacion');
            $table->index('activo');
            $table->index('destacado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};