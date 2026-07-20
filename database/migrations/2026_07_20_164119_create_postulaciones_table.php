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
        Schema::create('postulaciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('convocatoria_id')
                ->constrained('convocatorias')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('usuario_revisor_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('codigo', 35)->unique();
            $table->string('tipo_postulante', 30);
            $table->string('nombres', 120);
            $table->string('apellidos', 120);
            $table->string('dni', 8);
            $table->string('correo', 150);
            $table->string('telefono', 20)->nullable();
            $table->string('direccion', 250)->nullable();
            $table->string('universidad', 200)->nullable();
            $table->string('carrera', 180)->nullable();
            $table->unsignedSmallInteger('ciclo')->nullable();
            $table->string('estado', 30)->default('recibida');
            $table->text('observacion')->nullable();
            $table->dateTime('fecha_revision')->nullable();
            $table->timestamps();

            $table->unique(
                ['convocatoria_id', 'dni'],
                'postulaciones_convocatoria_dni_unique'
            );

            $table->index(['estado', 'created_at']);
            $table->index(['convocatoria_id', 'estado']);
            $table->index('correo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postulaciones');
    }
};
