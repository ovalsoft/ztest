<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class ZohoController extends Controller
{
    public function deal() {
	//dealtask Seb9y2kze0JK
	//$response = Http::get('https://crm.zoho.com/crm/private/xml/Deals/insertRecords?newFormat=1 &authtoken=[INSERT YOUR TOKEN HERE]&scope=crmapi&xmlData=<Potentials><row no="1"><FL val="Deal Name">AAAA Test Deal</FL><FL val="Stage">Sent Final Contract</FL></row></Potentials>');
	$client = new Client();


	$code = "1000.bb2f7efccc5ef82e1829f2480ed42ad6.4792a46681d101126b0862ee00b796ba";
	$access_token = "1000.d91a89ba1a073fe89555798a5ec954b0.506994e4f330242efd220009f40fa20c";
	$refresh_token = "1000.b81de3ee6a61a78fd1422a8ec087973f.8c5b1b27a4c234f712d5e75628223a4f";

	$token =  $access_token;
	

	$response = $client->request('POST', 'https://accounts.zoho.com/oauth/v2/token', [
		//'headers'        => ['Accept-Encoding' => 'gzip'],
            'form_params' => [
		'grant_type' => "authorization_code",
		'client_id' => "1000.Z0QBQZZ5S4RQYBPOKJIAIIZD7FAYKS",
		'client_secret' => "e2a49b9c2dcdc03ff860a692adb8583ab567503ed4",
		'code' => $code,

            ]
        ]);	

	$body = json_decode((string)$response->getBody());
	$token = isset($body->access_token)?$body->access_token:'';	


	//$token = '1000.c2d901c3fb5c7e3de7508f49a0c1d261.9682c832c7a15823729a05f06fe18d5d';
	//$token = $code;

	//return view('zoho',['response'=>$response,'token'=>$token]);
	
	if ($token) {
		//$response = $client->request('GET', 'https://crm.zoho.com/crm/private/xml/Deals/insertRecords?newFormat=1&authtoken='.$token.'&scope=crmapi&xmlData=<Potentials><row no="1"><FL val="Deal Name">AAAA Test Deal</FL><FL val="Stage">Sent Final Contract</FL></row></Potentials>', []);


		$data =   array(
		        "data" => array(
			[
			        "Company"   => "abc",
			        "Last_Name" => "Tom",
			        "City"      => "Egham" 
		        ],
		        [   
		            "Company"   => "abc",
        		    "Last_Name" => "Jerry",
		            "City"      => "Egham"
		        ],

			       [
			            "Company" => "West Coast Riders Inc.",
		        	    "Email" => "fred.nainavaii@westcoastriders.com",
			            "Website" => "www.westcoastriders.com",
			            "Full_Name" => "Sean Collins",
			            "Last_Name" => "Collins",
			            "Lead_Status" => "Contact in Future",
			            "Phone" => "888-555-5674"
			       ]

			)
		    
		);


		$fields = json_encode($data);

		/*		
		$response = $client->request('POST', 'https://www.zohoapis.com/crm/v2/Leads',['headers'=>[
			'Content-Type' => 'application/json',
			'Content-Length' => strlen($fields),
			'Authorization'=> 'Zoho-oauthtoken '.$token
		],
		'body' => $fields,
	        //'form_params' => $data,
		]);
		*/


		$data =   array(
	        "data" => array(
   		[
       		     "Owner" => [
                	"id" => "4812428000000303001"
	            ],
        	    "Closing_Date" => "2021-05-16",
	            "Deal_Name" => "Grumman Corp Fan Deal",
	            "Expected_Revenue" => 50000,
	            "Stage" => "Negotiation/Review",
        	    "Account_Name" => [
                	"id" => "4812428000000319005"
	            ],
	            "Amount" => 50000,
        	    "Probability" => 75
	        ]),
		'trigger'=>['workflow','approval','blueprint'],
            	);
		$fields = json_encode($data);

		$response = $client->request('POST', 'https://www.zohoapis.com/crm/v2/Deals',['headers'=>[
			'Content-Type' => 'application/json',
			'Content-Length' => strlen($fields),
			'Authorization'=> 'Zoho-oauthtoken '.$token
		],
		'body' => $fields,
	        //'form_params' => $data,
		]);

	}
	

	return view('zoho',['response'=>$response,'token'=>$token]);
    }		
}
