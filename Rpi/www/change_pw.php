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
//change_pw.php
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

//uses functions from hese
require('classes/sql.php');
require('classes/log.php');

//create new mysql and log variables
$m = new mysql();
$log = new log();
$usr_id = $_SESSION['loggedIn'];

//if they have filled in all fields and submitted
if(isset($_POST['usrname']) && isset($_POST['oldpw']) && isset($_POST['newpw1']) && isset($_POST['newpw2'])){
	$user = $_POST['usrname'];
	$oldpw = $_POST['oldpw'];	
	$oldpw = md5($oldpw . 'd64kd87q');	//password hash
	$newpw1 = $_POST['newpw1'];
	$newpw2 = $_POST['newpw2'];
	
	//query to see if username and old password mathes the DB
	$sql = "select count(*) from members where username='$user' and password='$oldpw'";
	$result = mysql_query($sql, $m->con);
	$row = mysql_fetch_array($result);
	if (!$result)				//error check for mysql
        {
		echo 'Error Saving Data. ';
		$log->insert_log("$usr_id", 103, -1);
	}
	if ($row[0] > 0)			//if user exists
	{
		if($newpw1 !== $newpw2){				//if new pws dont match
			$msg = "New passwords don't match.";
			$log->insert_log("$usr_id", 103, 92);		//insert error into log
		}
		else{
			//query to change password
			$newpw1 = md5($newpw1 . 'd64kd87q');		//hash pw first
			$sql2 = "UPDATE members SET password='$newpw1' WHERE username='$user'";
			$result2 = mysql_query($sql2, $m->con);
			if(!$result2){					//error check
				$msg = 'update didnt work';
				$log->insert_log("$usr_id", 103, -1);
			}
			else {
				//successful password change
				$_SESSION['alert_msg']="Password changed successfully";	//set alert message 
				$log->insert_log("$usr_id", 103, 2);			//update log
				header("location:logged_in.php");			//relocate to loggedin
				exit;
			}
		}
	}
	else					//user doesnt exist
	{
		$msg = 'Wrong username or password.';
		$log->insert_log("$usr_id", 103, 93);		//update log
	}
}


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
	
	<div id="doortool" style="text-align:center">
	<h3>Change Password</h3>
	    <form action="" id="changepw" method="POST" rel="external" data-ajax="false"> 
		<input type="hidden" name="alert" value="alert" />
		<table style="margin:auto;">
	            <tr>
                        <td>User Name :</td>
                        <td><input type="text" id="usrname" name="usrname" /></td>
                    </tr>
	            <tr>
                        <td>Old Password :</td>
                        <td><input type="password" id="oldpw" name="oldpw" /></td>
                    </tr>
                    <tr>
                        <td>New Password :</td>
                        <td><input type="password" id="newpw1" name="newpw1" /></td>
                    </tr>
                    <tr>
                        <td>Repeat New Password :</td>
                        <td><input type="password" id="newpw2" name="newpw2" /></td>
                    </tr>
                    <tr>
                        <td><input type="hidden" name="login" value="login" /></td>
                        <td><input type="submit" id="submit" name="submit" value="Submit"  /></td>
                    </tr>
                    <tr>
                        <td colspan="2"><?php echo (isset($msg) ? '<font color="red">'.$msg.'</font>': '');?></td>
                    </tr>
	
		</table>
	    </form>
	    
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

