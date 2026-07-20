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
        Schema::create('configuracion_sitio', function (Blueprint $table) {
            $table->id();

            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('nombre_sitio', 180);
            $table->string('nombre_corto', 100)->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('direccion', 250)->nullable();
            $table->string('telefono', 30)->nullable();
            $table->string('correo', 150)->nullable();
            $table->string('horario_atencion', 150)->nullable();
            $table->text('descripcion')->nullable();

            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();
            $table->string('instagram')->nullable();
            $table->string('tiktok')->nullable();

            $table->string('mapa_url', 500)->nullable();
            $table->string('color_principal', 20)->nullable();
            $table->string('color_secundario', 20)->nullable();
            $table->boolean('modo_mantenimiento')->default(false);
            $table->text('mensaje_mantenimiento')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracion_sitio');
    }
};
