<?php

	require_once 'connect.inc.php';

//if(!isset($_SESSION['userId'])){

	if( isset($_POST['fromDate']) && isset($_POST['toDate']) && isset($_POST['leaveReason']) && isset($_POST['availConcession'])
		&& isset($_POST['recommendingAuthority']) && isset($_POST['approvingAuthority'])  && isset($_POST['leaveAddress'])){
			
			$fromDate = $_POST['fromDate'];
			$toDate = $_POST['toDate'];
			$leaveReason = $_POST['leaveReason'];
			$recommendingAuthority = $_POST['recommendingAuthority'];
			$approvingAuthority = $_POST['approvingAuthority'];
			$leaveType = $_POST['leaveType'];
			$availConcession = $_POST['availConcession'];
			$leaveAddress = $_POST['leaveAddress'];

			if( isset($_POST['agreeToTerms']) ){

				if( !empty($fromDate) && !empty($toDate) && !empty($leaveReason) && !empty($availConcession) &&
					!empty($recommendingAuthority) && !empty($approvingAuthority) && !empty($leaveAddress)){
					
					if( strlen($leaveReason) < 500 && strlen($leaveAddress) < 100){
				
							$fromDate = strtotime($fromDate); //FROM_UNIXTIME($fromDate)
							$toDate = strtotime($toDate);

							if($fromDate < $toDate){

								$leaveReason = mysql_real_escape_string($leaveReason);
								$recommendingAuthority = 1;//getId();
								$approvingAuthority = 2;//getId();
								$leaveDuration = ceil(($toDate-$fromDate)/(24*60*60)) + 1;

								connect_leave_account_db();

								$query_find_leaves = "SELECT $leaveType FROM leave_balance_tb WHERE userId='1'";

								if($query_run = mysql_query($query_find_leaves)){

									if(mysql_num_rows($query_run)==1){

										$query_row = mysql_result($query_run, 0, $leaveType);

										if($query_row >= $leaveDuration){

											$query = "INSERT INTO leave_details_tb VALUES (NULL, '0', '1', NOW(), FROM_UNIXTIME($fromDate), '$leaveDuration', '$leaveReason', '$recommendingAuthority', '$approvingAuthority', '$leaveType', '$availConcession', '$leaveAddress')";

											if($query_run = mysql_query($query)){

												$updated_leave = $query_row - $leaveDuration;
												$query_update_leave_balance_tb = "UPDATE leave_balance_tb SET $leaveType='$updated_leave' WHERE userId='1'";
												
												if($query_run = mysql_query($query_update_leave_balance_tb)){
													echo "Your application is sent for furthur processing";
												}else{
													echo "Sorry, an error occured. Please try sometime later.";
												}
																								
											}else{
												echo "Sorry, an error occured. Please try sometime later.";
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
						echo "Please adher to maxlength of the fields";
					}
					
				}else{
					echo "All fields are required";
				}
			}else{
				echo "Please agree to terms";
			}					
	}

?>

<html>

	<h1 align='center'>Application form for Leave other than CL</h1>

	<form action="nonClLeaveApplication.php" method="POST">

		Nature of leave
		<select name="leaveType">
			<option value="sepcialClBalance" selected>Sepcial Casual Leave</option>
			<option value="specialLeaveBalance">Special Leave</option>
			<option value="halfPayLeaveBalance">Half-Pay Leave</option>
			<option value="commutedLeaveBalance">Commuted Leave</option>
			<option value="earnedLeaveBalance">Earned Leave</option>
			<option value="extraOrdinaryLeaveBalance">Extra Ordinary Leave</option>
			<option value="maternityLeaveBalance">Maternity Leave</option>
			<option value="hospitalLeaveBalance">Hospital Leave</option>
			<option value="quarantineLeaveBalance">Quarantine Leave</option>
			<option value="leaveNotLeaveBalance">Leave not Leave</option>
			<option value="sabbaticalLeaveBalance">Sabbatical Leave</option>
			<option value="vacationBalance">Vacation</option>
		</select>
		<br>

		Duration of leave required
		<input type="date" name="fromDate" maxlength="40" value="<?php if(isset($_POST['fromDate'])){ echo $_POST['fromDate']; } ?>"/> 
		to 
		<input type="date" name="toDate" maxlength="40" value="<?php if(isset($_POST['toDate'])){ echo $_POST['toDate']; } ?>"/>
		<br>

		<!--Holidays, if any proposed to be-->

		Grounds for leave<br>
		<textarea rows="10" cols="40" name="leaveReason" maxlength="500" placeholder="Do not use more than 100 words"><?php if(isset($_POST['leaveReason'])){ echo htmlentities($_POST['leaveReason']); } ?></textarea>
		<br>	

		Whether the applicant proposes to avail of leave travel concession during the ensuring leave<br>
		<input type="radio" name="availConcession" value="1" checked>Yes </input>
		<input type="radio" name="availConcession" value="0">No<br>

		Address while on leave<br>
		<textarea name="leaveAddress" maxlength="100" rows="4" cols="40"><?php if(isset($_POST['leaveAddress'])){ echo htmlentities($_POST['leaveAddress']); } ?></textarea><br><br>

		Recommending Authority
		<input name="recommendingAuthority" value="<?php if(isset($_POST['recommendingAuthority'])){ echo $_POST['recommendingAuthority']; } ?>">
		<br>

		Sanctioning Authority
		<input name="approvingAuthority" value="<?php if(isset($_POST['approvingAuthority'])){ echo $_POST['approvingAuthority']; } ?>">
		<br>

		A. In the event of my resignation or voluntary retirement from the service. I undertake to refund:<br>
		&nbsp;&nbsp;&nbsp;&nbsp;1. The difference between the leave salary drawn during commuted leave and that admissible during half pay leave.<br>
		B. Undertake to refund the leave salary drawn for the period of earned leave which would not have been admissible, 
		had leave not been credited in advance in the event of my resignation. Voluntary retirement, dismissal or removal 
		from service or removal from service or in the event of termination of my services.<br>

		<input type="checkbox" name="agreeToTerms">I agree<br><br>

		<button name="apply">Apply</button>

	</form>

</html>
