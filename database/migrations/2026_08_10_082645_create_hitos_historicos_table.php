<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hitos_historicos', function (Blueprint $table) {
            $table->id();

            $table->string('anio', 50);

            $table->string('fecha_texto', 100)
                ->nullable();

            $table->string('titulo', 200);

            $table->text('descripcion');

            $table->string('icono', 50)
                ->default('documento');

            $table->string('imagen')
                ->nullable();

            $table->unsignedInteger('orden')
                ->default(0);

            $table->boolean('estado')
                ->default(true);

            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index([
                'estado',
                'orden',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hitos_historicos');
    }
};