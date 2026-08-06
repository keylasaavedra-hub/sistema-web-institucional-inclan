<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auditorias', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('modulo', 100);
            $table->string('accion', 50);

            $table->string('tabla', 100)->nullable();
            $table->string('registro_id', 100)->nullable();

            $table->text('descripcion')->nullable();

            $table->json('valores_anteriores')->nullable();
            $table->json('valores_nuevos')->nullable();

            $table->string('ip', 45)->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamp('created_at')->useCurrent();

            $table->index(['modulo', 'accion']);
            $table->index(['tabla', 'registro_id']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auditorias');
    }
};