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
        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->unsignedBigInteger('funcionario_id');
            $table->foreign('funcionario_id')->references('id')->on('funcionarios');
            $table->longText('message');
            $table->unsignedBigInteger('sender_id');
            $table->foreign('sender_id')->references('id')->on('users');
            $table->tinyInteger('sender_type')->default(1);
            $table->tinyInteger('competencia_1')->comment('Pontualidade/Assiduidade');
            $table->tinyInteger('competencia_2')->comment('Iniciativa/Pró-atividade');
            $table->tinyInteger('competencia_3')->comment('Relacionamento');
            $table->tinyInteger('competencia_4')->comment('Organização');
            $table->tinyInteger('competencia_5')->comment('Metas');
            $table->tinyInteger('competencia_6')->comment('Qualidade do serviço/Atenção');
            $table->tinyInteger('competencia_7')->comment('Postura Profissional');
            $table->tinyInteger('competencia_8')->comment('Conhecimento/Desenvolviemnto profissional');
            $table->tinyInteger('competencia_9')->comment('Liderança');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avaliacoes');
    }
};
