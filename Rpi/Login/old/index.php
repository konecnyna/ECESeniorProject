<?php
session_start();

require('classes/sql.php');

if(isset($_POST['usremail']) && isset($_POST['usrpass'])){
	//$email = mysql_real_escape_string($m->con, $_POST['usremail']);
	$user = $_POST['usremail'];
	//$password = mysql_real_escape_string($m->con, $_POST['usrpass']);
	$password = $_POST['usrpass'];
	$password = md5($password . 'd64kd87q');

	$m = new mysql();
	$sql = "select count(*) from users where User_Name='$user' and Password='$password'";
	$result = mysql_query($sql, $m->con);
	if (!$result)
	{
			echo 'Error Saving Data. ';
			exit();
	}
	$row = mysql_fetch_array($result);
	if ($row[0] > 0)
	{
		$_SESSION['loggedIn'] = 1;
		header ('Location: add_drink.php');
		exit();
	}
	else
	{      
		$msg = 'Wrong email or password.';
	}
}
	
//logout script
if(isset($_REQUEST['ch']) && $_REQUEST['ch'] == 'logout'){
	print "Logged out";
	unset($_SESSION['loggedIn']);
	unset($_SESSION['usremail']);
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
    <title>Drink Tool</title>
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
            usremail: {
                required: true
            }
        },
        messages: {
            usrpass: {
                required: 'Password is required.'  
            },
            usremail: {
                required: 'Email is required.',
                email : 'Invalid Email.'
            }
        }
    }); // end register validation
});
</script>
</head>
    <body>
        <div id="DivLogin">
		
			<h3 style="text-align:center">The Drink Tool</h3>
            <form action="" id="login" method="POST">
                <table>
                    <tr>
                        <td>User Name :</td>
                        <td><input type="text" id="usremail" name="usremail" /></td>
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