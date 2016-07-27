<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class DinersClubController extends Controller
{
    public function importAccounts()
    {
    	DB::statement('
INSERT INTO `dinners_club_accounts` 
	(`franchisecode`, `accountnum`, `recordtype`, `linkacctnum`, `balanceacctnum`, 
	`accountname`, `lastname`, `firstname`, `title`, `acctlevel`, `acctproduct`, `billingcycle`, 
	`businessphone`, `homephone`, `addr1`, `addr2`, `addr3`, `addr4`, `city`, `state`, 
	`postalcode`, `countrycode`, `contactname`, `contacttitle`, `contactphone`, 
	`indicative1`, `indicative2`, `indicative3`, `indicative4`, `indicative5`, `indicative6`, 
	`dateupdated`, `dateacctopened`, `lastbillingdate`, `expirationdate`, `renewaldate`, 
	`feebilleddate`, `dateissued`, `lastaddressnamechangedate`, `distributionflag`, 
	`photocardflag`, `flightinsflag`, `atmflag`, `rewardsflag`, `phoneflag`, `productcode1`, 
	`productcode2`, `productcode3`, `productcode4`, `productcode5`, `airlinecentbillacctnum`, 
	`carcentbillacctnum`, `hotelcentbillacctnum`, `feecentbillacctnum`, `restcentbillacctnum`, 
	`renewalfee`, `DCIcountryflag`, `sourcecode`, `accountstatus`, `modified`)
	#values

SELECT 	`franchisecode`, `accountnum`, `recordtype`, `linkacctnum`, `balanceacctnum`, 
        `accountname`, `lastname`, `firstname`, `title`, `acctlevel`, `acctproduct`, `billingcycle`, 
	`businessphone`, `homephone`, `addr1`, `addr2`, `addr3`, `addr4`, `city`, `state`, 
	`postalcode`, `countrycode`, `contactname`, `contacttitle`, `contactphone`, 
	`indicative1`, `indicative2`, `indicative3`, `indicative4`, `indicative5`, `indicative6`, 
	`dateupdated`, `dateacctopened`, `lastbillingdate`, `expirationdate`, `renewaldate`, 
	`feebilleddate`, `dateissued`, `lastaddressnamechangedate`, `distributionflag`, 
	`photocardflag`, `flightinsflag`, `atmflag`, `rewardsflag`, `phoneflag`, `productcode1`, 
	`productcode2`, `productcode3`, `productcode4`, `productcode5`, `airlinecentbillacctnum`, 
	`carcentbillacctnum`, `hotelcentbillacctnum`, `feecentbillacctnum`, `restcentbillacctnum`, 
	`renewalfee`, `DCIcountryflag`, `sourcecode`, `accountstatus`, `modified` 
	FROM 
	`DinersClubData`.`accounts` 
	WHERE
	accountstatus = ""
    		');
    }
}
