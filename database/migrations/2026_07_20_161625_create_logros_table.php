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
        Schema::create('logros', function (Blueprint $table) {
            $table->id();

            $table->foreignId('nivel_educativo_id')
                ->nullable()
                ->constrained('niveles_educativos')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('tipo', 50)->default('logro');
            $table->string('titulo', 200);
            $table->text('descripcion');
            $table->date('fecha')->nullable();
            $table->string('imagen')->nullable();
            $table->string('archivo_respaldo')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();

            $table->index(['tipo', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logros');
    }
};
