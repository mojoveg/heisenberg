<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class testController extends Controller
{
    public function test1()
    {
		$var = 'test';

		DB::statement('
		DELETE FROM test_ccs		
		');    	

		DB::statement('
		INSERT INTO test_ccs
		(accountnum, accountnum1, accountnum2, accountnum3)

		SELECT accountnum, AES_ENCRYPT(accountnum, "e9NzdyXgPUDlIFo6cvuaRiQ0QdsIv+QlqpLsvqkrNhE=")
		, "'. $var .'", "'. $var  .'"
		FROM dinners_club_accounts
		');    	
    }
}
