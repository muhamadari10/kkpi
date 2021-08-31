<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Public_Controller extends MY_Controller
	{
	    function __construct()
	    {
	        parent::__construct();
			header('Content-type: text/html');
			header( "Access-Control-Allow-Origin: *" );
			header( "Access-Control-Allow-Credentials: true" );
			header( "Access-Control-Allow-Methods: POST, GET, PUT" );
			header( "Access-Control-Max-Age: 604800" );
			header( "Access-Control-All-Headers: Origin, X-Requested-With, Content-Type, Accept, Key, Authorization" );
			header( "Access-Control-Request-Headers: X-Requested-With" );
			header( "Access-Control-Allow-Headers: Origin, X-Requested-With, X-Requested-By, Content-Type, Accept, Key, Authorization, postman-token, cache-control" );
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	    }
	}
?>