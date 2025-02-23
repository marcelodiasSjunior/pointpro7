<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ferias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('funcionario_id')->references('id')->on('funcionarios')->onDelete('cascade');
            $table->foreignId('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->string('path')->nullable();
            $table->string('file')->nullable();
            $table->string('media_type')->nullable();
            $table->dateTime('dateUpload')->nullable();
            $table->date('startDate');
            $table->date('endDate');
            $table->enum('status', ['pendente', 'aprovado', 'rejeitado']); // Exemplo de status, pode ajustar conforme necessidade
            $table->text('observacao')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ferias');
    }
};
