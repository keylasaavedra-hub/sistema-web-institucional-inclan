<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('categoria_documento_id')
                ->constrained('categorias_documento')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('area_id')
                ->nullable()
                ->constrained('areas_institucionales')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('titulo', 200);
            $table->text('descripcion')->nullable();
            $table->string('archivo');
            $table->string('nombre_original', 255);
            $table->string('tipo_archivo', 100)->nullable();
            $table->unsignedBigInteger('tamano_bytes')->nullable();
            $table->string('version', 20)->default('1.0');
            $table->date('fecha_publicacion')->nullable();
            $table->boolean('es_publico')->default(true);
            $table->string('estado', 30)->default('activo');
            $table->timestamps();

            $table->index(['estado', 'es_publico']);
            $table->index('fecha_publicacion');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
