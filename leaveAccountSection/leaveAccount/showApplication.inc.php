
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Online Administration Portal of IIT Indore">

    <title>Online Administration Portal</title>

    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.4.2/pure-min.css">
      
        <!--[if lte IE 8]>
            <link rel="stylesheet" href="/combo/1.11.2?/css/layouts/email-old-ie.css">
        <![endif]-->
        <!--[if gt IE 8]><!-->
            <link rel="stylesheet" href="../css/layouts/email.css">
        <!--<![endif]-->
      
    <!--[if lt IE 9]>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv.js"></script>
    <![endif]-->
        
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-41480445-1', 'purecss.io');
            ga('send', 'pageview');
    </script>

</head>
<body>


<div id="layout" class="content pure-g">
    <div id="nav" class="pure-u">
        <a href="#" class="nav-menu-button">Menu</a>

        <div class="nav-inner">
            <button class="primary-button pure-button">Apply for Leave</button>

            <div class="pure-menu pure-menu-open">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Inbox <span class="email-count">(2)</span></a></li>
                    <li><a href="#">e-Service Book</a></li>
                    <li><a href="#">Leave Balance</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div id="list" class="pure-u-1">
        <a href="#" class="nav-menu-applications"></a>

        <?php require_once(dirname(__FILE__).'/../inbox.php');?>

    </div>

	<?php

	echo "<div id=\"main\" class=\"pure-u-1\">
	            <div class=\"email-content\" id=\"applicationContent\">";


	 if(!isset($_SESSION['$userId'])){
	 	$userId='1';
		connect_db('leave_account_db');
		 
		$query="SELECT * FROM leave_details_tb WHERE leaveDetailId=".$_GET['leaveDetailId'];
		if( $mysql_run=mysql_query($query)){
			if( mysql_num_rows($mysql_run)==1){
				$query_row= mysql_fetch_assoc($mysql_run);
				$applicantsId=$query_row['userId'];
				$fromDate=date('m/d/Y',strtotime($query_row['fromDate']));
				$approvingAuthority=$query_row['approvingAuthority'];
				$leaveType=$query_row['leaveType'];
				$availConcession=$query_row['availConcession'];
				$leaveAddress=$query_row['leaveAddress'];
				$applyingDate=$query_row['applyingDate'];
				$leaveDuration=$query_row['leaveDuration'];
				$reason= $query_row['reason'];
				connect_db('user_details_db');
				$query_find_user_details="SELECT * FROM user_login_tb WHERE userId='$applicantsId'";
				if( $mysql_run_login=mysql_query($query_find_user_details)){
					if( mysql_num_rows($mysql_run_login)==1){
						if($query_row_login= mysql_fetch_assoc($mysql_run_login)){
							$applicantName=$query_row_login['userName'];
							$designation=$query_row_login['designation'];
							echo "<div class='email-content' >";
					            echo "<div class='email-content-header pure-g'>
					                <div class='pure-u-1-2'>
					                    <h2 class='email-content-title'>Leave Application</h2>
					                    <p class='email-content-subtitle'>
					                        From <a>".$applicantName."</a> at <span>". date('M j Y g:i a', strtotime($applyingDate))."</span>
					                    </p>
					                </div>

					                <div class='email-content-controls pure-u-1-2'>
					                    <button class='secondary-button pure-button'>Approve</button>
					                    <button class='secondary-button pure-button'>Reject</button>
					                </div>
					            </div>
					            <div class='email-content-body'>Applicant: ".$applicantName."</div>
					            <div class='email-content-body'>Designation: ".$designation."</div>
					            <div class='email-content-body'>Leave Type: ";
					            if($leaveType=='clBalance') echo 'Casual Leave';
					            else if($leaveType=='specialClBalanace') echo 'Special Casual Leave';
								else if($leaveType=='specialLeaveBalance') echo 'Special Leave';
								else if($leaveType=='halfPayLeaveBalance') echo 'HalfPay Leave';
								else if($leaveType=='commutedLeaveBalance') echo 'Commuted Leave';
								else if($leaveType=='earnedLeaveBalance') echo 'Earned Leave';
								else if($leaveType=='extraordinaryLeaveBalance') echo 'Extraordinary Leave';
								else if($leaveType=='maternityLeaveBalance') echo 'Maternity Leave';
								else if($leaveType=='hospitalLeaveBalance') echo 'Hospital Leave';
								else if($leaveType=='quarantineLeaveBalance') echo 'Quarantine Leave';
								else if($leaveType=='leaveNotLeaveBalance') echo 'Leave Not Leave';
								else if($leaveType=='sabbaticalLeaveBalance') echo 'Sabbatical Leave';
								else if($leaveType=='vacationBalance') echo 'Vacation';
								echo "</div>
					            <div class='email-content-body'>Wishes to avail ".$leaveDuration." days leave starting from ".$fromDate."</div>
					            <div class='email-content-body'>Leave Reason: ".$reason."</div>";
					            if($leaveType!='clBalance'){
						            echo "<div class='email-content-body'>Address during leave: ".$leaveAddress."</div>
						            <div class='email-content-body'>";
						            if($availConcession==1) echo 'I would like to take leave concession</div>';
						        }
						    "</div>";
						}
					}else{
						echo 'Problem in user database';
					}
				}
			}
			else
				echo 'No pending leaves for recommendaton';
		}else
		echo mysql_error();//'some problem occured';
	}
	echo 	"</div></div>";
?>

    
</div>

<script src="http://yui.yahooapis.com/3.14.1/build/yui/yui-min.js"></script>
<script>
    YUI().use('node-base', 'node-event-delegate', function (Y) {

        var menuButton = Y.one('.nav-menu-button'),
            nav        = Y.one('#nav');

        // Setting the active class name expands the menu vertically on small screens.
        menuButton.on('click', function (e) {
            nav.toggleClass('active');
        });

        // Your application code goes here...

    });
</script>

<script>
    YUI().use('node-base', 'node-event-delegate', function (Y) {
        // This just makes sure that the href="#" attached to the <a> elements
        // don't scroll you back up the page.
        Y.one('body').delegate('click', function (e) {
            e.preventDefault();
        }, 'a[href="#"]');
    });
</script>

</body>
</html>

