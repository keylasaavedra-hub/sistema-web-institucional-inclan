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
        Schema::create('categorias_consulta', function (Blueprint $table) {
            $table->id();

            $table->foreignId('area_id')
                ->nullable()
                ->constrained('areas_institucionales')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('nombre', 120)->unique();
            $table->string('descripcion', 250)->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();

            $table->index(['area_id', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorias_consulta');
    }
};
