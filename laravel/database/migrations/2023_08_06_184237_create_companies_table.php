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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('logo')->default('')->nullable();
            $table->string('seguimento')->default('');
            $table->string('razao_social')->default('');
            $table->string('cnpj')->default('');
            $table->string('telefone')->default('');
            $table->string('cep')->default('');
            $table->string('endereco')->default('');
            $table->string('numero')->default('')->nullable();
            $table->string('complemento')->default('')->nullable();
            $table->string('bairro')->default('');
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
        Schema::dropIfExists('companies');
    }
};
