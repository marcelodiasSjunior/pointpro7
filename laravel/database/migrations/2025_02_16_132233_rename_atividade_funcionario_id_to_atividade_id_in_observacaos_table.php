<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Adicione esta linha

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('observacaos', function (Blueprint $table) {
            // Substitua 'TIPO_DA_COLUNA' pelo tipo real (ex: INTEGER, BIGINT UNSIGNED, etc)
            DB::statement('ALTER TABLE observacaos CHANGE atividade_funcionario_id atividade_id BIGINT UNSIGNED');
        });
    }

    public function down(): void
    {
        Schema::table('observacaos', function (Blueprint $table) {
            DB::statement('ALTER TABLE observacaos CHANGE atividade_id atividade_funcionario_id BIGINT UNSIGNED');
        });
    }
};