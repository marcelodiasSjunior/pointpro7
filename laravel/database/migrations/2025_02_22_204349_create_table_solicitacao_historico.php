<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('solicitacao_historicos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo'); // 'ferias' ou 'abono'
            $table->foreignId('funcionario_id')->constrained('funcionarios');
            $table->string('acao'); // 'aprovado' ou 'rejeitado'
            $table->string('anexo')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitacao_historicos');
    }
};
