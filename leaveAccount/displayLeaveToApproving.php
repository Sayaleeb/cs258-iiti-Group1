<?php

	if(!isset($_SESSION['userId'])){

		require_once 'connect.inc.php';

		connect_db('leave_account_db');

		$userId = 1;//$_SESSION['userId'];
		$leaveStatus = 1;//, leaveStatus='$leaveStatus'
		
		$query = "SELECT * FROM leave_details_tb WHERE recommendingAuthority='$userId' AND leaveStatus='$leaveStatus' ORDER BY applyingDate DESC";


		if($query_run = mysql_query($query) ){

			if( mysql_num_rows($query_run) != 0){

				while($query_row = mysql_fetch_assoc($query_run)){

					$applicantId = $query_row['userId'];

					connect_db('user_details_db');

					$query_find_user_details = "SELECT * FROM user_login_tb WHERE userId='$applicantId'";

					if($query_find_user_details_run = mysql_query($query_find_user_details)){

						//while(mysql_num_rows($query_find_user_details_run)==1){

						while($query_find_user_details_run_assoc = mysql_fetch_assoc($query_find_user_details_run)){

							echo "<br><br>Applicant Name: ".$query_find_user_details_run_assoc['userName']."<br>";

							echo "Applicant Designation: ".$query_find_user_details_run_assoc['designation']."<br>";

							echo "Applicant Department: ".$query_find_user_details_run_assoc['department']."<br>";

							$leaveType = $query_row['leaveType'];

							$leaveDuration = $query_row['leaveDuration'];

							$leaveType = $query_row['leaveType'];

							echo "From ".$query_row['fromDate']." ";

							echo "to ".($query_row['fromDate'] + $query_row['leaveDuration'])."<br>";

							echo "Reason: ".$query_row['reason']."<br>";

							if($leaveType!='casualLeave'){

								if($query_row['availConcession']==1){
									echo "Wishes to avail concession<br>";
								}else{
									echo "Doesn't want to avail concession<br>";
								}

								echo "Address while on leave: ".$query_row['leaveAddress']."<br>";									

							}

						}
						//else{
						//	echo "Invalid user<br>";
						//}
						
					}
									
				}

			}else{
				echo "No results found<br>";
			}

		}else{
			echo "Sorry, some error occured. Please try again later.<br>";
			echo mysql_error();
		}


	}

?>







