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
    Schema::create('archivos_galeria', function (Blueprint $table) {
        $table->id();

        $table->foreignId('galeria_id')
            ->constrained('galerias')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

        $table->string('tipo_archivo', 20)->default('imagen');
        $table->string('ruta');
        $table->string('nombre_original', 255)->nullable();
        $table->string('mime_type', 100)->nullable();
        $table->unsignedBigInteger('tamano_bytes')->nullable();
        $table->string('titulo', 180)->nullable();
        $table->text('descripcion')->nullable();
        $table->unsignedInteger('orden')->default(0);
        $table->boolean('estado')->default(true);
        $table->timestamps();

        $table->index(['galeria_id', 'estado']);
        $table->index('tipo_archivo');
    });
}

public function down(): void
{
    Schema::dropIfExists('archivos_galeria');
}
};
