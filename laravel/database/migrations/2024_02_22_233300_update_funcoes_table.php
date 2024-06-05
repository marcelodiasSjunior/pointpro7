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
        Schema::table('funcoes', function (Blueprint $table) {
            $table->tinyInteger('status')->default(1)->after('onboarding')->comment('0 = Inativo, 1 = Ativo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('funcoes', function (Blueprint $table) {
            Schema::dropColumn('status');
        });
    }
};
