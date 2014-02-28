<?php
	
	require_once 'connect.inc.php';

//if(!isset($_SESSION['userId'])){

	if( isset($_POST['fromDate']) && isset($_POST['toDate']) && isset($_POST['leaveReason']) && 
		isset($_POST['recommendingAuthority']) && isset($_POST['approvingAuthority']) ){
			
			$fromDate = $_POST['fromDate'];
			$toDate = $_POST['toDate'];
			$leaveReason = $_POST['leaveReason'];
			$recommendingAuthority = $_POST['recommendingAuthority'];
			$approvingAuthority = $_POST['approvingAuthority'];

			if( !empty($fromDate) && !empty($toDate) && !empty($leaveReason) &&
				!empty($recommendingAuthority) && !empty($approvingAuthority) ){
				
				if( strlen($leaveReason) < 500 ){

					//	check number of available leaves
					
					if( true ){

						$fromDate = strtotime($fromDate); //FROM_UNIXTIME($fromDate)
						$toDate = strtotime($toDate);

						if($fromDate < $toDate){

							$leaveReason = mysql_real_escape_string($leaveReason);
							$recommendingAuthority = 1;//getId();
							$approvingAuthority = 2;//getId();
							$leaveDuration = ceil(($toDate-$fromDate)/(24*60*60)) + 1;
							$leaveType = 'casualLeave';

							connect_db('leave_account_db');

							$query_find_leaves = "SELECT $leaveType FROM leave_balance_tb WHERE userId='1'";

							if($query_run = mysql_query($query_find_leaves)){

								if(mysql_num_rows($query_run)==1){

									$query_row = mysql_result($query_run, 0, $leaveType);

									if($query_row >= $leaveDuration){

										$query = "INSERT INTO leave_details_tb VALUES (NULL, '0', '1', NOW(), FROM_UNIXTIME($fromDate), '$leaveDuration', '$leaveReason', '$recommendingAuthority', '$approvingAuthority', '$leaveType', NULL, NULL)";

										if($query_run = mysql_query($query)){

											$updated_leave = $query_row - $leaveDuration;
											$query_update_leave_balance_tb = "UPDATE leave_balance_tb SET $leaveType='$updated_leave' WHERE userId='1'";
												
											if($query_run = mysql_query($query_update_leave_balance_tb)){
												echo "Your application is sent for furthur processing";
											}else{
												echo "Sorry, an error occured. Please try sometime later.";
											}
																							
										}else{
											echo "Sorry, an error1 occured. Please try sometime later.";
										}

									}else{
										echo "You don't have enough leave balance";	
									}

								}else{
									echo "Error in getting user info";
								}

							}else{
								echo "Error";
							}

						}else{
							echo "Enter dates again";
						}
						
					}else{
						echo "You don't have enough leave balance";					
					}
					
				}else{
					echo "Please adher to maxlength of the field \'Reason for leave\'";
				}
				
			}else{
				echo "All fields are required";
			}			
			
		}

?>

<html>

	<h1 align="center">Application form for Casual Leave</h1>

	<form action="casualLeaveApplication.php" method="POST">

		Duration of leave required
		<input type="date" name="fromDate" maxlength="40" value="<?php if(isset($_POST['fromDate'])){ echo $_POST['fromDate']; } ?>"/> 
		to 
		<input type="date" name="toDate" maxlength="40" value="<?php if(isset($_POST['toDate'])){ echo $_POST['toDate']; } ?>"/>
		<br>

		Reason for Casual Leaves and Grounds<br>
		<textarea rows="10" cols="40" name="leaveReason" maxlength="500" placeholder="Do not use more than 100 words"><?php if(isset($_POST['leaveReason'])){ echo htmlentities($_POST['leaveReason']); } ?></textarea>
		<br>

		Recommending Authority
		<input name="recommendingAuthority" value="<?php if(isset($_POST['recommendingAuthority'])){ echo $_POST['recommendingAuthority']; } ?>">
		<br>

		Sanctioning Authority
		<input name="approvingAuthority" value="<?php if(isset($_POST['approvingAuthority'])){ echo $_POST['approvingAuthority']; } ?>">
		<br>

		<button name="send">Send</button>

	</form>

</html>
