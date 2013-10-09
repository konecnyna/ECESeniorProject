<?php
//check logged in or not!
session_start();
error_reporting(E_ALL);
if(!isset($_SESSION['loggedIn'])){
	header('Location:index.php');
}
require('classes/sql.php');



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
