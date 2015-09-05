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

        'pgsql' => array(
            'driver'   => 'pgsql',
            'host'     => 'ec2-50-19-233-111.compute-1.amazonaws.com',
            'database' => 'dbn4ihboauksu1',
            'username' => 'szezatcksgjhkr',
            'password' => 'PP3dTrrfobvJChC4wKLXdQ-lUx',
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
        ),

        'mysql' => array(
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'signlayo_clipart',
            'username'  => 'signlayo_clipart',
            'password'  => '9ud@fSD5odyP',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ),

    ),

);
