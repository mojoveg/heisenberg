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
    public function gambinoPost(Request $request)
    {
		$typeOfInvoices = $request['typeOfInvoices'];

    	return redirect()->route('gambino')->with(['typeOfInvoices' => $typeOfInvoices]);
    }

    public function gambino2(Request $request)
    {
    	$typeOfInvoices = DB::connection('mysql_motor')->select('SELECT typeOfInvoice, userShow FROM SIInvoiceTypes ORDER BY sortOrder DESC, typeOfInvoice');

    	$itypeOfInvoices = $request['typeOfInvoices'];

    	return view('gambino.index2', ['typeOfInvoices' => $typeOfInvoices, 'itypeOfInvoices' => $itypeOfInvoices]);
    }

    public function gambino3()
    {
    	$invoices = DB::connection('mysql_motor')->select(
    		'SELECT descriptor, iteration from Gambino2 WHERE processedLVL IN ("some", "none") ORDER BY counter DESC'    	
    		);

    	// return $typeOfInvoices;

    	return view('gambino.index', ['invoices' => $invoices]);
    }

    public function gambino3Bill(Request $request)
    {
    	$sType = 'Fuel';
    	$userID = 43;
    	$sSIRun = 1248;

    	$sqlString = 'SELECT * FROM SIRun WHERE counter = '. $sSIRun;
    	$sql = DB::connection('mysql_motor')->select($sqlString);
    	// return $this->lockInvoices($invoices->SIRun);

    	// lock invoices
    	// Mathew Woodall = 43
// temp skip locking
if(0){
    	$sqlString = 
		'SELECT gl.*, u.USER_ID uName FROM Gambino2Lock gl '.
		'LEFT JOIN users u ON u.counter = gl.userID '.
		'WHERE typeOfInvoice = "'. $sType .'"';

		$sql =  DB::connection('mysql_motor')->select($sqlString);

	echo $sql[0]->typeOfInvoice;
	echo $sql[0]->userID;


// dd();
		if ($sql[0]->userID != '') {
			dd('Invoices Locked by '.$sql[0]->userID);
		}
		else {
	    	$sqlString = 
			'UPDATE Gambino2Lock '.
			'SET userID = '. $userID .
			' WHERE typeOfInvoice = "'. $sType .'"';

			$sql =  DB::connection('mysql_motor')->update($sqlString);

		}
}
		// list all invoices
		$sSQL =
		'SELECT invoiceNum, '.
		'numOfTran, totalCharge, IOPay.paymentType, '.
		'if(IOPay.paymentType = "Credit", cc.CCName, IOPay.payment) payment, '.
		'IOPay.subdivide, IOPay.deptName, IOPay.campusName, '.
	'SIRun.startDate, SIRun.endDate, SIRun.descriptor, cc.CCNumD CCNum, cc.CCexp '.
		', SIRun.typeOfInvoice, month(cc.CCexp) ccMonth, year(cc.CCexp) ccYear, t.IOPay '.
		', ToBeBilled, Billed '.
		', ToDo, IF(Processed IS NOT NULL, "T", "F") Processed, ToCredit, IF(ProcessedC IS NOT NULL, "T", "F") ProcessedC '.
		', SIRun.typeOfInvoice sType, t.JOB_NUM tJobNum '.
		', dateOut, workCharge, partsCharge, woFlag '.
		', JVnum, BillDate, Date_Format(NOW(), "%m/%d/%Y") fNowDate '.
		',IF(IOPay.paymentType = "FRS", '.
		' IF(IOPay.payment REGEXP "^0[3478]-[0-9]{6}$" = 1, "C", '.
		' IF(IOPay.payment REGEXP "^[45][0-9]{5}$" = 1, "B", '.
		' IF(IOPay.payment REGEXP "^[0-9]{6}$" = 1, "A", NULL))),NULL) FRStype '.
		', billError, creditInvNum, cc.declined, cc.counter ccCounter '.
		'FROM SITable t '.
		'LEFT JOIN IOPay on IOPay.counter = t.IOPay '.
		'LEFT JOIN  SIRun on SIRun.counter = t.SIRun '.
	'LEFT JOIN motor_heisenberg.IOCC_D cc on IOPay.payment = cc.counter and IOPay.paymentType = "Credit" '.
		'where t.SIRun = "'. $sSIRun .'" '.
		'ORDER BY woFlag, IOPay.paymentType, cc.CCName, IOPay.payment, tJobNum, invoiceNum';

		$SITableQry =  DB::connection('mysql_motor')->select($sSQL);

	 echo $SITableQry[0]->totalCharge ;
echo $SITableQry[0]->Processed;
echo $SITableQry[0]->billError;
	  echo  "\n";
echo '1';
		//bill something
		 $i = 0;
		 $j = 0;
		 $k = 0;
		 foreach($SITableQry as $line){
		 	if($line->Processed == 'F'){
		 	if($line->billError != '1'){
echo '1';		 		
		 		$a[$i] = $line->invoiceNum;
		 		$b[$i] = $line->ToDo;
		 		if($b[$i] == ''){
		 			$b[$i] = 'NULL';
		 		} else {
		 			if($b[$i] == 'To Bill') {
		 				if($line->declined == 'T') {
							$sSQL = 
							'UPDATE SITable '.
							'SET billError = 1 '.
							'WHERE invoiceNum = '. $line->invoiceNum;
							$sql =  DB::connection('mysql_motor')->update($sSQL);
		 				} else {
		 					$sCardNum = $line->CCNum;

					         $sType = $line->typeOfInvoice;    //'Rental';
					         $sCharge = $line->totalCharge;    //'20.01';
					         $sCode = '7522';
					         $sCustCode = $line->IOPay;        //'1234';
					         $sInvoiceNum = $line->invoiceNum; //'1234567892';
					         $sExpMonth = $line->ccMonth;      //'12';
					         $sExpYear = $line->ccYear;        //'2010';
					         $sName = $line->payment;           //'Darius McHenry';
					         //sEmail := 'darius@mercury.umd.edu';
					         $sEmail = 'as@mercury.umd.edu';
					         $sZip = '20742';
					         $sStreetNum = '8320';
					         $sCity = 'College Park';
					         $sState = 'MD';
					         $sPhone = '301-405-9129';
					         $bTesting = 'FALSE';
					         $sCreditInvNum = $line->creditInvNum;

					         if(($sType == 'Rental') or ($sType == 'WordOrder')){
					         	$sNum = $line->tJobNum;
					         } else {
					         	$sNum = $sInvoiceNum;
					         }

					         $sCone = '7540';

					         // Zip code
					         if (($sName == 'SPOKES, BRENDAN K.') or ($sName == 'Wheeler, Charles')) {
					            $sZip = '20195';
					         }
					         elseif (($sName == 'HAWKINS, LISA')) {
					            $sZip = '35223';
					         }
					         elseif (($sName == 'BOWEN, KELLIE')) {
					            $sZip = '28208';
					         }



		 				}

		 			}
		 		} 

				$referenceCode = $sNum;
				$client = new CybsSoapClient();
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
				$billTo->firstName = $sName;
				$billTo->lastName = $sName;
				$billTo->street1 =$sStreetNum;
				$billTo->city = $sCity;
				$billTo->state = $sState;
				$billTo->postalCode = $sZip;
				$billTo->country = 'US';
				$billTo->email = $sEmail;
				$billTo->ipAddress = '10.7.111.111';
				$request->billTo = $billTo;
				$card = new stdClass();
				$card->accountNumber = $sCardNum;
				$card->expirationMonth = $sExpMonth;
				$card->expirationYear = $sExpYear;
				$request->card = $card;
				$purchaseTotals = new stdClass();
				$purchaseTotals->currency = 'USD';
				$purchaseTotals->grandTotalAmount = $sCharge;
				$request->purchaseTotals = $purchaseTotals;
// dd($request);
// echo '<pre>';
// var_dump($request);
// echo '</pre>';

				$reply = $client->runTransaction($request);
echo '<pre>';
var_dump($reply);
echo '</pre>';


		 	}	
		 	}


		 }
		 	






		 // dd($sql);
		 // echo $SITableQry[0]->totalCharge;
		// echo $sql[0]->userID;



    }

    public function lockInvoices($SIRun)
    {
    	$sqlString = 
		'SELECT gl.*, u.USER_ID uName FROM Gambino2Lock gl '.
		'LEFT JOIN users u ON u.counter = gl.userID '.
		'WHERE typeOfInvoice = "Fuel"';

		$sql =  DB::connection('mysql_motor')->select($sqlString);

		// echo $sql->gl.typeOfInvoice;
		echo $sql;

    }

}
