<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tramites', function (Blueprint $table) {
            $table->id();

            $table->string('codigo', 30)->unique();

            $table->string('tipo_persona', 20);
            $table->string('nombres', 100);
            $table->string('apellidos', 100)->nullable();
            $table->string('razon_social', 180)->nullable();

            $table->string('tipo_documento_identidad', 20);
            $table->string('numero_documento', 20);

            $table->string('correo', 150);
            $table->string('telefono', 20)->nullable();
            $table->string('direccion', 250)->nullable();

            $table->string('tipo_documento', 80);
            $table->string('numero_documento_presentado', 50)->nullable();
            $table->string('asunto', 200);
            $table->text('descripcion')->nullable();

            $table->string('archivo_original', 255);
            $table->string('archivo_ruta', 255);
            $table->unsignedBigInteger('archivo_tamanio')->nullable();

            $table->string('estado', 30)->default('recibido');
            $table->text('observacion')->nullable();
            $table->timestamp('fecha_atencion')->nullable();
            $table->timestamp('fecha_cierre')->nullable();

            $table->timestamps();

            $table->index('codigo');
            $table->index('numero_documento');
            $table->index('estado');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tramites');
    }
};