<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class testccsController extends Controller
{
	public function test()
	{
		$var = 'test';

		DB::statement('
		INSERT INTO test_ccs
		(accountnum, accountnum1, accountnum2, accountnum3)

		SELECT accountnum, AES_ENCRYPT(accountnum, "e9NzdyXgPUDlIFo6cvuaRiQ0QdsIv+QlqpLsvqkrNhE=")
		, {{ $var }}, {{ $var }}
		FROM dinners_club_accounts
		');
	}
}
