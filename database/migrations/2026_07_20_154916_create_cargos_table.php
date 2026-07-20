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
    Schema::create('cargos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre', 100);
        $table->string('descripcion', 200)->nullable();

        $table->foreignId('area_id')
            ->nullable()
            ->constrained('areas_institucionales')
            ->cascadeOnUpdate()
            ->nullOnDelete();

        $table->boolean('estado')->default(true);
        $table->timestamps();

        $table->unique(['nombre', 'area_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::dropIfExists('cargos');
}
};
