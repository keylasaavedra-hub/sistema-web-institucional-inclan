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
        Schema::create('respuestas_consulta', function (Blueprint $table) {
            $table->id();

            $table->foreignId('consulta_id')
                ->constrained('consultas')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->text('respuesta');
            $table->boolean('visible_usuario')->default(true);
            $table->dateTime('fecha_respuesta')->nullable();
            $table->timestamps();

            $table->index(['consulta_id', 'fecha_respuesta']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('respuestas_consulta');
    }
};
