<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class ZohoController extends Controller
{
    public function deal() {

	//ZOHO API Test	

	$client_id = "1000.Z0QBQZZ5S4RQYBPOKJIAIIZD7FAYKS";
	$client_secret = "e2a49b9c2dcdc03ff860a692adb8583ab567503ed4";

	$code = "1000.cb3f5fc16ada0e0a0a0bb29c8dd0a368.3ea7a6d59414c0ae68457c5817bde93f";
	$access_token = "1000.6cfeb093a0f9cf99248d13d24bb97f0d.6e147ca305d5fe17d08239ceb5df1092";
	$refresh_token = "1000.7e021feac91bb13704afc9c8af4b2219.9d842c3120d366f2fa8f15d54a49a0a5";

	$token =  $access_token;

	$client = new Client();
	
	/* 
	//run to get refresh_token
	$response = $client->request('POST', 'https://accounts.zoho.com/oauth/v2/token', [
		//'headers'        => ['Accept-Encoding' => 'gzip'],
            'form_params' => [
		'grant_type' => "authorization_code",
		'client_id' => $client_id,
		'client_secret' => $client_secret,
		'code' => $code,

            ]
        ]);	
	*/ 

	//run to get access_token
	$response = $client->request('POST', "https://accounts.zoho.com/oauth/v2/token?refresh_token=$refresh_token&grant_type=refresh_token&client_id=$client_id&client_secret=$client_secret&code=$code", [
        ]);	

	$body = json_decode((string)$response->getBody());
	$token = isset($body->access_token)?$body->access_token:'';	
	
	if ($token) {

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
		//run to add leads
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
       		    //"Owner" => ["id" => "4812428000000303001"],
        	    "Closing_Date" => "2021-05-16",
	            "Deal_Name" => "Oval Soft Test Deal",
	            //"Expected_Revenue" => 50000,
	            "Stage" => "Negotiation/Review",
        	    //"Account_Name" => ["id" => "4812428000000319005"],
	            "Amount" => 50000,
        	    //"Probability" => 75
	        ]),
		'trigger'=>['workflow','approval','blueprint'],
            	);
		$fields = json_encode($data);

		//run to add deals		
		$response = $client->request('POST', 'https://www.zohoapis.com/crm/v2/Deals',['headers'=>[
			'Content-Type' => 'application/json',
			'Content-Length' => strlen($fields),
			'Authorization'=> 'Zoho-oauthtoken '.$token
		],
		'body' => $fields,
	        //'form_params' => $data,
		]);

		$data =   array(
	        "data" => array(
   		[
       		    "Owner" => ["id" => "4812428000000321003"],
	            "Subject" => "TO DO ASAP!",
	        ]),
		'trigger'=>['workflow','approval','blueprint'],
            	);
		$fields = json_encode($data);

		/*
		//run to add task
		$response = $client->request('POST', 'https://www.zohoapis.com/crm/v2/Tasks',['headers'=>[
			'Content-Type' => 'application/json',
			'Content-Length' => strlen($fields),
			'Authorization'=> 'Zoho-oauthtoken '.$token
		],
		'body' => $fields,
	        //'form_params' => $data,
		]);
		*/


	}
	

	return view('zoho',['response'=>$response,'token'=>$token]);
    }		
}
