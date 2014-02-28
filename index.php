<?php
	
	require "header.php";
	require "footer.php";

	if(isset($_POST["username"]) && isset($_POST["password"])){
		$username = $_POST["username"];
		$password = $_POST["password"];
		if(!empty($username) && !empty($password)){
			require 'connect.inc.php';
			$query_run = mysql_query("SELECT * FROM user_details WHERE username='$username'");
			if($query_run){
				if($query_row = mysql_fetch_assoc($query_run)){
					$name = $query_row['username'];
					$pass = $query_row['password'];
					$id = $query_row['id'];
					if($name && $pass && $name==$username && $pass==$password){
						session_start();
						$_SESSION['userid'] = $id;
					}
				}
			}else{
				echo "error";
			}
		}
	}
	
	

?>

<form action="index.php" method="POST">
	
	<p>Username
		<input type="text" name="username" size="15" maxlength="30" />
	</p>
	<p>Password:
		<input type="password" name="password" size="15" maxlength="30" />
	</p>
	<button name="Submit">Submit</button>
	
</form>
