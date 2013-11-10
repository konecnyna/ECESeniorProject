<?php
//check logged in or not!
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
if(!isset($_SESSION['loggedIn'])){
	header('Location:index.php');
}
require('classes/sql.php');
require('classes/log.php');

$m = new mysql();
$log = new log();
$usr_id = $_SESSION['loggedIn'];

if(isset($_POST['usrname']) && isset($_POST['pw1']) && isset($_POST['pw2']) && isset($_POST['primpw'])){
	$user = $_POST['usrname'];
	$pw1 = $_POST['pw1'];
	$pw2 = $_POST['pw2'];
	$primpw = md5( $_POST['primpw'] . 'd64kd87q');
	

	$sql = "select count(*) from members where user_id=1 and password='$primpw'";
	$result = mysql_query($sql, $m->con);
	$row = mysql_fetch_array($result);
	if (!$result)
        {
		echo 'Error Saving Data. ';
	}
	if ($row[0] > 0)
	{
		if($pw1 !== $pw2){
			$msg = "New passwords don't match.";
                        $log->insert_log("$usr_id", 101, 92);
		}
		else{
			$pw1 = 	md5($pw1 . 'd64kd87q');
			$sql2 = "insert into members (username, password) values ('$user','$pw1')";
			$result2 = mysql_query($sql2, $m->con);
			if(!$result2){
				$msg = 'User exists.';
                        	$log->insert_log("$usr_id", 101, 93);
			}
			else {
				$_SESSION['alert_msg']="$user added successfully";
				header("location:logged_in.php");
				$log->insert_log("$usr_id", 101, 2);
				exit;
			}
		}
	}
	else
	{
		$msg = 'Wrong primary password.';
                $log->insert_log("$usr_id", 101, 90);
	}
}


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


<div data-role="page" id="add_user">
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
	<h3>Add User</h3>
	   <form action="" id="changepw" method="POST" rel="external" data-ajax="false"> 
		<table style="margin:auto;">
	            <tr>
                        <td>User Name :</td>
                        <td><input type="text" id="usrname" name="usrname" /></td>
                    </tr>
	            <tr>
                        <td>Password :</td>
                        <td><input type="password" id="pw1" name="pw1" /></td>
                    </tr>
                    <tr>
                        <td>Repeat Password :</td>
                        <td><input type="password" id="pw2" name="pw2" /></td>
                    </tr>
                    <tr>
                        <td>Primary User Password :</td>
                        <td><input type="password" id="primpw" name="primpw" /></td>
                    </tr>
                    <tr>
                        <td><input type="hidden" name="login" value="login" /></td>
                        <td><input type="submit" id="submit" name="submit" value="Submit" /></td>
                    </tr>
                    <tr>
                        <td colspan="2"><?php echo (isset($msg) ? '<font color="red">'.$msg.'</font>': '');?></td>
                    </tr>
	
		</table>
	    </form>
	    
	    <form action='logged_in.php'  rel="external" method='post'>
            	<table>
			<td colspan="5">
                		<button id="nevermind" name="nevermind" style="width:100%">Back</button>
   			</td>
		</table>
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
			&copy;	Nicholas MUTHAFUCKING Konecny <br/>and<br/> Devan Houlihan
			</h2>
		</div>
		

</div>

</body>
</html>

