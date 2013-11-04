<?php
//check logged in or not!
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
if(!isset($_SESSION['loggedIn'])){
	header('Location:index.php');
}
require('classes/sql.php');


if(isset($_POST['usrname']) && isset($_POST['oldpw']) && isset($_POST['newpw1']) && isset($_POST['newpw2'])){
	$user = $_POST['usrname'];
	$oldpw = $_POST['oldpw'];
	$newpw1 = $_POST['newpw1'];
	$newpw2 = $_POST['newpw2'];
	

	echo $user . $oldpw . $newpw1 . $newpw2;
	
	$m = new mysql();

	$sql = "select count(*) from members where username='$user' and password='$oldpw'";
	$result = mysql_query($sql, $m->con);
	$row = mysql_fetch_array($result);
	if (!$result)
        {
		echo 'Error Saving Data. ';
	}
	if ($row[0] > 0)
	{
		if($newpw1 != $newpw2){
			$msg = "New passwords don't match.";
		}
		else{
			$sql2 = "UPDATE members SET password='$newpw1' WHERE username='$user'";
			$result2 = mysql_query($sql2, $m->con);
			if(!$result2){
				$msg = 'update didnt work';
			}
			else {
				header("location:logged_in.php");
				exit;
			}
		}
	}
	else
	{
		$msg = 'Wrong username or password.';
	}
}


?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="http://jquery.bassistance.de/validate/demo/site-demos.css">
	<link href="styles/style.css" rel="stylesheet">
	<script src="jquery/jquery-1.9.1.js"></script>   
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script src="http://jquery.bassistance.de/validate/jquery.validate.js"></script>
	<script src="http://jquery.bassistance.de/validate/additional-methods.js"></script>
	<script src="jquery/main.js"></script>
	<script src="jquery/jquery.confirm.js"></script>
</head>

<body>
	<a href="index.php?ch=logout">Logout</a></div><br/>	
	<div id="doortool" style="text-align:center">
	<h3>Change Password</h3>
	   <form action="" id="changepw" method="POST"> 
		<table>
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
                        <td><input type="submit" id="submit" name="submit" value="Submit" /></td>
                    </tr>
                    <tr>
                        <td colspan="2"><?php echo (isset($msg) ? '<font color="red">'.$msg.'</font>': '');?></td>
                    </tr>
	
		</table>
	    </form>
	    
	    <form action='' method='post'>
            	<table>
			<td colspan="5">
                		<button id="nevermind" name="nevermind" style="width:100%">Nevermind</button>
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
		<hr/>
		



</body>
</html>

<?php

if(isset($_POST['nevermind']))
{
	header("location:logged_in.php");
	exit;
}

?>
