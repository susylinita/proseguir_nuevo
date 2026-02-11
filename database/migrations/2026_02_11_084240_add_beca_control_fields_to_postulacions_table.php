<?php
// database/migrations/xxxx_xx_xx_add_beca_control_fields_to_postulacions_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('postulacions', function (Blueprint $table) {
            $table->string('beca_estado')->default('activa'); // activa|congelada|cancelada
            $table->text('beca_motivo')->nullable();
            $table->timestamp('beca_actualizada_en')->nullable();
            $table->foreignId('beca_actualizada_por')->nullable()
                ->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('postulacions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('beca_actualizada_por');
            $table->dropColumn(['beca_estado', 'beca_motivo', 'beca_actualizada_en']);
        });
    }
};
