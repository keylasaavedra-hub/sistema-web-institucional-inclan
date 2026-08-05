<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();

            $table->string('codigo', 30)->unique();

            $table->string('nombres', 100);
            $table->string('apellidos', 100);

            $table->string('dni', 8)->nullable();
            $table->string('correo', 150);
            $table->string('telefono', 20)->nullable();

            $table->string('asunto', 180);
            $table->text('mensaje');

            $table->string('estado', 30)
                ->default('recibida');

            $table->text('respuesta')->nullable();
            $table->timestamp('respondido_en')->nullable();

            $table->timestamps();

            $table->index('estado');
            $table->index(['codigo', 'correo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};