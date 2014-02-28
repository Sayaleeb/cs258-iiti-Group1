<?php
	session_start();
	$GLOBALS['config'] = array(
			'mysql' => array(
					'host' => '127.0.0.1',
					'username' => 'root',
					'password' => 'pass',
					'db' => array(
						'login' => 'logincredentialsdb',
						'profile' => 'servicebookdb')
				),
			'remember' => array(
					'cookieName' => 'hash',
					'cookieExpiry' => 604800 
				),
			'session' => array(
					'sessionName' => 'user',
					'tokenName' => 'token'
				)
		);

	/*
	** spl_autoload_register adds the anonymous function to a list of
	** SPL functions. Then upon encountering a unknown class it iterates
	** through the list and calls functions with parameter 'UnloadedClass'.
	** It then checks if class is now loaded. If by the end, it is still 
	** unloaded, it gives a fatal error	
	*/	
	spl_autoload_register(function($class){
		require_once ('classes/' . $class . '.php');	
	});

	require_once ('functions/sanitize.php');

?>