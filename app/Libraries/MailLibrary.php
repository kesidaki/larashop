<?php

namespace App\Libraries;

use Mail;

Class MailLibrary 
{

	/*
	* This library acts as a proxy between my controllers sending data for email and the service
	* i will then the email from.
	* 
	* It was created because there is always the possibility of switching email service at some point
	* and it would be a HUGE pain in the ass to change every single sending function of every single
	* controller
	* 
	* The $data expected from the send function expects an array of the same type of data as mailJet expected,
	* since i worked with it first
	* 
	* Array Set-Up is as follows:
	* from => my-company-email
	* name => my-company-name 
	* To
	* 	[
	* 		[
	* 			Name
	* 			Email
	* 		],
	* 		[
	* 			Name
	* 			Email
	* 		]
	* 	],
	* Attachments
	* 	[
	* 		[
	* 			Filename,
	* 			ContentType
	* 		]
	* 	]
	* Subject
	* HTMLPart
	* 
	* where:
	* from is company's email
	* name is company's name
	* to is an array containing array's with sender's Name and Email information
	* subject is the email's subject
	* html part is the content on html format
	*/
	
	/**
	* @param data
	*/
	public function send($data) 
	{
		// loop to send
		foreach ($data['to'] as $to) {
			Mail::send([], [], function ($message) use ($data, $to) {
				$message->from($data['from']);
				$message->to(trim($to['Email']));
				$message->subject($data['subject']);
				$message->setBody($data['html'], 'text/html');

				if (isset($data['attachments'])) {
					foreach ($data['attachments'] as $attach) {
						$message->attach($attach['Filename']);
					}
				}
			});
		}
	}

}
?>