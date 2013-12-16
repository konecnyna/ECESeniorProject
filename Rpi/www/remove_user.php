<?php
//remove_user.php
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

//create log and sql variables
$m = new mysql();
$log = new log();
$usr_id = $_SESSION['loggedIn'];

//if submit button is hit
if(isset($_POST['usrname']) && isset($_POST['pw1']) && isset($_POST['primpw'])){
	$user = $_POST['usrname'];
	$pw1 = 	md5($_POST['pw1'] . 'd64kd87q');
	$primpw = md5($_POST['primpw'] . 'd64kd87q');
	

	//query to check primary user password
	$sql = "select count(*) from members where user_id=1 and password='$primpw'";
	$result = mysql_query($sql, $m->con);
	$row = mysql_fetch_array($result);
	if (!$result)			//error check
        {
		echo 'Error Saving Data. ';
		$log->insert_log("$usr_id", 102, -1);	//update log
	}
	if ($row[0] > 0)		//if primary password is correct
	{
		//new query to check if wanted user is primary user
		$sql2 = "select * from members where username ='$user' and password='$pw1'";
		$result2 = mysql_query($sql2, $m->con);
		$row2 = mysql_fetch_array($result2);
			
		if($row2[0] == 1){	//if trying to delete primary user, deny it
			$msg = 'Cannot delete primary user';
			$log->insert_log("$usr_id", 102, 93);	//update log

		}
		else{			//actual delete query
			$sql3 = "delete from members where username = '$user' and password ='$pw1'";
			$result3 = mysql_query($sql3, $m->con);
			
			if(!$result3){
				$msg = 'update didnt work';
				$log->insert_log("$usr_id", 102, -1);	//update log
			}
			
			//query to see if remove worked	
			$user_sql = "select user_id from members where user_id = $usr_id";
			$user_rez = mysql_query($user_sql, $m->con);
			
			if($row2[0] > 0){	//if current user is deleted, logout
				if($user_rez[0]>0) header('Location:logout.php');
				else{		//else relocate to logged in
					$_SESSION['alert']="$user deleted successfully";
					header("location:logged_in.php");
				}
				$log->insert_log("$usr_id", 102, 2);		//update log
				exit;
			}
			else {			//if user doesnt exist
				$msg = 'Wrong User or Password.';
				$log->insert_log("$usr_id", 102, 93);	//update log
			}
			

		}
	}
	else			//wrong primary password
	{
		$msg = 'Wrong Primary password.';
		$log->insert_log("$usr_id", 102, 90);		//update log
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
<script type="text/javascript">
$(document).bind("mobileinit", function () {
    $.mobile.ajaxEnabled = false;
});
</script>

<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
</head>

<body>

<div data-role="page" id="remove_user">
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
	<h3>Remove User</h3>
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
	    
	    <form action='logged_in.php' method='post'>
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
		&copy;	Nicholas Konecny <br/>and<br/> Devan Houlihan
        </h2>
    </div>

</div>
</body>
</html>

