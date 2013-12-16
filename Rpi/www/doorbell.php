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

<?php
//doorbell.php
//check logged in or not!
session_start();
//enable error display
ini_set('display_errors', 1);
error_reporting(E_ALL);
if(!isset($_SESSION['loggedIn'])){
	header('Location:index.php');
}

if(isset($_SESSION['alert_msg'])){
	unset($_SESSION['alert_msg']);
}

//uses functions from these scripts
require('classes/sql.php');
require('classes/log.php');


?>


<body>

<div data-role="page" id="change_pw">
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
	<h3 style="text-align:center">Doorbell History</h3>
		<center>
		<?php
			//pulls image locations into an array and sorts them by their timestamp
			$images_string = `ls -R -t | grep ".jpg"`;
			$images_array = explode("\n", $images_string);
			for ($i = 0; $i < 10; $i++){
				$image_info = explode("_", $images_array[$i]);
				//display all 10 images and their timestamps
				echo '<br><IMG SRC = "images/doorbell/' . $images_array[$i] . '" ALT= "image" align = "middle" Width =320 Height = 240>';
				echo '<br><td>' . $image_info[0] . ' ' . $image_info[1] . ', ' . $image_info[2] . ' at ' . $image_info[3] . ':' . $image_info[4] . '<br>';
			}

		?>	
		</center>
	    <form action='logged_in.php' method='post'>
			<table>
			<td colspan="5">
				<button id="nevermind" name="nevermind" style="width:100%">Back</button>
   			</td>
            </form>	
		<p></p>
		<p></p>
		<p></p>
		<br/>
		<br/>
		
		<p></p>
			<p></p>

		
		<div data-theme="b" data-role="footer" data-position="fixed">
			<h2>
			&copy;	Nicholas Konecny <br/>and<br/> Devan Houlihan
			</h2>
		</div>
		

</div>

</body>
</html>

