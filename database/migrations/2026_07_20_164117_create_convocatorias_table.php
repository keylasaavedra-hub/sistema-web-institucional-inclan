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
        Schema::create('convocatorias', function (Blueprint $table) {
            $table->id();

            $table->foreignId('area_id')
                ->nullable()
                ->constrained('areas_institucionales')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('cargo_id')
                ->nullable()
                ->constrained('cargos')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('codigo', 30)->unique();
            $table->string('tipo', 40);
            $table->string('titulo', 200);
            $table->text('descripcion')->nullable();
            $table->text('perfil')->nullable();
            $table->text('requisitos');
            $table->text('cronograma')->nullable();
            $table->unsignedInteger('vacantes')->default(1);
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_cierre');
            $table->dateTime('fecha_publicacion')->nullable();
            $table->string('estado', 30)->default('borrador');
            $table->boolean('destacada')->default(false);
            $table->timestamps();

            $table->index(['estado', 'fecha_cierre']);
            $table->index(['tipo', 'estado']);
            $table->index(['area_id', 'cargo_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('convocatorias');
    }
};
