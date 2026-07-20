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
        Schema::create('documentos_postulacion', function (Blueprint $table) {
            $table->id();

            $table->foreignId('postulacion_id')
                ->constrained('postulaciones')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('tipo_documento', 100);
            $table->string('ruta');
            $table->string('nombre_original', 255);
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('tamano_bytes')->nullable();
            $table->string('estado_revision', 30)->default('pendiente');
            $table->text('observacion')->nullable();
            $table->timestamps();

            $table->index(['postulacion_id', 'estado_revision']);
            $table->index('tipo_documento');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documentos_postulacion');
    }
};
