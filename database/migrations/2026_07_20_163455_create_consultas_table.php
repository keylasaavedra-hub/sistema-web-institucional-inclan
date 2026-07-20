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
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('categoria_consulta_id')
                ->nullable()
                ->constrained('categorias_consulta')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('area_asignada_id')
                ->nullable()
                ->constrained('areas_institucionales')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('usuario_asignado_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('codigo', 30)->unique();
            $table->string('nombres', 150);
            $table->string('dni', 8)->nullable();
            $table->string('correo', 150);
            $table->string('telefono', 20)->nullable();
            $table->string('asunto', 200);
            $table->text('mensaje');
            $table->string('estado', 30)->default('pendiente');
            $table->dateTime('fecha_atencion')->nullable();
            $table->dateTime('fecha_cierre')->nullable();
            $table->timestamps();

            $table->index(['estado', 'created_at']);
            $table->index('correo');
            $table->index('dni');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
