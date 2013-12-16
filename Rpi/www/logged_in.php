<?php
//logged_in.php
//check logged in or not!
session_start();

//enable error display
ini_set('display_errors', 1);
error_reporting(E_ALL);
if(!isset($_SESSION['loggedIn'])){
	header('Location:index.php');
}

//uses functions from these scripts
require('classes/sql.php');
require('classes/log.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <title>DoorLock Homes</title>

 <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" />

 <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>


<script src="js/doorlock.js"></script>



</head>
<body>




<script type="text/javascript">
$(document).bind("mobileinit", function () {
    $.mobile.ajaxEnabled = false;
});

$(document).on('pageshow', '#page1', function(event){
	var alert_msg = '<?php if(isset($_SESSION['alert_msg']))echo $_SESSION['alert_msg'];?>';
	if(alert_msg.length)toast(alert_msg);
	alert_msg = '';
});
var toast=function(msg){

	$("<div class='ui-loader ui-overlay-shadow ui-body-e ui-corner-all'><h3>"+msg+"</h3></div>")
	.css({ display: "block", 
		opacity: 0.90, 
		position: "fixed",
		padding: "7px",
		"text-align": "center",
		width: "270px",
		left: ($(window).width() - 284)/2,
		top: $(window).height()/2 })
	.appendTo( $.mobile.pageContainer ).delay( 2000 )
	.fadeOut( 400, function(){
		$(this).remove();
	});
}

</script> 


<!-- Home -->
<div data-role="page" id="page1">
	<!--Header-->
    <div data-theme="b" data-role="header" style="padding:10px;">
        <div style="text-align:center">
		<h1>
            Doorlock Homes
        </h1>
		<img src="images/icon.png" height=75px/>
		</div>
		<p><p/>
		 
		 
		 <a data-icon="arrow-l" data-role="button"  rel="external" data-transition="slide" href="logout.php" data-theme="c">
			Logout
        </a>	
    </div>
	<!--End Header-->
	
	
	<!--POPUP
	<a href="index.php?ch=logout" style="float:right;padding-right:20px;padding-top:5px;" data-transition="slide">Logout</a><br/>	
	-->
	
	<div data-role="popup" id="popupDialog" data-dismissible="false" data-overlay-theme="a" data-theme="b" style="max-width:400px;" class="ui-corner-all">
			<div data-role="header" data-theme="b" class="ui-corner-top" style="min-width:300px">
				<h1>Please wait...</h1>
			</div>
			<div data-role="content" data-theme="c" class="ui-corner-bottom ui-content" style="text-align:center;">
				<div id="popupcontentdiv">
					Operation in process...<br/>
					<img src="http://www.webdevstuff.com/wp-content/uploads/postimages/65_cube.gif" />
				</div>
				<br/>
				
				<a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c">OK</a>    
			</div>
	</div>
	<!--ENDPOPUP-->

     
    <div data-role="content">
		<h3 id="curstate" style="text-align:center">Finding lock state...</h3>
        <ul data-role="listview" data-divider-theme="b" data-inset="true">
            <li data-role="list-divider" role="heading">
                Door Control
            </li>
            <li data-theme="c">
                <a href="#popupDialog" data-rel="popup" id="lock">
                    Lock
                </a>
            </li>
            <li data-theme="c">
                <a href="#popupDialog" data-rel="popup" id="unlock">
                    Unlock
                </a>
            </li>
			<li data-theme="c">
                <a href="#popupDialog" data-rel="popup" id="status">
                    Status
                </a>
            </li>
            <li data-theme="c">
                <a href="doorbell.php" data-transition="slide">
                    View Doorbell History
                </a>
            </li>
        </ul>
        <ul data-role="listview" data-divider-theme="b" data-inset="true">
            <li data-role="list-divider" role="heading">
                Account Management
            </li>
            <li data-theme="c">
                <a href="../change_pw.php" data-transition="slide">
                    Change Password
                </a>
            </li>
            <li data-theme="c">
                <a href="add_user.php" data-transition="slide">
                    Add User
                </a>
            </li>
            <li data-theme="c">
                <a href="remove_user.php" data-transition="slide">
                    Remove User
                </a>
            </li>
            <li data-theme="c">
                <a href="display_log.php" data-transition="slide">
                    View Log
                </a>
            </li>
            <li data-theme="c">
                <a href="display_log.php?error=true" data-transition="slide">
                    View Error Log
                </a>
            </li>
        </ul>
	<br/>
    </div>
    <div data-theme="b" data-role="footer" data-position="fixed">
        <h2>
		&copy;	Nicholas Konecny <br/>and<br/> Devan Houlihan
        </h2>
    </div>
</div>
</body>
</html>
<?php unset($_SESSION['alert_msg']); ?>
