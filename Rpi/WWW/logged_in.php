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
		<h3>Door Control</h3>
		<table>
			<tr>
				<th colspan="2">Lock/Unlock</th>
			</tr>
			<tr>
				<form action='/serial.php?lock=true' method='post'>
					<td colspan="2"><button id="lockbtn" style="width:100%">Lock</button></td>
				</form>
			</tr>
			<tr>				
				<form action='/serial.php?unlock=true' method='post'>
					<td colspan="2"><button id="unlockbtn" style="width:100%">Unlock</button></td>
				</form>
			</tr>
		</table>
		
		<p></p>
		<p></p>
		<p></p>
		<br/>
		<br/>
		<table id="passwordtool">
			<tr>
				<th colspan="5">Password Management</th>
			</tr>
			<tfoot>
				<tr>
					<form action='' method='post'>
						<td colspan="5">
							<button id="pwbtn" name="pwbtn" style="width:100%">Change Password</button>
						</td>
					</form>
				</tr>
			</tfoot>
		</table>
		
		<p></p>
		<p></p>
		<hr/>
		



</body>
</html>

<?php

if(isset($_POST['pwbtn']))
{
header("location:change_pw.php");
exit;
}

?>
