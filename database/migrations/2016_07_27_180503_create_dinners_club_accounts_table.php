<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDinnersClubAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dinners_club_accounts', function (Blueprint $table) {
            $table->increments('id');

            $table->string('franchisecode', 25)->nullable();
            // $table->string('accountnum', 100)->default('')->index('accountnum');
            $table->string('accountnum', 100)->default('');
            $table->char('recordtype', 1)->nullable();
            $table->char('campus', 2)->nullable();
            $table->string('linkacctnum', 19)->nullable();
            $table->string('balanceacctnum', 19)->nullable();
            $table->string('accountname', 35)->nullable();
            $table->string('lastname', 30)->nullable();
            $table->string('firstname', 26)->nullable();
            $table->string('title', 22)->nullable();
            $table->char('acctlevel', 2)->nullable();
            $table->char('acctproduct', 1)->nullable();
            $table->char('billingcycle', 3)->nullable();
            $table->string('businessphone', 20)->nullable();
            $table->string('homephone', 20)->nullable();
            $table->string('addr1', 35)->nullable();
            $table->string('addr2', 35)->nullable();
            $table->string('addr3', 35)->nullable();
            $table->string('addr4', 35)->nullable();
            $table->string('city', 25)->nullable();
            $table->string('state', 20)->nullable();
            $table->string('postalcode', 11)->nullable();
            $table->string('countrycode', 30)->nullable();
            $table->string('contactname', 35)->nullable();
            $table->string('contacttitle', 26)->nullable();
            $table->string('contactphone', 20)->nullable();
            $table->string('indicative1', 10)->nullable();
            $table->string('indicative2', 10)->nullable();
            $table->string('indicative3', 10)->nullable();
            $table->string('indicative4', 10)->nullable();
            $table->string('indicative5', 10)->nullable();
            $table->string('indicative6', 10)->nullable();
            $table->date('dateupdated')->nullable();
            $table->date('dateacctopened')->nullable();
            $table->date('lastbillingdate')->nullable();
            $table->date('expirationdate')->nullable();
            $table->date('renewaldate')->nullable();
            $table->date('feebilleddate')->nullable();
            $table->date('dateissued')->nullable();
            $table->date('lastaddressnamechangedate')->nullable();
            $table->char('distributionflag', 1)->nullable();
            $table->char('photocardflag', 1)->nullable();
            $table->char('flightinsflag', 1)->nullable();
            $table->char('atmflag', 1)->nullable();
            $table->char('rewardsflag', 1)->nullable();
            $table->char('phoneflag', 1)->nullable();
            $table->char('productcode1', 1)->nullable();
            $table->char('productcode2', 1)->nullable();
            $table->char('productcode3', 1)->nullable();
            $table->char('productcode4', 1)->nullable();
            $table->char('productcode5', 1)->nullable();
            $table->string('airlinecentbillacctnum', 19)->nullable();
            $table->string('carcentbillacctnum', 19)->nullable();
            $table->string('hotelcentbillacctnum', 19)->nullable();
            $table->string('feecentbillacctnum', 19)->nullable();
            $table->string('restcentbillacctnum', 19)->nullable();
            $table->decimal('renewalfee', 16, 3)->nullable();
            $table->char('DCIcountryflag', 1)->nullable();
            $table->string('sourcecode', 20)->nullable();
            $table->string('accountstatus', 140)->nullable();
            $table->timestamp('modified')->default(DB::raw('CURRENT_TIMESTAMP'));
            // $table->integer('counter', true);
            // $table->index(['lastname','firstname'], 'lastname');

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
        Schema::drop('dinners_club_accounts');
    }
}
