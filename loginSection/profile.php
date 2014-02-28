<?php
require_once 'core/init.php';
require("includes/functions.php"); 
require("includes/header.php");
include("includes/navigation.php");

	$user = new user();
?>
<div id = 'content'>
	<div id = 'profile'>
		<table id = 'data' class = 'pure-table' 'pure-table-horizontal'>
			<tr class = 'pure-table-odd'>
				<td>1</td>
				<td> Name: </td>
				<td> <?php echo $user->data()->name?></td>
			</tr>
			<tr >
				<td>2</td>
				<td> Age: </td>
				<td> <?php echo $user->data()->name?></td>
			</tr>
			<tr class = 'pure-table-odd'>
				<td>3</td>
				<td> Sex: </td>
				<td> <?php echo $user->data()->name?></td>
			</tr>
			<tr>
				<td>4</td>
				<td> DOB: </td>
				<td> <?php echo $user->data()->name?></td>
			</tr>
			<tr class = 'pure-table-odd'>
				<td>5</td>
				<td> Employee ID: </td>
				<td> <?php echo $user->data()->name?></td>
			</tr>
		</table>
	</div>
</div>
<?php include('includes/footer.php');?>