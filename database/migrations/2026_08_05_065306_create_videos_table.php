<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('titulo', 180);
            $table->text('descripcion')->nullable();

            $table->string('url_youtube');
            $table->string('youtube_id', 20)->nullable()->index();
            $table->string('miniatura')->nullable();

            $table->string('categoria', 60)
                ->default('institucional');

            $table->date('fecha_publicacion')->nullable();

            $table->unsignedInteger('orden')->default(0);
            $table->boolean('destacado')->default(false);
            $table->boolean('estado')->default(true);

            $table->timestamps();

            $table->index(['estado', 'destacado']);
            $table->index(['categoria', 'estado']);
            $table->index('fecha_publicacion');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};