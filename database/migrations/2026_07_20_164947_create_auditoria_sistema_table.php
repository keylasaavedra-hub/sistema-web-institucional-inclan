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
        Schema::create('auditoria_sistema', function (Blueprint $table) {
            $table->id();

            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('modulo', 100);
            $table->string('accion', 80);
            $table->string('tabla_afectada', 100)->nullable();
            $table->unsignedBigInteger('registro_afectado_id')->nullable();
            $table->text('descripcion')->nullable();
            $table->json('valores_anteriores')->nullable();
            $table->json('valores_nuevos')->nullable();
            $table->string('direccion_ip', 45)->nullable();
            $table->text('agente_usuario')->nullable();
            $table->string('metodo_http', 10)->nullable();
            $table->string('ruta', 500)->nullable();
            $table->timestamp('fecha_hora')->useCurrent();

            $table->index(['usuario_id', 'fecha_hora']);
            $table->index(['modulo', 'accion']);
            $table->index(['tabla_afectada', 'registro_afectado_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auditoria_sistema');
    }
};
