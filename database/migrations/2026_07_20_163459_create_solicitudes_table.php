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
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tipo_tramite_id')
                ->constrained('tipos_tramite')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('area_asignada_id')
                ->nullable()
                ->constrained('areas_institucionales')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('usuario_solicitante_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('usuario_asignado_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('codigo_expediente', 35)->unique();
            $table->string('tipo_solicitante', 40);
            $table->string('nombres', 150);
            $table->string('dni', 8)->nullable();
            $table->string('correo', 150);
            $table->string('telefono', 20)->nullable();
            $table->string('asunto', 200);
            $table->text('descripcion');
            $table->string('estado', 30)->default('recibida');
            $table->dateTime('fecha_atencion')->nullable();
            $table->dateTime('fecha_cierre')->nullable();
            $table->text('respuesta_final')->nullable();
            $table->timestamps();

            $table->index(['estado', 'created_at']);
            $table->index(['tipo_tramite_id', 'estado']);
            $table->index('dni');
            $table->index('correo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};
