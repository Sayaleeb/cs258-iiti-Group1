<?php     
    if(isset($_GET['page'])) $highlight = $_GET['page'];
    else $highlight = "";

    $user = new user();
    $loggedIn = false;
    if($user->is_logged_in()) {
        $loggedIn = true;   
    }else{
        redirect::to('login.php');
    }

?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Title</title>
    <link rel = "stylesheet" type = "text/css" href="pure-master/src/forms/css/forms.css">
    <link rel = "stylesheet" type = "text/css" href="pure-master/src/buttons/css/buttons.css">
    <link rel = "stylesheet" type = "text/css" href="pure-master/src/tables/css/tables.css">
    <link rel = "stylesheet" type = "text/css" href="pure-master/src/menus/css/menus.css">
    <link rel = "stylesheet" type = "text/css" href="pure-master/src/base/css/base.css">
	<link rel="stylesheet" type="text/css" href="stylesheets/main.css">
</head>
<body>
	<div id = "header">
    	<a class = 'headerLink' href = "#" style="float:left;" title = 'Go to IITI Home Page'>Online Administration Portal</a>
        <div id = "links">
            <a href = "#" class='headerLink' id = 'settings'>Config</a>
            <?php
                if($loggedIn)echo "<a href = 'logout.php' class='headerLink' id = 'logout'>Logout</a>";
                
            ?>
            <a href = "www.webmail.iiti.ac.in" class='headerLink' id = 'webmail'>Webmail</a>
            <a href = "http://goo.gl/lu8ybs" class='headerLink' id = 'googlemail'>GoogleMail</a>
        </div>
    </div>
    <div class='.clearFloat'></div>