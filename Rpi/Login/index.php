<?php
session_start();
ini_set('display_errors', 1); 
error_reporting(E_ALL);


require('classes/sql.php');

if(isset($_POST['usrname']) && isset($_POST['usrpass'])){
	//$email = mysql_real_escape_string($m->con, $_POST['usremail']);
	$user = $_POST['usrname'];
	//$password = mysql_real_escape_string($m->con, $_POST['usrpass']);
	$password = $_POST['usrpass'];
	//$password = md5($password . 'd64kd87q');

	$m = new mysql();
	
	//$link = mysql_connect('konecny.dyndns.org', 'Nick', '05uhwHY.');
	//	die('Could not connect: ' . mysql_error());
///	mysql_close($link);
	$sql = "select count(*) from members where username='$user' and password='$password'";
	$result = mysql_query($sql, $m->con);
	
	echo $user . $password;
	if (!$result)
	{
			echo 'Error Saving Data. ';
			exit();
	}
	$row = mysql_fetch_array($result);
	if ($row[0] > 0)
	{
		$_SESSION['loggedIn'] = 1;
		header ('Location: logged_in.php');
		exit();
	}
	else
	{      
		$msg = 'Wrong username or password.';
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
        header('Location:index.php');
}else{

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Doorlock Homes</title>
    <meta http-equiv="Content-Type"
    content="text/html; charset=UTF-8" />
    <link href="styles/style.css" rel="stylesheet">
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script>
$(document).ready(function(){
    $('#login').validate({
        rules: {
            usrpass: {
                required: true
            },
            usrname: {
                required: true
            }
        },
        messages: {
            usrpass: {
                required: 'Password is required.'  
            },
            usrname: {
                required: 'Username is required.',
                Username : 'Invalid Username.'
            }
        }
    }); // end register validation
});
</script>
</head>
    <body>
        <div id="DivLogin">
		
			<h3 style="text-align:center">Doorlock Homes Login</h3>
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
<?php
}
?>
    </body>
</html>
