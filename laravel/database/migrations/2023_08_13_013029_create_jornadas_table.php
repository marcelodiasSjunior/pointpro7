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
        Schema::create('jornadas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->mediumText('description');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->integer('segunda')->default(0);
            $table->integer('terca')->default(0);
            $table->integer('quarta')->default(0);
            $table->integer('quinta')->default(0);
            $table->integer('sexta')->default(0);
            $table->integer('sabado')->default(0);
            $table->integer('domingo')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jornadas');
    }
};
