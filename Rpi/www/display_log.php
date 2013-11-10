<?php

session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
if(!isset($_SESSION['loggedIn'])){
	header('Location:index.php');
}

$show_debug = 0;
//echo $_GET["error"];
if(isset($_GET['error'])){
	$show_debug = 1;
}
//echo $show_debug;
$user_id = $_SESSION['loggedIn'];
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
</head>
<body>


<div data-role="page" id="display_log">
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
	
<h1>Log:</h1>

<?php 
$log = new log();

if($show_debug){
	echo $log->view_log($user_id, 60, 1);
}else{
	echo $log->view_log($user_id, 60, 0);
}
?>
    <div data-theme="b" data-role="footer" data-position="fixed">
        <h2>
		&copy;	Nicholas MUTHAFUCKING Konecny <br/>and<br/> Devan Houlihan
        </h2>
    </div>

</div>
</body>
</html>

