<?php

	function connect_db($database_name){
		$mysql_host = 'localhost';
		$mysql_user = 'root';
		$mysql_password = '';
		if(!@mysql_connect($mysql_host, $mysql_user, $mysql_password) || !@mysql_select_db($database_name)){
			echo "Could not connect\n";
			die();
		}
	}

?>