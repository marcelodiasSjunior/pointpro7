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
        Schema::table('funcionarios', function (Blueprint $table) {
            $table->string('admission_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('funcionarios', function (Blueprint $table) {
            $table->date('admission_date')->after('nascimento')->nullable()->comment('Data de admissão do funcionário.');
        });
    }
};
