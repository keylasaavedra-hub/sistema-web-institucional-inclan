<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('infraestructura_ambientes', function (Blueprint $table) {
            $table->id();

            $table->string('slug')->unique();

            $table->string('titulo');

            $table->text('descripcion');

            $table->string('imagen')->nullable();

            $table->string('icono')->nullable();

            $table->unsignedInteger('orden')->default(0);

            $table->boolean('estado')->default(true);

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


        Schema::create('infraestructura_imagenes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('infraestructura_ambiente_id')
                ->constrained('infraestructura_ambientes')
                ->cascadeOnDelete();

            $table->string('imagen');

            $table->unsignedInteger('orden')->default(0);

            $table->boolean('estado')->default(true);

            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(
                [
                    'infraestructura_ambiente_id',
                    'estado',
                    'orden',
                ],
                'infra_img_amb_estado_orden_idx'
            );
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('infraestructura_imagenes');

        Schema::dropIfExists('infraestructura_ambientes');
    }
};