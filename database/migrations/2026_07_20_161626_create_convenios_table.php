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
        Schema::create('convenios', function (Blueprint $table) {
            $table->id();

            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('nombre', 200);
            $table->string('institucion', 200);
            $table->text('descripcion')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->string('imagen')->nullable();
            $table->string('archivo')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();

            $table->index(['estado', 'fecha_fin']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('convenios');
    }
};
