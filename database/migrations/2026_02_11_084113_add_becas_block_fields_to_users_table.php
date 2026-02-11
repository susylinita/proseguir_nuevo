<?php
// database/migrations/xxxx_xx_xx_add_becas_block_fields_to_users_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('becas_bloqueado')->default(false)->after('remember_token');
            $table->timestamp('becas_bloqueado_en')->nullable()->after('becas_bloqueado');
            $table->text('becas_bloqueado_motivo')->nullable()->after('becas_bloqueado_en');
            $table->foreignId('becas_bloqueado_por')->nullable()->after('becas_bloqueado_motivo')
                ->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('becas_bloqueado_por');
            $table->dropColumn(['becas_bloqueado', 'becas_bloqueado_en', 'becas_bloqueado_motivo']);
        });
    }
};
