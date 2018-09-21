<?php

namespace App\Libraries;

use Mailjet\Resources;
use Mailjet\Client;
use GuzzleHttp\Client as GuzzleClient;

Class MailJetModel 
{
	public $apiPublicKey = 'bd38c2f7c449a12cd01191914877fe93';
	public $apiPrivKey   = '4fda8ca43c9ceeec0ef02ad8b0f182ed';
	public $apiVersion   = 'v3.1';

	/**
	* SEND MAIL VIA MAILJET API
	*
	* PACKAGE INSTALLATION: 
	* composer require mailjet/mailjet-apiv3-php
	* 
	* GITHUB LINK
	* @link https://github.com/mailjet/mailjet-apiv3-php
	* 
	* SENDING AN EMAIL EXPECTS:
	* 	From
	* 		[
	* 			Email
	* 			Name
	* 		]
	* 	To
	* 		[
	* 			[
	* 				Name
	* 				Email
	* 			],
	* 			[
	* 				Name
	* 				Email
	* 			]
	* 		],
	* 	Subject
	* 	HTMLPart
	* 
	* From is for name and email of sernder
	* To is an array or single element of receivers. Needs name and email
	* Subject is email's subject
	* HTMLPart is the HTML we are going to send
	**/

	/**
	* @param data, array of data information
	*/
	public function send($data) 
	{
		$mj = new Client(
			$this->apiPublicKey, 
			$this->apiPrivKey,
			true,
			[
				'version' => $this->apiVersion
			]
		);

		$body = [
		    'Messages' => [
		        [
		            'From' => [
		                'Email' => $data['from'],
		                'Name'  => $data['name']
		            ],
		            'To'        => $data['to'],
		            'Subject'   => $data['subject'],
		            'HTMLPart'  => $data['html']	            
		        ]
		    ]
		];

		if (isset($data['attach']) && ($data['attach'] != '')) {
			$body['Attachments'] = [
				'Content-type' => "text/plain",
            	'Filename'     => $data['attach']
			];
		}

		$response = $mj->post(Resources::$Email, ['body' => $body]);
		//return $response->success() && var_dump($response->getData());
		return var_dump($response->getData());
	}

	/**
	* SEND SMS VIA MAILJET
	* 
	* Sending SMS is a simple POST request
	* It requires authorization header containing 'Bearer ' + Access token
	* The access token is generated from https://app.mailjet.com/sms
	* 
	* The function expects an array containing these fields:
	* [
	* 	From : A name from which we send the SMS, for example CityDoctors
	* 	To:    A phone number we send to
	* 	Text:  The text we want to send 	
	* ]
	* @param data, sms sending data
	*/
	public function sms($data) 
	{
		$client   = new GuzzleClient();
		$response = $client->request(
			'POST', 
			'https://api.mailjet.com/v4/sms-send.', 
			[
				'headers' => [
					'Authorization' => 'Bearer '.$this->accessToken
				],
				'body' => [
					'From' => $data['from'],
					'To'   => $data['to'],
					'Text' => $data['text']
				]
			]
		);
	}

}
?>