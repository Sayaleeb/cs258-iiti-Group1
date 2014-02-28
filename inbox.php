<?php

	if( !isset($_SESSION['userId']) ){

		require_once 'connect.inc.php';

		connect_db('leave_account_db');

		$userId = 1;//$_SESSION['userId'];

		$query = "SELECT * FROM leave_details_tb WHERE recommendingAuthority='$userId' OR approvingAuthority='$userId'";

		if($query_run = mysql_query($query)){

			echo "<link rel='stylesheet' href='http://yui.yahooapis.com/pure/0.4.2/pure-min.css'>";

			while($query_row = mysql_fetch_assoc($query_run)){

				$applicantId = $query_row['userId'];

				connect_db('user_details_db');

				$query_find_user_details = "SELECT * FROM user_login_tb WHERE userId='$applicantId'";

				if($query_find_user_details = mysql_query($query_find_user_details)){
					
					if(mysql_num_rows($query_find_user_details)==1){

						echo "<div class='email-item email-item-unread pure-g' id='".$query_row['leaveDetailId']."'>";

						$query_find_user_details_assoc = mysql_fetch_assoc($query_find_user_details);

						echo "<div class='pure-u-3-4'>
							<a href='showApplication.inc.php?leaveDetailId=".$query_row['leaveDetailId']."'>
							<div class='pure-u'>
				               <img class='email-avatar' alt='YUI&#x27;s avatar' height='64' width='64' src='../img/user.png'>
				            </div>

			                <h5 class='user-name'>".$query_find_user_details_assoc['userName']."</h5>
			                <h4 class='applying-date'>".$query_row['applyingDate']."</h4>
			                <p class='reason'>";
			                if($query_row['recommendingAuthority']==$userId){
								echo 'Recommend';
							}else{
								echo 'Approve';
							}
							echo " ".$query_row['leaveType']." for ".$query_row['leaveDuration']." days";
		                echo "</p>
		                	  </a>
		                	  </div>";

						echo "</div>";

					}else{

						echo "Invalid user";

					}

				}

			}

		}else{

			echo mysql_error();

		}


	}

?>


    <div id="main" class="pure-u-1">
        <div class="email-content" id="applicationContent">



        </div>
    </div>