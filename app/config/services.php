<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => array(
		'domain' => 'kerberosits.com',
		'secret' => 'key-08bb11a1ca4869abc50da6101f354090',
	),

	'mandrill' => array(
		'secret' => 'om12dU8HRHjYHPM9bH5YmA',
	),

	'stripe' => array(
		'model'  => 'User',
		'secret' => '',
	),

);
