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

<!-- Need this for session shit -->
<script type="text/javascript">
$(document).bind("mobileinit", function () {
    $.mobile.ajaxEnabled = false;
});
</script>

<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>


</head


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

	
	//$link = mysql_connect('konecny.dyndns.org', 'Nick', '05uhwHY.');
	//	die('Could not connect: ' . mysql_error());
///	mysql_close($link);
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

    <body>
		<div data-role="page" id="page1">
		<div data-theme="b" data-role="header" style="padding:10px;">
			<div style="text-align:center">
			<h1>
				Doorlock Homes
			</h1>
			<img src="http://newescapologist.co.uk/wp-content/uploads/2013/09/silhouette-large.gif" height=75px/>
			</div>
			<p><p/>
		</div>
				<div id="DivLogin" style="magin-top:25px;">
					<form action="" id="login" method="POST" >
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
						<td><input type="hidden" name="login" value="login" data-ajax="false" /></td>
						<td><input type="submit" id="submit" name="submit" value="Submit" data-ajax="false" /></td>
						</tr>
						<tr>
						<td colspan="2"><?php echo (isset($msg) ? '<font color="red">'.$msg.'</font>': '');?></td>
						</tr>
					</table>
					</form>
	
		
			</div> 
			<div data-theme="b" data-role="footer" data-role="footer" data-position="fixed" data-role="footer" data-position="fixed">
				<h2>
				&copy;	Nicholas MUTHAFUCKING Konecny <br/>and<br/> Devan Houlihan
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
