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
        Schema::table('jornadas', function (Blueprint $table) {
            $table->time('segunda')->nullable()->change();
            $table->time('terca')->nullable()->change();
            $table->time('quarta')->nullable()->change();
            $table->time('quinta')->nullable()->change();
            $table->time('sexta')->nullable()->change();
            $table->time('sabado')->nullable()->change();
            $table->time('domingo')->nullable()->change();
        });

        // Converting integer values to time format
        DB::table('jornadas')->get()->each(function ($jornada) {
            DB::table('jornadas')
                ->where('id', $jornada->id)
                ->update([
                    'segunda' => DB::raw("SEC_TO_TIME({$jornada->segunda} * 3600)"),
                    'terca' => DB::raw("SEC_TO_TIME({$jornada->terca} * 3600)"),
                    'quarta' => DB::raw("SEC_TO_TIME({$jornada->quarta} * 3600)"),
                    'quinta' => DB::raw("SEC_TO_TIME({$jornada->quinta} * 3600)"),
                    'sexta' => DB::raw("SEC_TO_TIME({$jornada->sexta} * 3600)"),
                    'sabado' => DB::raw("SEC_TO_TIME({$jornada->sabado} * 3600)"),
                    'domingo' => DB::raw("SEC_TO_TIME({$jornada->domingo} * 3600)")
                ]);
        });

        Schema::table('jornadas', function (Blueprint $table) {
            $table->time('segunda')->nullable(false)->change();
            $table->time('terca')->nullable(false)->change();
            $table->time('quarta')->nullable(false)->change();
            $table->time('quinta')->nullable(false)->change();
            $table->time('sexta')->nullable(false)->change();
            $table->time('sabado')->nullable(false)->change();
            $table->time('domingo')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
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
