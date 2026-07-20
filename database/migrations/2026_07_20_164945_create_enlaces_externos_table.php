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
        Schema::create('enlaces_externos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('nombre', 120);
            $table->string('url', 500);
            $table->string('descripcion', 250)->nullable();
            $table->string('icono')->nullable();
            $table->string('tipo', 50)->default('institucional');
            $table->unsignedInteger('orden')->default(0);
            $table->boolean('abrir_nueva_pestana')->default(true);
            $table->boolean('estado')->default(true);
            $table->timestamps();

            $table->index(['tipo', 'estado']);
            $table->unique(['nombre', 'url']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enlaces_externos');
    }
};
