<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('postulacions', function (Blueprint $table) {
            $table->string('estado', 50)->default('Pendiente')->change();
        });
    }

    public function down(): void
    {
        // Si antes era enum, NO siempre se puede volver automáticamente.
        // Puedes dejarlo como string en el rollback para evitar líos.
        Schema::table('postulacions', function (Blueprint $table) {
            $table->string('estado', 50)->default('Pendiente')->change();
        });
    }
};
