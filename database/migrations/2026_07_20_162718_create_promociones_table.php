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
        Schema::create('promociones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('nivel_educativo_id')
                ->constrained('niveles_educativos')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('nombre', 180);
            $table->unsignedSmallInteger('anio');
            $table->string('lema', 255)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('imagen_portada')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();

            $table->unique([
                'nombre',
                'anio',
                'nivel_educativo_id',
            ], 'promociones_nombre_anio_nivel_unique');

            $table->index(['anio', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promociones');
    }
};
