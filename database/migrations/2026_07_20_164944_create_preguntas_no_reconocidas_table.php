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
        Schema::create('preguntas_no_reconocidas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('consulta_generada_id')
                ->nullable()
                ->constrained('consultas')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('usuario_revision_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->text('pregunta');
            $table->string('direccion_ip', 45)->nullable();
            $table->string('pagina_origen')->nullable();
            $table->string('estado_revision', 30)->default('pendiente');
            $table->text('observacion')->nullable();
            $table->dateTime('fecha_revision')->nullable();
            $table->timestamps();

            $table->index(['estado_revision', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('preguntas_no_reconocidas');
    }
};
