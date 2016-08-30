<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIoccDhsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iocc_dhs', function (Blueprint $table) {
            $table->increments('id');

            #$table->integer('counter', true);
            $table->integer('pointer')->nullable();
            $table->string('CCcounter', 25)->nullable()->index('CCcounter');
            $table->string('CCnum', 50)->nullable()->index('CCnum');
            $table->string('CCname', 50)->nullable()->index('CCname');
            $table->date('CCexp')->nullable()->index('CCexp');
            $table->char('uid', 9)->nullable();
            $table->enum('declined', array('T'))->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('iocc_dhs');
    }
}
