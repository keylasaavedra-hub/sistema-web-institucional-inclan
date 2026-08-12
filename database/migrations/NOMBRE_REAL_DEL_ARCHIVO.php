<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('forma_ensenar_principios', function (Blueprint $table) {

            if (! Schema::hasColumn('forma_ensenar_principios', 'titulo')) {
                $table->string('titulo', 200)
                    ->after('id');
            }

            if (! Schema::hasColumn('forma_ensenar_principios', 'descripcion')) {
                $table->text('descripcion')
                    ->after('titulo');
            }

            if (! Schema::hasColumn('forma_ensenar_principios', 'icono')) {
                $table->string('icono')
                    ->nullable()
                    ->after('descripcion');
            }

            if (! Schema::hasColumn('forma_ensenar_principios', 'imagen')) {
                $table->string('imagen')
                    ->nullable()
                    ->after('icono');
            }

            if (! Schema::hasColumn('forma_ensenar_principios', 'orden')) {
                $table->unsignedInteger('orden')
                    ->default(0)
                    ->after('imagen');
            }

            if (! Schema::hasColumn('forma_ensenar_principios', 'estado')) {
                $table->boolean('estado')
                    ->default(true)
                    ->after('orden');
            }

            if (! Schema::hasColumn('forma_ensenar_principios', 'usuario_id')) {
                $table->foreignId('usuario_id')
                    ->nullable()
                    ->after('estado')
                    ->constrained('users')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('forma_ensenar_principios', function (Blueprint $table) {

            if (Schema::hasColumn('forma_ensenar_principios', 'usuario_id')) {
                $table->dropConstrainedForeignId('usuario_id');
            }

            $columnas = [
                'titulo',
                'descripcion',
                'icono',
                'imagen',
                'orden',
                'estado',
            ];

            foreach ($columnas as $columna) {
                if (Schema::hasColumn('forma_ensenar_principios', $columna)) {
                    $table->dropColumn($columna);
                }
            }
        });
    }
};