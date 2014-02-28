<?php
require 'core/init.php';



echo session::flash('home');
    
$debarr = false;
if(input::exists()){
    if(token::check(input::get('token'))){
        $validate = new validate();
        $validation = $validate->check($_POST, array(
                             'username' => array('required'=> true),
                             'password' => array('required' => true)
                        ));
        if($validation->get_passed()){
            $user = new user();
            $login = $user->login(input::get('username'), input::get('password'));

            if($login){
                redirect::to('index.php');
            }else{
                $debarr = true;
            }
        }
        else{
            foreach ($validation->get_errors() as $error) {
                echo $error . "<br/>";
            }
        }
    }
}

?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Title</title>
	<link rel="stylesheet" type="text/css" href="stylesheets/main.css">
    <link rel="stylesheet" type="text/css" href="stylesheets/login.css">
</head>
<body style = "background-color:#16A085;">
	<div id = "header">
    	<a class = 'headerLink' href = "#" style="float:left;">Online Administration Portal</a>
        <div id = "links">
            <a href = "#" class='headerLink' id = 'webmail'>Webmail</a>
            <a href = "http://goo.gl/lu8ybs" class='headerLink' id = 'googlemail'>GoogleMail</a>
        </div>
    </div>
    <div class='.clearFloat'></div>

    <div id = "boxForLogin" style = "padding-top:150px; float:right; margin-right:100px">
        <section class="main">
                <form class="form-2" action="" method="POST">
                    <h1><span class="log-in">Log in</span></h1>
                    <p class="float">
                        <label for="username">Username</label>
                        <input type="text" name="username"  placeholder = 'Username'>
                    </p>
                    <p class="float">
                        <label for="password">Password</label>
                        <input type="password" name="password" placeholder="Password">
                    </p>                   
                    <p><label id = 'loginFault'><?php
                        if($debarr) echo "*Login failed. Please try again.";
                    ?></label>
                    </p> 
                    <p class="clearfix">
                        <input type = "hidden" name="token" value = '<?php echo token::generate();?>'>
                        <input type="submit" name="submit" value="Log in">
                    </p></form>​​
            </section>
    </div>

</body>
</html>