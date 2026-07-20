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
        Schema::create('galerias', function (Blueprint $table) {
            $table->id();

            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('titulo', 180);
            $table->text('descripcion')->nullable();
            $table->string('tipo', 30)->default('fotografias');
            $table->unsignedSmallInteger('anio')->nullable();
            $table->string('imagen_portada')->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->boolean('estado')->default(true);
            $table->timestamps();

            $table->index(['tipo', 'estado']);
            $table->index('anio');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galerias');
    }
};
