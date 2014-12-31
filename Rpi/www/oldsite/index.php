<?php
session_start();
ini_set('display_errors', 1); 
error_reporting(E_ALL);

require('classes/sql.php');
require('classes/log.php');

$m = new mysql();
$log = new log();

if(isset($_POST['usrname']) && isset($_POST['usrpass'])){
	//$email = mysql_real_escape_string($m->con, $_POST['usremail']);
	$user = $_POST['usrname'];
	//$password = mysql_real_escape_string($m->con, $_POST['usrpass']);
	$password = $_POST['usrpass'];
	//$password = md5($password . 'd64kd87q');

	$sql1 = "select user_id from members where username='$user'";
	$result1 = mysql_query($sql1, $m->con);
	$row1 = mysql_fetch_array($result1);
	
	$sql2 = "select user_id from members where username='$user' and password = '$password'";
	$result2 = mysql_query($sql2, $m->con);
	$row2 = mysql_fetch_array($result2);
	
	if (!$result1)
	{
		echo 'Error Saving Data. ';
		$log->insert_log(-1, 100, -1);
		exit();
	}
	if (!$result2)
	{
		echo 'Error Saving Data. ';
		$log->insert_log(-1, 100, -1);
		exit();
	}
	if ($row1[0] > 0)
	{
		if($row2[0] > 0){
			$_SESSION['loggedIn'] = $row1[0];
			$usr_id = $_SESSION['loggedIn'];	
			header ('Location: logged_in.php');
			$log->insert_log("$usr_id", 100, 2);
			exit();
		}
		else {
			$usr_id = $row1[0];
			$log->insert_log("$usr_id", 100, 90);
			$msg = 'Wrong username or password.';
		}
	}
	else
	{      
		$msg = 'Wrong username or password.';
		$log->insert_log(-1, 100, 91);
	}
}
	
//logout script
if(isset($_REQUEST['ch']) && $_REQUEST['ch'] == 'logout'){
	print "Logged out";
	unset($_SESSION['loggedIn']);
	unset($_SESSION['usrname']);
	unset($_SESSION['usrpass']);
	header('Location:index.php');
} 
 

if (isset($_SESSION['loggedIn'])) {
    if (isset($_REQUEST['pagename']))
        header('Location:' . $pagename . '.php');
    else
        header('Location:logged_in.php');
}else{

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	<title>Your Page Title Here :)</title>
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- CSS
  ================================================== -->
	<link rel="stylesheet" href="stylesheets/base.css">
	<link rel="stylesheet" href="stylesheets/skeleton.css">
	<link rel="stylesheet" href="stylesheets/layout.css"> <title>Doorlock Holmes</title>
    
  <link rel="stylesheet" href="https://d10ajoocuyu32n.cloudfront.net/mobile/1.3.1/jquery.mobile-1.3.1.min.css">

	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="http://jquery.bassistance.de/validate/demo/site-demos.css">

</head>
    <body>
		<div class="container">
			<h3 style="text-align:center">DoorLock Homles Login:</h3>
			<div class="sixteen columns" >
				<div id="DivLogin" style="magin-top:25px;">
					
					<form action="" id="login" method="POST">
					<table>
						<tr>
						<td>User Name :</td>
						<td><input type="text" id="usrname" name="usrname" /></td>
						</tr>
						<tr>
						<td>Password :</td>
						<td><input type="password" id="usrpass" name="usrpass" /></td>
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
				</div>
			</div>
		
		</div> 
    </div>
<?php
}
?>
    </body>
</html>
