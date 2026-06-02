<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // USERS
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'tipo_documento')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('tipo_documento')->nullable()->after('cedula');
            });
        }

        // POSTULACIONS / BECAS
        if (Schema::hasTable('postulacions') && !Schema::hasColumn('postulacions', 'tipo_documento')) {
            Schema::table('postulacions', function (Blueprint $table) {
                $table->string('tipo_documento')->nullable()->after('documento_identidad');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('postulacions') && Schema::hasColumn('postulacions', 'tipo_documento')) {
            Schema::table('postulacions', function (Blueprint $table) {
                $table->dropColumn('tipo_documento');
            });
        }

        if (Schema::hasTable('users') && Schema::hasColumn('users', 'tipo_documento')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('tipo_documento');
            });
        }
    }
};