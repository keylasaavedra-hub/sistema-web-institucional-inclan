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
        Schema::create('historial_solicitud', function (Blueprint $table) {
            $table->id();

            $table->foreignId('solicitud_id')
                ->constrained('solicitudes')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('estado_anterior', 30)->nullable();
            $table->string('estado_nuevo', 30);
            $table->text('observacion')->nullable();
            $table->boolean('visible_solicitante')->default(true);
            $table->timestamp('fecha_cambio')->useCurrent();
            $table->timestamps();

            $table->index(['solicitud_id', 'fecha_cambio']);
            $table->index('estado_nuevo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historial_solicitud');
    }
};
