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
        Schema::create('documentos_convocatoria', function (Blueprint $table) {
            $table->id();

            $table->foreignId('convocatoria_id')
                ->constrained('convocatorias')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('tipo_documento', 80);
            $table->string('titulo', 180);
            $table->string('ruta');
            $table->string('nombre_original', 255);
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('tamano_bytes')->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->boolean('es_publico')->default(true);
            $table->boolean('estado')->default(true);
            $table->timestamps();

            $table->index(['convocatoria_id', 'estado']);
            $table->index('tipo_documento');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documentos_convocatoria');
    }
};
