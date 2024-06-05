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
        Schema::create('funcionario_atividades', function (Blueprint $table) {
            $table->id();
            $table->date('dia');
            $table->tinyInteger('status')->default(0);

            $table->unsignedBigInteger('funcionario_id');
            $table->foreign('funcionario_id')->references('id')->on('funcionarios');

            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');

            $table->unsignedBigInteger('atividade_id');
            $table->foreign('atividade_id')->references('id')->on('atividades');

            $table->unsignedBigInteger('atividade_funcionario_id');
            $table->foreign('atividade_funcionario_id')->references('id')->on('atividade_funcionarios');

            $table->tinyInteger('dia_da_semana');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcionario_atividades');
    }
};
