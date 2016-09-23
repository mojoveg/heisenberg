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
    	$sTesting = 'TRUE';

    	$sTesting = 'FALSE';

    	$sTypeHold = 'Fuel';
    	$userID = 43;
    	$sSIRun = 1252;

    	$sSIRunTable = 'SIRun';
    	$sSITableTable = 'SITable';
		$sCCchargeTable = 'CCcharge';
		$sInvoiceEmailTable = 'InvoiceEmail';
		$sfuel_gasbuddyTable = 'fuel_gasbuddy';
		$sfuel_gasbuddy_paymentTable = 'fuel_gasbuddy_payment';
		$sGambino2Table = 'Gambino2';
   	
    	if($sTesting == 'TRUE'){
    		// '. $sSIRun .'
	    	$sSIRunTable = 'motor_heisenberg.SIRun';
	    	$sSITableTable = 'motor_heisenberg.SITable';
 			$sCCchargeTable = 'motor_heisenberg.CCcharge';
 			$sInvoiceEmailTable = 'motor_heisenberg.InvoiceEmail';
 			$sfuel_gasbuddyTable = 'motor_heisenberg.fuel_gasbuddy';
 			$sfuel_gasbuddy_paymentTable = 'motor_heisenberg.fuel_gasbuddy_payment';
 			$sGambino2Table = 'motor_heisenberg.Gambino2';


 			$sSQL = 'DELETE FROM motor_heisenberg.SIRun';
	    	$sql = DB::connection('mysql_motor')->update($sSQL);
 			$sSQL = 'DELETE FROM motor_heisenberg.SITable';
	    	$sql = DB::connection('mysql_motor')->update($sSQL);
 			$sSQL = 'DELETE FROM motor_heisenberg.Gambino2';
	    	$sql = DB::connection('mysql_motor')->update($sSQL);
 			$sSQL = 'DELETE FROM motor_heisenberg.fuel_gasbuddy';
	    	$sql = DB::connection('mysql_motor')->update($sSQL);
 			$sSQL = 'DELETE FROM motor_heisenberg.fuel_gasbuddy_payment';
	    	$sql = DB::connection('mysql_motor')->update($sSQL);


 			$sSQL = 
 			'INSERT INTO motor_heisenberg.SIRun '.
 			'(counter, invoiceStart, invoiceEnd, typeOfInvoice, descriptor, iteration, tableName,  '.
 			'startDate, endDate, runDate, paid, deleted, credit, rules) '.

 			'SELECT * FROM Motor_Mysql.SIRun WHERE counter = '. $sSIRun .' ';
 			;
	    	$sql = DB::connection('mysql_motor')->update($sSQL);


 			$sSQL = 
 			'INSERT INTO motor_heisenberg.SITable  '.
 			'(SIRun, invoiceNum, JOB_NUM, numOfTran, totalCharge, workCharge, partsCharge, IOPay,  '.
 			'paymentType, payment, subdivide, campus, dept, totalQuantity, tripnum, woFlag, dateOut,  '.
 			'destination, COMMENT, charged, temp_invoiceNum, BillDate, JVnum, ToBeBilled, Billed,  '.
 			'ToDo, processed, ToCredit, processedC, creditInvNum, billError) '.

 			'SELECT * FROM Motor_Mysql.SITable WHERE SIRun = '. $sSIRun .' ';
	    	$sql = DB::connection('mysql_motor')->update($sSQL);


 			$sSQL = 
 			'INSERT INTO motor_heisenberg.Gambino2  '.
 			'(counter, typeOfInvoice, descriptor, iteration, startDate, endDate, noteG,  '.
 			'processedLVL, processedAll, doNotProcess, credit) '.

 			'SELECT g.* FROM Motor_Mysql.Gambino2 g '.
 			'LEFT JOIN Motor_Mysql.Gambino2SubR gs ON gs.Gambino2 = g.counter '.
 			'WHERE SIRUn = '. $sSIRun .' '.
 			'LIMIT 1 ';
	    	$sql = DB::connection('mysql_motor')->update($sSQL);

	    	if($sTypeHold == "Fuel"){
	 			$sSQL = 
	 			'INSERT INTO motor_heisenberg.fuel_gasbuddy  '.
	 			'(site, tran, keyIn, veh, dept, emp, dept2, DATE, TIME, pu, pr, ta, trans, cum_veh,  '.
	 			'cum_emp, odom, miles, err, filename, counter, paid) '.

	 			'SELECT f.* FROM Motor_Mysql.SITable t '.
	 			'LEFT JOIN Motor_Mysql.SIFuel  s ON t.invoiceNum = s.invoiceNum  '.
	 			'LEFT JOIN Motor_Mysql.fuel_gasbuddy f ON s.time = f.time AND s.tranNum = f.tran AND s.date = f.date  '.
	 			'WHERE SIRun = '. $sSIRun .' '.
	 			// AND processed IS NOT NULL 
	 			'AND ToDo IN ("To Bill", "Manual Bill", "Never Bill") '.
	 			'GROUP BY f.counter ';
		    	$sql = DB::connection('mysql_motor')->update($sSQL);


	 			$sSQL = 
	 			'INSERT INTO motor_heisenberg.fuel_gasbuddy_payment  '.
	 			'(VIN, IOPay, campusOld, campus, dept, FRS, payment_type, payment, creditOld, gasboy_veh,  '.
	 			'gasboy_dept, startdate, enddate, detail, detail_comment, subdivide, charge_subdivide_by_itself,  '.
	 			'counter, editable, uneditableEndDate) '.

	 			'SELECT pay.* FROM Motor_Mysql.SIFuel sf  '.
	 			'LEFT JOIN Motor_Mysql.SITable s ON s.invoiceNum = sf.invoiceNum  '.
	 			'LEFT JOIN Motor_Mysql.fuel_gasbuddy_payment pay ON sf.date BETWEEN pay.startDate AND pay.endDate  '.
	 			'AND s.IOPay = pay.IOPay AND sf.VIN = pay.VIN  '.
	 			'WHERE SIRun = '. $sSIRun .' '.
	 			 // AND processed IS NOT NULL 
	 			'AND ToDo IN ("To Bill", "Manual Bill", "Never Bill") '.
	 			'GROUP BY pay.counter ';
		    	$sql = DB::connection('mysql_motor')->update($sSQL);
	    	}

    	}

    	$sqlString = 'SELECT * FROM '. $sSIRunTable .' WHERE counter = '. $sSIRun;
    	$sql = DB::connection('mysql_motor')->select($sqlString);
    	// return $this->lockInvoices($invoices->SIRun);

    	// lock invoices
    	// Mathew Woodall = 43
		
		// temp skip locking
		// if(0){
$sqlString = 
'UPDATE Gambino2Lock SET userID = NULL';
$sql =  DB::connection('mysql_motor')->update($sqlString);

    	$sqlString = 
		'SELECT gl.*, u.USER_ID uName FROM Gambino2Lock gl '.
		'LEFT JOIN users u ON u.counter = gl.userID '.
		'WHERE typeOfInvoice = "'. $sTypeHold .'"';

		$sql =  DB::connection('mysql_motor')->select($sqlString);

		// echo $sql[0]->typeOfInvoice;
		// echo $sql[0]->userID;


		// dd();
		if ($sql[0]->userID != '') {
			dd('Invoices Locked by '.$sql[0]->userID);
		}
		else {
	    	$sqlString = 
			'UPDATE Gambino2Lock '.
			'SET userID = '. $userID .
			' WHERE typeOfInvoice = "'. $sTypeHold .'"';

			$sql =  DB::connection('mysql_motor')->update($sqlString);

		}
		// } // skip locking

		// list all invoices
		$sSQL =
		'SELECT invoiceNum, '.
		'numOfTran, totalCharge, IOPay.paymentType, '.
		'if(IOPay.paymentType = "Credit", cc.CCName, IOPay.payment) payment, '.
		'IOPay.subdivide, IOPay.deptName, IOPay.campusName, '.
		// CCNumD
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
			',IF(LOCATE(",", cc.CCName) >0, SUBSTRING_INDEX(cc.CCName, ",", 1), cc.CCName) lastName '.
			',IF(LOCATE(",", cc.CCName) >0, SUBSTRING_INDEX(cc.CCName, ",", -1), cc.CCName) firstName '.		
		'FROM '. $sSITableTable .' t '.
		'LEFT JOIN IOPay on IOPay.counter = t.IOPay '.
		'LEFT JOIN  '. $sSIRunTable .' on SIRun.counter = t.SIRun '.
		// IOCC_D
			'LEFT JOIN motor_heisenberg.IOCC_D cc on IOPay.payment = cc.counter and IOPay.paymentType = "Credit" '.
		'where t.SIRun = "'. $sSIRun .'" '.
		'ORDER BY woFlag, IOPay.paymentType, cc.CCName, IOPay.payment, tJobNum, invoiceNum';

		$SITableQry =  DB::connection('mysql_motor')->select($sSQL);

		// echo $SITableQry[0]->totalCharge ;
		// echo $SITableQry[0]->Processed;
		// echo $SITableQry[0]->billError;
		// echo  "\n";
		// echo '1';

		//bill something
		 $i = 0;
		 $j = 0;
		 $k = 0;
		 foreach($SITableQry as $line){

		 	// sql breadcrumb start
		 	$sSQL = 
		 	'INSERT INTO  motor_heisenberg.breadcrumb '.
		 	'(invoiceNum, typeOfInvoice, totalCharge, IOPay, Processed, billError) '.
		 	'values ("'.
		 	$line->invoiceNum .'", "'.
		 	$line->typeOfInvoice .'", "'.
		 	$line->totalCharge .'", "'.
		 	$line->IOPay .'", "'.
		 	$line->Processed .'", "'.
		 	$line->billError .'")';
		 	$sql =  DB::connection('mysql_motor')->update($sSQL);

			$sSQL = 
			'SELECT max(id) as id FROM motor_heisenberg.breadcrumb'; 
			$sql =  DB::connection('mysql_motor')->select($sSQL);	
			$debugID = $sql[0]->id;
			$debugCount = 0;

		 	if($line->Processed == 'F'){
		 	if($line->billError != '1'){

		 		// sql breadcrumb 
		 		$debugCount = $debugCount +1;
		 		$sSQL = 
		 		'UPDATE motor_heisenberg.breadcrumb '.
		 		'SET debug = ' . $debugCount . 
		 		' WHERE id = ' . $debugID;
		 		$sql =  DB::connection('mysql_motor')->update($sSQL);

				// echo '1';		 		
		 		// $i is pointless and always stays 0, even in gambino delphi
		 		$a[$i] = $line->invoiceNum;
		 		$b[$i] = $line->ToDo;
		 		if($b[$i] == ''){
		 			$b[$i] = 'NULL';
		 		} else {
		 			if($b[$i] == 'To Bill') {

		 				// sql breadcrumb 
		 				$debugCount = $debugCount +1;
		 				$sSQL = 
		 				'UPDATE motor_heisenberg.breadcrumb '.
		 				'SET debug = ' . $debugCount . 
		 				' WHERE id = ' . $debugID;
		 				$sql =  DB::connection('mysql_motor')->update($sSQL);


		 				if($line->declined == 'T') {
							$sSQL = 
							'UPDATE '. $sSITableTable .' '.
							'SET billError = 1 '.
							'WHERE invoiceNum = '. $line->invoiceNum;
							$sql =  DB::connection('mysql_motor')->update($sSQL);
		 				} else {

		 					// sql breadcrumb 
		 					$debugCount = $debugCount +1;
		 					$sSQL = 
		 					'UPDATE motor_heisenberg.breadcrumb '.
		 					'SET debug = ' . $debugCount . 
		 					' WHERE id = ' . $debugID;
		 					$sql =  DB::connection('mysql_motor')->update($sSQL);


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


					     $sNum = $sInvoiceNum;
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



		 				// }

		 		// 	}
		 		// } 

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
						$billTo->firstName = $line->firstName;
						$billTo->lastName = $line->lastName;
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

				 		// sql breadcrumb 
				 		$debugCount = $debugCount +1;
				 		$sSQL = 
				 		'UPDATE motor_heisenberg.breadcrumb '.
				 		'SET debug = ' . $debugCount . 
				 		' WHERE id = ' . $debugID;
				 		$sql =  DB::connection('mysql_motor')->update($sSQL);


					   $sSQL = 
						'insert into '. $sCCchargeTable .' '.
						'(sType, sCharge, sCode, sInvoiceNum, sZip, sCardNum, sExpMonth, sExpYear, sName, sEmail, '.
					        'sStreetNum, sCity, sState, sPhone, bTesting, tStamp) '.
						'values ("'.
							$sType .'", "'.
					        $sCharge .'", "'.
					        $sCode .'", "'.
					        // $sInvoiceNum .'", "'.
					        $sNum .'", "'.
					        $sZip .'", "'.
					        $sCardNum .'", "'.
					        $sExpMonth .'", "'.
					        $sExpYear .'", "'.
					        $sName .'", "'.
					        $sEmail .'", "'.
					        $sStreetNum .'", "'.
					        $sCity .'", "'.
					        $sState .'", "'.
					        $sPhone .'", "'.
					        'FALSE", NOW())';		
					    $sql =  DB::connection('mysql_motor')->update($sSQL);	

					    $sSQL = 
						'SELECT max(counter) as counter FROM '. $sCCchargeTable .''; 
					    $sql =  DB::connection('mysql_motor')->select($sSQL);	

					    $sCCchargeCounter = $sql[0]->counter;
						
						echo $sCCchargeCounter;

						$reply = $client->runTransaction($request);

					    $result_codes = [
					        '100' => 'Successful transaction.',
					        '101' => 'The request is missing one or more required fields.',
					        '102' => 'One or more fields in the request contains invalid data.',
					        '104' => 'The access key and transaction uuid fields for this authorization request matches the access_key and transaction_uuid of another authorization request that you sent within the past 15 minutes.',
					        '110' => 'Only a partial amount was approved.',
					        '150' => 'Error: General system failure.',
					        '151' => 'Error: The request was received but there was a server timeout.',
					        '152' => 'Error: The request was received, but a service did not finish running in time.',
					        '200' => 'The authorization request was approved by the issuing bank but declined by CyberSource because it did not pass the Address Verification Service (AVS) check.',
					        '201' => 'The issuing bank has questions about the request.',
					        '202' => 'Expired card.',
					        '203' => 'General decline of the card.',
					        '204' => 'Insufficient funds in the account.',
					        '205' => 'Stolen or lost card.',
					        '207' => 'Issuing bank unavailable.',
					        '208' => 'Inactive card or card not authorized for card-not-present transactions.',
					        '209' => 'American Express Card Identification Digits (CID) did not match.',
					        '210' => 'The card has reached the credit limit.',
					        '211' => 'Invalid CVN.',
					        '221' => 'The customer matched an entry on the processor\'s negative file.',
					        '222' => 'Account frozen.',
					        '230' => 'The authorization request was approved by the issuing bank but declined by CyberSource because it did not pass the CVN check.',
					        '231' => 'Invalid credit card number.',
					        '232' => 'The card type is not accepted by the payment processor.',
					        '233' => 'General decline by the processor.',
					        '234' => 'There is a problem with your CyberSource merchant configuration.',
					        '235' => 'The requested amount exceeds the originally authorized amount.',
					        '236' => 'Processor failure.',
					        '237' => 'The authorization has already been reversed.',
					        '238' => 'The authorization has already been captured.',
					        '239' => 'The requested transaction amount must match the previous transaction amount.',
					        '240' => 'The card type sent is invalid or does not correlate with the credit card number.',
					        '241' => 'The request ID is invalid.',
					        '242' => 'You requested a capture, but there is no corresponding, unused authorization record.',
					        '243' => 'The transaction has already been settled or reversed.',
					        '246' => 'The capture or credit is not voidable because the capture or credit information has laready been submitted to your processor. Or, you requested a void for a type of transaction that cannot be voided.',
					        '247' => 'You requested a credit for a capture that was previously voided.',
					        '250' => 'Error: The request was received, but there was a timeout at the payment processor.',
					        '475' => 'The cardholder is enrolled for payer authentication.',
					        '476' => 'Payer authentication could not be authenticated.',
					        '520' => 'The authorization request was approved by the issuing bank but declined by CyberSource based on your Smart Authorization settings.',
					    ];


						// This section will show all the reply fields.
						echo '<pre>';
						print("\nAUTH RESPONSE: " . print_r($reply, true));

						if ($reply->decision != 'ACCEPT') {
						    print("\nFailed auth request.\n");
						    // return;
						}

						// Build a capture using the request ID in the response as the auth request ID
						$ccCaptureService = new stdClass();
						$ccCaptureService->run = 'true';
						$ccCaptureService->authRequestID = $reply->requestID;

						$captureRequest = $client->createRequest($referenceCode);
						$captureRequest->ccCaptureService = $ccCaptureService;
						// $captureRequest->item = array($item0, $item1);
						$captureRequest->purchaseTotals = $purchaseTotals;

						$captureReply = $client->runTransaction($captureRequest);

						// This section will show all the reply fields.
						print("\nCAPTURE RESPONSE: " . print_r($captureReply, true));

						print("Code: ". $result_codes[$reply->reasonCode] . "\n");

						echo '</pre>';

						// sql breadcrumb 
						$debugCount = $debugCount +1;
						$sSQL = 
						'UPDATE motor_heisenberg.breadcrumb '.
						'SET debug = ' . $debugCount . 
						' WHERE id = ' . $debugID;
						$sql =  DB::connection('mysql_motor')->update($sSQL);


						if ($reply->decision != 'ACCEPT') {

							// sql breadcrumb 
							$sSQL = 
							'UPDATE motor_heisenberg.breadcrumb '.
							'SET debugInfo = "laura" ' . 
							' WHERE id = ' . $debugID;
							$sql =  DB::connection('mysql_motor')->update($sSQL);


							$sSQL = 
							'UPDATE '. $sCCchargeTable .' SET declined = "T" '.
							' WHERE counter = '. $sCCchargeCounter;
							$sql =  DB::connection('mysql_motor')->update($sSQL);
						}



						if ($reply->decision != 'ACCEPT') {

							$sSQL = 
							'UPDATE motor_heisenberg.breadcrumb '.
							'SET debugInfo = "mathew" ' . 
							' WHERE id = ' . $debugID;
							$sql =  DB::connection('mysql_motor')->update($sSQL);


							$sSQL = 'UPDATE '. $sSITableTable .' '.
							'SET billError = 1 '.
							// 'WHERE invoiceNum = ' . $sInvoiceNum;
							'WHERE invoiceNum = ' . $sNum;
							$sql =  DB::connection('mysql_motor')->update($sSQL);

							$sSQL = 
							// 'UPDATE IOCC '.
							'UPDATE motor_heisenberg.IOCC_D '.
							'SET declined = "T" '.
							'WHERE counter = ' . $line->ccCounter;
							$sql =  DB::connection('mysql_motor')->update($sSQL);

						}
						else {

							$sSQL = 
							'UPDATE motor_heisenberg.breadcrumb '.
							'SET debugInfo = "chris" ' . 
							' WHERE id = ' . $debugID;
							$sql =  DB::connection('mysql_motor')->update($sSQL);

							$sSQL = 
							'UPDATE '. $sCCchargeTable .' SET transactionID = "'. $reply->requestID .'" '.
							' WHERE counter = '. $sCCchargeCounter;
							$sql =  DB::connection('mysql_motor')->update($sSQL);


							$sSQL = 'UPDATE '. $sSITableTable .' '.
							'SET processed = NOW() '.
							// 'WHERE invoiceNum = ' . $sInvoiceNum;
							'WHERE invoiceNum = ' . $sNum;
							$sql =  DB::connection('mysql_motor')->update($sSQL);

							// do we ever use this variable?
							// $bAnythingProcessed := TRUE;


							//email
							if (($sType == 'Fuel') or ($sType == 'Carwash') or ($sType == 'FleetCard')) {
							  $sSQL = 'UPDATE '. $sSITableTable .' '.
							  'SET BillDate = DATE(NOW()) '.
							  // 'WHERE invoiceNum = "'. $sInvoiceNum . '"';
							  'WHERE invoiceNum = "'. $sNum . '"';
							}  
							elseif($sType == 'Rental') {
							  if($sTesting != 'TRUE'){	
								  $sSQL = 'UPDATE renrec '.
								  'SET BillDate = DATE(NOW()) '.
								  // 'WHERE JOB_NUM = "'. $sInvoiceNum . '"';
								  'WHERE JOB_NUM = "'. $sNum . '"';
							  }
							}
							elseif($sType == 'WorkOrder') {
							  $sSQL = 'UPDATE workorders '.
							  'SET billDate = DATE(NOW()) '.
							  // 'WHERE wonumber = "'. $sInvoiceNum . '"';
							  'WHERE wonumber = "'. $sNum . '"';
							}
							if(($sType == 'Fuel') or ($sType == 'Carwash') or ($sType == 'FleetCard') or
							  ($sType == 'Rental') or ($sType == 'WorkOrder')) {
								$sql =  DB::connection('mysql_motor')->update($sSQL);
							}

							  // Email
							$sSQL = 
							'INSERT INTO  '. $sInvoiceEmailTable .' (InvType, email, body, filename, '.
							  'Charge, InvoiceNum, BillDate, startDate, endDate, '.
							  'emailFrom, emailCC, Subject) ';
							if($sType == 'Fuel') {
							  $sSQL = $sSQL .
							  'SELECT "Fuel", e.Email, "Body", CONCAT("Fuel ", t.invoiceNum, ".pdf"), '.
							  't.totalCharge, t.invoiceNum, t.BillDate, r.startDate, r.endDate, '.
							  '"MTSinvoices@mercury.umd.edu", '.
							  '"MTSinvoices@mercury.umd.edu", '.
							  '"Fuel Invoice" '.
							  'FROM '. $sSITableTable .' t '.
							  'LEFT JOIN SIRun r ON r.counter = t.SIRun '.
							  'LEFT JOIN IOPay_email e ON e.IOPay = t.IOPay '.
							  // 'WHERE invoiceNum = "'. $sInvoiceNum . '"';
							  'WHERE invoiceNum = "'. $sNum . '"';

								$sql =  DB::connection('mysql_motor')->update($sSQL);
							}
							elseif($sType == 'Rental') {
							  $sSQL = $sSQL .
							  // 'SELECT "Rental", e.Email, "Body", CONCAT("Rental ", "'. $sInvoiceNum .'", ".pdf"), '.
							  'SELECT "Rental", e.Email, "Body", CONCAT("Rental ", "'. $sNum .'", ".pdf"), '.
							  'bill.rSum, r.JOB_NUM, r.BillDate, r.startDate, r.endDate, '.
							  '"MTSinvoices@mercury.umd.edu", '.
							  '"MTSinvoices@mercury.umd.edu", '.
							  '"Rental Invoice" '.
							  'FROM renrec r '.
							  'LEFT JOIN ( '.
							  '   SELECT rentalno, SUM(quantity*rate) rSum '.
							  // '   FROM rentalbillinginfo WHERE rentalno = "'. $sInvoiceNum . '" '.
							  '   FROM rentalbillinginfo WHERE rentalno = "'. $sNum . '" '.
							  ') bill ON r.JOB_NUM = bill.rentalno '.
							  'LEFT JOIN IOPay_email e ON e.IOPay = r.IOPay '.
							  // 'WHERE r.JOB_NUM = "'. $sInvoiceNum . '"';
							  'WHERE r.JOB_NUM = "'. $sNum . '"';

								$sql =  DB::connection('mysql_motor')->update($sSQL);

							}


						}


					}





		 			}
		 		} 

				// echo '<pre>';
				// var_dump($reply);
				// echo '</pre>';


		 	}	
		 	}

		 	// dd("die");
		 }  // foreach
		 	
		 // Update all of motor's records START
		 $sSQL = 'SELECT * FROM '. $sSITableTable .' '.
		 'WHERE SIRun = '. $sSIRun .
		 ' AND ToDo IS NULL';
		 $sql =  DB::connection('mysql_motor')->select($sSQL);
		 if (sizeof($sql) == 0) {
		    $sSQL = 'UPDATE '. $sSITableTable .' SET processed = NOW() '.
		    'WHERE SIRun = '. $sSIRun .
		    ' AND ToDo IN ("Manual Bill", "Never Bill", "Hold") AND processed IS NULL';
		    $sql =  DB::connection('mysql_motor')->update($sSQL);
		 }
		 else {
		    $sSQL = 'UPDATE '. $sSITableTable .' SET processed = NOW() '.
		    'WHERE SIRun = '. $sSIRun .
		    ' AND ToDo IN ("Manual Bill", "Never Bill") AND processed IS NULL';
		    $sql =  DB::connection('mysql_motor')->update($sSQL);
		 }


    // 		// '. $sGambino2Table .'
	   //  	$sSIRunTable = 'motor_heisenberg.SIRun';
	   //  	$sSITableTable = 'motor_heisenberg.SITable';
 			// $sCCchargeTable = 'motor_heisenberg.CCcharge';
 			// $sInvoiceEmailTable = 'motor_heisenberg.InvoiceEmail';
 			// $sfuel_gasbuddyTable = 'motor_heisenberg.fuel_gasbuddy';
 			// $sfuel_gasbuddy_paymentTable = 'motor_heisenberg.fuel_gasbuddy_payment';
 			// $sGambino2Table = 'motor_heisenberg.Gambino2';

// $sRenrc = "motor_heisenberg.renrec";
// $sRenecBilled = "motor_heisenberg.renrecBilled";

		//motor_heisenberg.
		 //else
		 if (($sTypeHold == 'Fuel') or ($sTypeHold == 'Propane')) {
		    $sSQL =
		    'UPDATE '. $sSITableTable .' t '.
			'LEFT JOIN SIFuel s ON t.invoiceNum = s.invoiceNum '.
			'LEFT JOIN '. $sfuel_gasbuddyTable .' f ON s.time = f.time AND s.tranNum = f.tran AND s.date = f.date '.
		    'SET paid = "T" '.
		    'WHERE SIRun = '. $sSIRun.
		    ' AND processed IS NOT NULL '.
		    'AND ToDo IN ("To Bill", "Manual Bill", "Never Bill")';
		    $sql =  DB::connection('mysql_motor')->update($sSQL);

		    // Set the fuel info found in Vehrec form to uneditable
		    $sSQL =
			'UPDATE SIFuel sf '.
		    'LEFT JOIN '. $sSITableTable .' s ON s.invoiceNum = sf.invoiceNum '.
			'LEFT JOIN '. $sfuel_gasbuddy_paymentTable .' pay ON sf.date BETWEEN pay.startDate AND pay.endDate '.
		    'AND s.IOPay = pay.IOPay AND sf.VIN = pay.VIN '.
		    'SET pay.editable = "F", pay.uneditableEndDate = GREATEST(sf.date, pay.uneditableEndDate) '.
		    'WHERE SIRun = '. $sSIRun.
		    ' AND processed IS NOT NULL '.
		    'AND ToDo IN ("To Bill", "Manual Bill", "Never Bill")';
		    $sql =  DB::connection('mysql_motor')->update($sSQL);
		 }

		if ($sTypeHold == 'Rental'){
		 if($sTesting != 'TRUE'){	
		    // set billdate for KFS
		    $sSQL =
		    'UPDATE SITable t '.
		    'LEFT JOIN SIRun r ON t.SIRun = r.counter '.
		    'LEFT JOIN renrecBilled rb ON rb.rennum = t.JOB_NUM '.
		    // 'LEFT JOIN '.$srenrec.' ren ON ren.JOB_NUM = t.JOB_NUM '.
		    'LEFT JOIN renrec ren ON ren.JOB_NUM = t.JOB_NUM '.
		    'SET ren.BillDate = DATE(NOW()) '.
		    'WHERE SIRun = '.$sSIRun.' AND processed IS NOT NULL '.
		    'AND ToDo IN ("Manual Bill", "Never Bill") '.
		    'AND rb.rennum IS NULL '.
		    'AND r.typeOfInvoice = "Rental"';
		    $sql =  DB::connection('mysql_motor')->update($sSQL);

		    $sSQL =
		    'INSERT INTO renrecBilled (rennum) SELECT JOB_NUM FROM SITable t '.
		    'LEFT JOIN SIRun r ON t.SIRun = r.counter '.
		    'LEFT JOIN renrecBilled rb ON rb.rennum = t.JOB_NUM '.
		    'WHERE SIRun = '.$sSIRun.' AND processed IS NOT NULL '.
		    'AND ToDo IN ("To Bill", "Manual Bill", "Never Bill") '.
		    'AND rb.rennum IS NULL '.
		    'AND r.typeOfInvoice = "Rental"';
		    $sql =  DB::connection('mysql_motor')->update($sSQL);
		 }
		}

		  // Update all of motor's records END
		 if (($sTypeHold == 'Fuel') or
		     ($sTypeHold == 'Carwash') or
		     ($sTypeHold == 'WorkOrder') or
		     ($sTypeHold == 'Rental') or
		     ($sTypeHold == 'EZPass') or
		     ($sTypeHold == 'FleetCard') or
		     ($sTypeHold == 'Violation') or
		     ($sTypeHold == 'Propane')) {
		    // Update Gambino2
		    $sSQL = 'SELECT COUNT(ToDo) cToDo, COUNT(processed) cProc, COUNT(*) cTotal FROM '. $sSITableTable .' '.
		    'WHERE SIRun = '. $sSIRun;
		    $sql =  DB::connection('mysql_motor')->select($sSQL);

		    $cToDoPost = $sql[0]->cToDo;
		    $cProcPost = $sql[0]->cProc;
		    $cTotalPost = $sql[0]->cTotal;

		    // All invoices processed
		    if($cTotalPost == $cProcPost) {
		       $sSQL =
				'UPDATE '. $sGambino2Table .' g '.
		       'LEFT JOIN Gambino2SubR gs ON gs.Gambino2 = g.counter '.
		       'SET processedLVL = "all" '.
		       'WHERE SIRun = '. $sSIRun;
			    $sql =  DB::connection('mysql_motor')->update($sSQL);
		    }

		    // Something is processed
		    elseif($cProcPost > 0) {
		       $sSQL =
				'UPDATE '. $sGambino2Table .' g '.
		       'LEFT JOIN Gambino2SubR gs ON gs.Gambino2 = g.counter '.
		       'SET processedLVL = "some" '.
		       'WHERE SIRun = '. $sSIRun;
			    $sql =  DB::connection('mysql_motor')->update($sSQL);
		    }
		 }


		 // dd($sql);
		 // echo $SITableQry[0]->totalCharge;
		// echo $sql[0]->userID;

		$sqlString = 
		'UPDATE Gambino2Lock '.
		'SET userID = NULL '.
		' WHERE typeOfInvoice = "'. $sTypeHold .'"';

		$sql =  DB::connection('mysql_motor')->update($sqlString);

  		echo "process done";

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
