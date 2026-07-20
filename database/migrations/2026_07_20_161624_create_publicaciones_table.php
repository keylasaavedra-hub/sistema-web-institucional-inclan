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
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('categoria_publicacion_id')
                ->constrained('categorias_publicacion')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('titulo', 200);
            $table->string('slug', 220)->unique();
            $table->longText('contenido');
            $table->string('imagen_portada')->nullable();
            $table->string('archivo_adjunto')->nullable();
            $table->dateTime('fecha_publicacion')->nullable();
            $table->dateTime('fecha_vencimiento')->nullable();
            $table->boolean('destacada')->default(false);
            $table->string('estado', 30)->default('borrador');
            $table->timestamps();

            $table->index(['estado', 'fecha_publicacion']);
            $table->index('fecha_vencimiento');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publicaciones');
    }
};
