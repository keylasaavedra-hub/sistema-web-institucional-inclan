create_convocatorias_table<?php

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
        Schema::create('versiones_documento', function (Blueprint $table) {
            $table->id();

            $table->foreignId('documento_id')
                ->constrained('documentos')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('version', 20);
            $table->string('archivo');
            $table->string('nombre_original', 255);
            $table->string('tipo_archivo', 100)->nullable();
            $table->unsignedBigInteger('tamano_bytes')->nullable();
            $table->text('descripcion_cambio')->nullable();
            $table->timestamps();

            $table->unique(['documento_id', 'version']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('versiones_documento');
    }
};
