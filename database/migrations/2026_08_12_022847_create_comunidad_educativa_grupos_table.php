<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'comunidad_educativa_grupos',
            function (Blueprint $table) {
                $table->id();

                $table->string('slug')
                    ->unique();

                $table->string('titulo', 200);

                $table->text('descripcion');

                $table->string('imagen')
                    ->nullable();

                $table->string('icono', 100)
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

                $table->index(
                    ['estado', 'orden'],
                    'com_edu_estado_orden_idx'
                );
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'comunidad_educativa_grupos'
        );
    }
};