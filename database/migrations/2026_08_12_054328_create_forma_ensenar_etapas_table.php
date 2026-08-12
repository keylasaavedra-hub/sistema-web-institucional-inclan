<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('forma_ensenar_etapas', function (Blueprint $table) {
            $table->id();
            $table->string('numero', 20);
            $table->string('titulo', 200);
            $table->text('descripcion');
            $table->string('imagen')->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->boolean('estado')->default(true);

            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(
                ['estado', 'orden'],
                'forma_etapas_estado_orden_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forma_ensenar_etapas');
    }
};