<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->string('apellidos', 100)
                ->after('nombres');

            $table->text('respuesta')
                ->nullable()
                ->after('estado');

            $table->timestamp('respondido_en')
                ->nullable()
                ->after('respuesta');
        });
    }

    public function down(): void
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->dropColumn([
                'apellidos',
                'respuesta',
                'respondido_en',
            ]);
        });
    }
};