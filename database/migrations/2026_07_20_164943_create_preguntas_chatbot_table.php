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
        Schema::create('preguntas_chatbot', function (Blueprint $table) {
            $table->id();

            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('pregunta', 255);
            $table->longText('respuesta');
            $table->text('palabras_clave')->nullable();
            $table->string('enlace_relacionado')->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->unsignedInteger('veces_utilizada')->default(0);
            $table->boolean('estado')->default(true);
            $table->timestamps();

            $table->index(['estado', 'orden']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('preguntas_chatbot');
    }
};
