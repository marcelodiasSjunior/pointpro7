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
        Schema::create('frequencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->unsignedBigInteger('funcionario_id');
            $table->foreign('funcionario_id')->references('id')->on('funcionarios');
            $table->tinyInteger('direction')->default(1); // 1 - Entrada / 2 -  Saida
            $table->string('document')->nullable();
            $table->foreign('frequencia_id')->references('id')->on('frequencias');
            $table->unsignedBigInteger('frequencia_id')->nullable();
            $table->tinyInteger('ferias')->nullable();
            $table->datetime('ponto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frequencias');
    }
};
