<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| STAGING / PRODUCTION
	|--------------------------------------------------------------------------
	*/
	'fetch'       => PDO::FETCH_CLASS,

	'default' => 'mysql',

    'connections' => array(

        'mysql' => array(
            'driver'    => 'mysql',
            'host'      => $_ENV['DB_HOST'],
            'database'  => $_ENV['DB_NAME'],
            'username'  => $_ENV['DB_USER'],
            'password'  => $_ENV['DB_PASS'],
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ),

    ),

);
