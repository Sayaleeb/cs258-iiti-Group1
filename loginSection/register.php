<?php
require_once 'core/init.php';
require("includes/functions.php"); 
require("includes/header.php");
include("includes/navigation.php");

	if(token::check(input::get('token'))){
		if(input::exists()){
			$validate = new validate();
			$validation = $validate->check($_POST, array(
				'username' => array(
								'required' => true,
								'min' => 2,
								'max' =>30,
								'unique' => 'login_credentials_tb'),
				'password' => array(
								'required' => true,
								'min' => 2),
				'password_again' => array(
								'required' => true,
								'matches' => 'password'),
				'name' => array(
							'required' => true,
							'min' => 2,
							'max' => 50,
							),

				));

			if($validation->get_passed()){
				$user = new User();
				echo $salt = hash::salt(32);

				try{
					$user->create(array(
								'username' => input::get('username'),
								'name' => input::get('name'),
								'password' => hash::make(input::get('password'), $salt),
								'type' => input::get('type'),
								'actorrank' => input::get('actorrank'),
								'salt' => $salt)
							);

					session::flash('home', 'You have successfully been registered');
					redirect::to('login.php');

				}
				catch(exception $e){
					die($e->getMessage());
				}

			}else{
				$errors = $validation->get_errors();
				foreach($errors as $error){
					echo $error . "<br/>"; 
				}
			}
		}
	}
?>
<div class = 'wrapper_registration'>
	<form action = "" method = "POST" class="pure-form pure-form-aligned">
			<div class = "pure-control-group">
				<label for = "name">Name: </label>
				<input type = "text" id = "name" value = "<?php echo escape(input::get('name'));?>" name = "name">
			</div>

			<div class = "pure-control-group">
				<label for = "username">Username: </label>
				<input type="text" name = "username" id="username" value="<?php echo escape(input::get('username'));?>" autocomplete="off">
			</div>

			<div class = "pure-control-group">
				<label  for = "password">Password: </label>
				<input type = "password" id="password" name="password">
			</div>

			<div class = "pure-control-group">
				<label for = "type">Type: </label>
				<select name="type" id= "type"> 
					<option value = 'permanent_staff_faculty'>Permanent Staff(Faculty)</option>
					<option value = 'permanent_staff_other'>Permanent Staff(Other)</option>
					<option value = 'contractual_staff'>Non-Permanent</option>
				</select>
			</div>

			<div class = "pure-control-group">
				<label for = "actorrank">Permissions: </label>
				<select name="actorrank" id = "actorrank"> 
					<option value = "0" selected = "selected">User</option>
					<option value = "1">Admin</option>
				</select>
			</div>

			<div class = "pure-control-group">
				<label for = "password_again">Confirm Password: </label>
				<input type = "password" id="password_again" name="password_again">
			</div>

			<input type = "hidden"	name = "token" value = "<?php echo token::generate();?>">			
			<div class = 'pure-control'>
				<button type = "submit" class='pure-button pure-button-primary'>Next</button>
			</div>
	</form>
</div>

<?php include 'includes/footer.php';?>


