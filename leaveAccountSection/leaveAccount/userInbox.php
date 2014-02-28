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
