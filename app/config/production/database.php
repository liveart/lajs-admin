<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| STAGING / PRODUCTION
	|--------------------------------------------------------------------------
	*/
	'fetch'       => PDO::FETCH_CLASS,

	'default' => 'pgsql',

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

    ),

);
