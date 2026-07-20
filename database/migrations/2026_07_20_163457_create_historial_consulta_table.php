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
        Schema::create('historial_consulta', function (Blueprint $table) {
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

            $table->string('estado_anterior', 30)->nullable();
            $table->string('estado_nuevo', 30);
            $table->text('observacion')->nullable();
            $table->timestamp('fecha_cambio')->useCurrent();
            $table->timestamps();

            $table->index(['consulta_id', 'fecha_cambio']);
            $table->index('estado_nuevo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historial_consulta');
    }
};
