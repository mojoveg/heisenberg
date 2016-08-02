<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestCcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_ccs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('accountnum', 100);
            $table->string('accountnum1', 100);
            $table->string('accountnum2', 100);
            $table->string('accountnum3', 100);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('test_ccs');
    }
}
