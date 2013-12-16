<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <title></title>

 <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" />
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>



<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>


</head>


<?php
//index.php
session_start();
//allow errors to be displayed
ini_set('display_errors', 1); 
error_reporting(E_ALL);

require('classes/sql.php');	//uses functions from 
require('classes/log.php');	//these php scripts

$m = new mysql();		//create mysql variable
$log = new log();		//create log variable

if(isset($_POST['usrname']) && isset($_POST['usrpass'])){
	//$user = mysql_real_escape_string($m->con, $_POST['usremail']);
	$user = $_POST['usrname'];			//set user equal to input
	
	//$password = mysql_real_escape_string($m->con, $_POST['usrpass']);
	$password = $_POST['usrpass'];			//set password equal to input
	
	$password = md5($password . 'd64kd87q');	//md5 hash the password
	
	//query to check if user exists
	//for log use only
	$sql1 = "select user_id from members where username='$user'";
	$result1 = mysql_query($sql1, $m->con);	
	$row1 = mysql_fetch_array($result1);
	
	//query for user and pass match
	$sql2 = "select user_id from members where username='$user' and password = '$password'";
	$result2 = mysql_query($sql2, $m->con);				
	$row2 = mysql_fetch_array($result2);
	
	//error checking for mysql queries	
	if (!$result1)			
	{
		echo 'Error Saving Data. ';
		$log->insert_log(-1, 100, -1);	//insert error into log
		exit();
	}
	if (!$result2)
	{
		echo 'Error Saving Data. ';
		$log->insert_log(-1, 100, -1);	//insert error into log
		exit();
	}
	if ($row1[0] > 0)		//if user exists
	{
		if($row2[0] > 0){	//if user and password match
			$_SESSION['loggedIn'] = $row1[0];	//session variable is set to userid#
			$usr_id = $_SESSION['loggedIn'];	
			header ('Location: logged_in.php');	//relocate to logged in
			$log->insert_log("$usr_id", 100, 2);	//insert successful login to log
			exit();
		}
		else {			//if user exists, but wrong password
			$usr_id = $row1[0];				
			$log->insert_log("$usr_id", 100, 90);	//insert error into log
			$msg = 'Wrong username or password.';
		}
	}
	else				//if user doesnt exist
	{      
		$msg = 'Wrong username or password.';
		$log->insert_log(-1, 100, 91);			//insert error into log
	}
}
	
//logout script
if(isset($_REQUEST['ch']) && $_REQUEST['ch'] == 'logout'){
	print "Logged out";
	unset($_SESSION['loggedIn']);		//unset session variables
	unset($_SESSION['usrname']);
	unset($_SESSION['usrpass']);
	header('Location:index.php');		//relocate to here
} 
 

if (isset($_SESSION['loggedIn'])) {		//for refresh and direct page requests once logged in
    if (isset($_REQUEST['pagename']))
        header('Location:' . $pagename . '.php');
    else
        header('Location:logged_in.php');
}else{


	//HTML begins now, no comments
?>

    <body>
		<div data-role="page" id="page1">
		<div data-theme="b" data-role="header" style="padding:10px;">
			<div style="text-align:center">
			<h1>
				Doorlock Homes
			</h1>
			<img src="images/icon.png" height=75px/>
			</div>
			<p><p/>
		</div>
				<div id="DivLogin" style="magin-top:25px;">
					<form action="" id="login" method="POST" rel="external" data-ajax="false">
					<table style="margin:auto;">
						<tr>
						<td>User Name :</td>
						<td><input type="text" id="usrname" name="usrname" /></td>
						</tr>
						<tr>
						<td>Password :</td>
						<td><input type="password" id="usrpass" name="usrpass" /></td>
						</tr>
						<tr>
						<td><input type="hidden" name="login" value="login"  /></td>
						<td><input type="submit" id="submit" name="submit" value="Submit" /></td>
						</tr>
						<tr>
						<td colspan="2"><?php echo (isset($msg) ? '<font color="red">'.$msg.'</font>': '');?></td>
						</tr>
					</table>
					</form>
	
		
			</div> 
			<div data-theme="b" data-role="footer" data-role="footer" data-position="fixed" data-role="footer" data-position="fixed">
				<h2>
				&copy;	Nicholas Konecny <br/>and<br/> Devan Houlihan
				</h2>
			</div>
		</div>

<?php
}
?>
   </body>
</html>
</body>
</html>
