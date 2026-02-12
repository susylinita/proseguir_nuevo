<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('postulacions', function (Blueprint $table) {

            $table->string('anexo_foto_documento')->nullable()->change();
            $table->string('anexo_doc_identidad')->nullable()->change();
            $table->string('anexo_certificado_bancario')->nullable()->change();
            $table->string('pdf_notas')->nullable()->change();
            $table->string('pdf_matricula')->nullable()->change();
            $table->string('anexo_certificado_notas')->nullable()->change();
            $table->string('anexo_recibo_matricula')->nullable()->change();

        });
    }

    public function down()
    {
        //
    }
};

