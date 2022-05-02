<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyversesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dailyverses', function (Blueprint $table) {
            $table->charset     = 'utf8mb4';
            $table->collation   = 'utf8mb4_unicode_ci';
            $table->engine      = 'InnoDB';
            $table->increments('id');
            $table->string('book', 3);
            $table->string('chapter', 3);
            $table->string('verses', 10);
            $table->boolean('today');
            $table->boolean('used');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dailyverses');
    }
}
