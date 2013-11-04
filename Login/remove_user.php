<?php
//check logged in or not!
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
if(!isset($_SESSION['loggedIn'])){
	header('Location:index.php');
}
require('classes/sql.php');


if(isset($_POST['usrname']) && isset($_POST['pw1']) && isset($_POST['primpw'])){
	$user = $_POST['usrname'];
	$pw1 = $_POST['pw1'];
	$primpw = $_POST['primpw'];
	

	echo $user . $pw1 . $primpw;
	
	$m = new mysql();

	$sql = "select count(*) from members where id=1 and password='$primpw'";
	$result = mysql_query($sql, $m->con);
	$row = mysql_fetch_array($result);
	if (!$result)
        {
		echo 'Error Saving Data. ';
	}
	if ($row[0] > 0)
	{
		$sql2 = "select * from members where username ='$user' and password='$pw1'";
		$result2 = mysql_query($sql2, $m->con);
		$row2 = mysql_fetch_array($result2);
			
		if($row2[0] == 1){
			$msg = 'Cannot delete primary user';
			print_r($row2);
		}
		else{
			$sql3 = "delete from members where username = '$user' and password ='$pw1'";
			$result3 = mysql_query($sql3, $m->con);
			
			if(!$result3){
				$msg = 'update didnt work';
			}
			if($row2[0] > 0){
				header("location:logged_in.php");
				exit;
			}
			else {
				$msg = 'Wrong User or Password.';
			}
		}
	}
	else
	{
		$msg = 'Wrong Primary password.';
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
	<h3>Remove User</h3>
	   <form action="" id="changepw" method="POST"> 
		<table>
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
