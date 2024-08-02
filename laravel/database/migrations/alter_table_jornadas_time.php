<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Converting integer values to time format
        DB::table('jornadas')->get()->each(function ($jornada) {
            DB::table('jornadas')
                ->where('id', $jornada->id)
                ->update([
                    'segunda' => DB::raw("SEC_TO_TIME(segunda * 3600)"),
                    'terca' => DB::raw("SEC_TO_TIME(terca * 3600)"),
                    'quarta' => DB::raw("SEC_TO_TIME(quarta * 3600)"),
                    'quinta' => DB::raw("SEC_TO_TIME(quinta * 3600)"),
                    'sexta' => DB::raw("SEC_TO_TIME(sexta * 3600)"),
                    'sabado' => DB::raw("SEC_TO_TIME(sabado * 3600)"),
                    'domingo' => DB::raw("SEC_TO_TIME(domingo * 3600)")
                ]);
        });

        // Alterando as colunas de INTEGER para TIME
        Schema::table('jornadas', function (Blueprint $table) {
            $table->time('segunda')->nullable()->change();
            $table->time('terca')->nullable()->change();
            $table->time('quarta')->nullable()->change();
            $table->time('quinta')->nullable()->change();
            $table->time('sexta')->nullable()->change();
            $table->time('sabado')->nullable()->change();
            $table->time('domingo')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Convertendo os valores de volta para INTEGER antes de alterar o tipo de coluna
        DB::table('jornadas')->get()->each(function ($jornada) {
            DB::table('jornadas')
                ->where('id', $jornada->id)
                ->update([
                    'segunda' => DB::raw("TIME_TO_SEC(segunda) / 3600"),
                    'terca' => DB::raw("TIME_TO_SEC(terca) / 3600"),
                    'quarta' => DB::raw("TIME_TO_SEC(quarta) / 3600"),
                    'quinta' => DB::raw("TIME_TO_SEC(quinta) / 3600"),
                    'sexta' => DB::raw("TIME_TO_SEC(sexta) / 3600"),
                    'sabado' => DB::raw("TIME_TO_SEC(sabado) / 3600"),
                    'domingo' => DB::raw("TIME_TO_SEC(domingo) / 3600")
                ]);
        });

        // Alterando as colunas de TIME para INTEGER
        Schema::table('jornadas', function (Blueprint $table) {
            $table->integer('segunda')->change();
            $table->integer('terca')->change();
            $table->integer('quarta')->change();
            $table->integer('quinta')->change();
            $table->integer('sexta')->change();
            $table->integer('sabado')->change();
            $table->integer('domingo')->change();
        });
    }
};
