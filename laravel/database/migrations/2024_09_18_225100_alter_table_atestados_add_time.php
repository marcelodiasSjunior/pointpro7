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
        Schema::table('atestados', function (Blueprint $table) {
            $table->time('startTime')->nullable()->after('endDate');
            $table->time('endTime')->nullable()->after('startTime');
        });

        // Atualiza todos os registros existentes para definir os horários como 00:00 - 23:59
        DB::table('atestados')->update([
            'startTime' => '00:00:00',
            'endTime' => '23:59:59'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('atestados', function (Blueprint $table) {
            $table->dropColumn(['startTime', 'endTime']);
        });
    }
};
