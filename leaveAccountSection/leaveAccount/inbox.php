<?php

	if( !isset($_SESSION['userId']) ){

		require_once 'connect.inc.php';

		connect_db('leave_account_db');

		$userId = 1;//$_SESSION['userId'];

		$query = "SELECT * FROM leave_details_tb WHERE recommendingAuthority='$userId' OR approvingAuthority='$userId'";

		if($query_run = mysql_query($query)){

			echo "<link rel='stylesheet' href='http://yui.yahooapis.com/pure/0.4.2/pure-min.css'>";

			echo "<div id='applicationListPanel' class='pure-menu pure-menu-open'><ul>";

			while($query_row = mysql_fetch_assoc($query_run)){

				$applicantId = $query_row['userId'];

				connect_db('user_details_db');

				$query_find_user_details = "SELECT * FROM user_login_tb WHERE userId='$applicantId'";

				if($query_find_user_details = mysql_query($query_find_user_details)){
					
					if(mysql_num_rows($query_find_user_details)==1){

						$query_find_user_details_assoc = mysql_fetch_assoc($query_find_user_details);

						echo "<li><a href='#' value='".$query_row['leaveDetailId']."'>".$query_row['applyingDate']."&nbsp;&nbsp;&nbsp;&nbsp;".$query_find_user_details_assoc['userName']." : ".$query_row['leaveType']." for ".$query_row['leaveDuration']." days ";

						if($query_row['recommendingAuthority']==$userId){
							echo "(Recommend)";
						}else{
							echo "(Approve)";
						}

						echo "</a></li>";

					}else{

						echo "Invalid user";

					}

				}

			}
			echo "</ul></div>";

		}else{

			echo mysql_error();

		}


	}

?>

<script type='text/javascript'>

		var selection = document.getElementById(applicationListPanel);
		var select = selection.find('li');

	    select.click(function(event) {
		    select.removeClass('active');
		    $(this).addClass('active');


			if(window.XMLHttpRequest){

				xmlhttp = new XMLHttpRequest();

			}else{

				xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');

			}
			
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState==4 && xmlhttp.status==200){
					document.getElementById(applicationPreviewPanel).innerHTML = xmlhttp.responseText;
				}
			}

			xmlhttp.open('GET', 'showApplication.inc.php?leaveDetailId='+select.value, true);
			xmlhttp.send();
		});

</script>


</head>

