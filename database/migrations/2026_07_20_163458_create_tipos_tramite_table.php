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
        Schema::create('tipos_tramite', function (Blueprint $table) {
            $table->id();

            $table->foreignId('area_id')
                ->nullable()
                ->constrained('areas_institucionales')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('nombre', 150)->unique();
            $table->string('codigo', 30)->unique();
            $table->text('descripcion')->nullable();
            $table->text('requisitos')->nullable();
            $table->unsignedInteger('plazo_dias')->nullable();
            $table->boolean('permite_adjuntos')->default(true);
            $table->boolean('estado')->default(true);
            $table->timestamps();

            $table->index(['area_id', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipos_tramite');
    }
};
