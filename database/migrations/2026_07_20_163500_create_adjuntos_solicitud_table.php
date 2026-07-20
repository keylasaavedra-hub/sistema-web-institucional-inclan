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
        Schema::create('adjuntos_solicitud', function (Blueprint $table) {
            $table->id();

            $table->foreignId('solicitud_id')
                ->constrained('solicitudes')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('tipo_documento', 100)->nullable();
            $table->string('ruta');
            $table->string('nombre_original', 255);
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('tamano_bytes')->nullable();
            $table->string('descripcion', 250)->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();

            $table->index(['solicitud_id', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adjuntos_solicitud');
    }
};
