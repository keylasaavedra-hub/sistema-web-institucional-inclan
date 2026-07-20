<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imagenes_promocion', function (Blueprint $table) {
            $table->id();

            $table->foreignId('promocion_id')
                ->constrained('promociones')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('ruta');
            $table->string('nombre_original', 255)->nullable();
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('tamano_bytes')->nullable();
            $table->string('titulo', 180)->nullable();
            $table->text('descripcion')->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->boolean('estado')->default(true);
            $table->timestamps();

            $table->index(['promocion_id', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imagenes_promocion');
    }
};