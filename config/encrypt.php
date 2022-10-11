<?php

return [

    /*
	|--------------------------------------------------------------------------
	| Encryption Key
	|--------------------------------------------------------------------------
	|
	| This is the key to be used for data encryption
	|
	*/
    'key' => 'milestone',

    /*
	|--------------------------------------------------------------------------
	| Encryption Prefix
	|--------------------------------------------------------------------------
	|
	| This prefix is used to store in database as PREFIX_EncryptedValue
	|
	*/
    'prefix' => env('ENCRYPT_PREFIX', 'ENCRYPTED')
];
