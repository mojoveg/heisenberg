<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
#use Vendor\CybsSoapClient;
use CybsSoapClient;
use stdClass;

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

    public function testCC()
    {
		#require_once base_path('vendor/autoload.php');

		#require_once base_path('vendor/cybersource/sdk-php/lib/CybsSoapClient.php');
		#require_once (dirname(dirname(__FILE__)) . '/cybersource/sdk-php/lib/CybsSoapClient.php');

		$referenceCode = 'hopeisthethingwithfeathers';
		$client = new CybsSoapClient();
#		$client = new \Vendor\CybsSoapClient();
#$client = CybsSoapClient::create();

		$request = $client->createRequest($referenceCode);
		// Build a sale request (combining an auth and capture). In this example only
		// the amount is provided for the purchase total.
		$ccAuthService = new stdClass();
		$ccAuthService->run = 'true';
		$request->ccAuthService = $ccAuthService;
		$ccCaptureService = new stdClass();
		$ccCaptureService->run = 'true';
		$request->ccCaptureService = $ccCaptureService;
		$billTo = new stdClass();
		$billTo->firstName = 'John';
		$billTo->lastName = 'Doe';
		$billTo->street1 = '1295 Charleston Road';
		$billTo->city = 'Mountain View';
		$billTo->state = 'CA';
		$billTo->postalCode = '94043';
		$billTo->country = 'US';
		$billTo->email = 'null@cybersource.com';
		$billTo->ipAddress = '10.7.111.111';
		$request->billTo = $billTo;
		$card = new stdClass();
		$card->accountNumber = '4111111111111111';
		$card->expirationMonth = '12';
		$card->expirationYear = '2020';
		$request->card = $card;
		$purchaseTotals = new stdClass();
		$purchaseTotals->currency = 'USD';
		$purchaseTotals->grandTotalAmount = '90.01';
		$request->purchaseTotals = $purchaseTotals;
		$reply = $client->runTransaction($request);

		return redirect()->route('printDump')->with(['reply' => $reply]);
    }

    public function chargeFuel()
    {
    	# code...
    }

    public function testRedirect()
    {
    	// return redirect()->route('about');
		return redirect()->route('printDump')->with(['reply' => ["foo" => "bar","bar" => "foo",] ]);
    }

    public function gambino()
    {
    	$typeOfInvoices = DB::connection('mysql_motor')->select('SELECT typeOfInvoice, userShow FROM SIInvoiceTypes ORDER BY sortOrder DESC, typeOfInvoice');

    	// return $typeOfInvoices;

    	return view('gambino.index', ['typeOfInvoices' => $typeOfInvoices]);
    }
}
