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
    Schema::table('users', function (Blueprint $table) {
        $table->string('dni', 8)
            ->nullable()
            ->unique()
            ->after('id');

        $table->string('apellidos', 100)
            ->nullable()
            ->after('name');

        $table->string('telefono', 20)
            ->nullable()
            ->after('email');

        $table->foreignId('rol_id')
            ->nullable()
            ->after('password')
            ->constrained('roles')
            ->cascadeOnUpdate()
            ->restrictOnDelete();

        $table->boolean('estado')
            ->default(true)
            ->after('rol_id');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['rol_id']);

        $table->dropColumn([
            'dni',
            'apellidos',
            'telefono',
            'rol_id',
            'estado',
        ]);
    });
}
};
