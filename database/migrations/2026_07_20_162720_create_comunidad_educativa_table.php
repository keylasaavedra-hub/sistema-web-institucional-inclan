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
        Schema::create('comunidad_educativa', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cargo_id')
                ->nullable()
                ->constrained('cargos')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('area_id')
                ->nullable()
                ->constrained('areas_institucionales')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('nivel_educativo_id')
                ->nullable()
                ->constrained('niveles_educativos')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('usuario_registro_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('nombres', 120);
            $table->string('apellidos', 120);
            $table->string('tipo_personal', 50);
            $table->string('correo_institucional', 150)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('foto')->nullable();
            $table->text('perfil_profesional')->nullable();
            $table->text('descripcion')->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->boolean('publicar')->default(true);
            $table->boolean('estado')->default(true);
            $table->timestamps();

            $table->index(['tipo_personal', 'estado']);
            $table->index(['area_id', 'cargo_id']);
            $table->index('nivel_educativo_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comunidad_educativa');
    }
};
