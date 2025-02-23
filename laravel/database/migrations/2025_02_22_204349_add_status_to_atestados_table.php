<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('atestados', function (Blueprint $table) {
            $table->tinyInteger('status')->default(0)->after('company_id');
        });
    }

    public function down()
    {
        Schema::table('atestados', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }

};
