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
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->unsignedBigInteger('jornada_id');
            $table->foreign('jornada_id')->references('id')->on('jornadas');
            $table->unsignedBigInteger('funcao_id');
            $table->foreign('funcao_id')->references('id')->on('funcoes');
            $table->string('foto')->default('')->nullable();
            $table->string('nascimento')->default('')->nullable();
            $table->string('celular')->default('')->nullable();
            $table->string('cpf')->default('')->nullable();
            $table->string('rg')->default('')->nullable();
            $table->string('rg_emissor')->default('')->nullable();
            $table->string('rg_emissao')->default('')->nullable();
            $table->string('sexo')->default('')->nullable();
            $table->string('nis')->default('')->nullable();
            $table->string('nome_pai')->default('')->nullable();
            $table->string('nome_mae')->default('')->nullable();
            $table->string('titulo_eleitoral')->default('')->nullable();
            $table->string('zona_eleitoral')->default('')->nullable();
            $table->string('secao_eleitoral')->default('')->nullable();
            $table->string('carteira_reservista')->default('')->nullable();
            $table->string('serie_reservista')->default('')->nullable();
            $table->string('telefone')->default('')->nullable();
            $table->string('estado_civil')->default('')->nullable();
            $table->string('grau_instrucao')->default('')->nullable();
            $table->string('comorbidade')->json()->nullable();
            $table->string('cnh_numero')->default('')->nullable();
            $table->string('cnh_categoria')->default('')->nullable();
            $table->string('cep')->default('')->nullable();
            $table->string('endereco')->default('')->nullable();
            $table->string('numero')->default('')->nullable();
            $table->string('complemento')->default('')->nullable();
            $table->string('bairro')->default('')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcionarios');
    }
};
