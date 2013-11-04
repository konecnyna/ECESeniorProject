<?php


session_start();
error_reporting(E_ALL);

//check if in session
if(!isset($_SESSION['loggedIn'])){
	header('Location:index.php');
}
require('classes/sql.php');
require('classes/log.php');

$usr_id = $_SESSION['loggedIn'];
//send a U (unlock) or a L (lock)
function send_to_avr($action) {
   $cmd = "python classes/serialcomm.py $action";
   $response = shell_exec($cmd);
   
   
   if($response && isset($_GET['curstatus'])){
		$db = new mysql();
		$rez = split(": ",$response);
		if($rez[1]==3){
			echo "<font color='green'>Locked</font>";
		}else if($rez[1]==4){
			echo "<font color='blue'>Unlocked</font>";
		}else{
			echo "<font color='red'>Error communicating with AVR</font>";
		}
		exit();
   }
   
   
   if(!$response){
       echo "Error: python exec failed!<br/>";
   } else {
       echo "Python script exec successfully!<br/>";
   }
   
   return $response;
   //in future change to redirect back to loggedin
  // maike jquery so it can be updated in real time
}



$rez = "";
$code_id = -1;
if(isset($_GET['unlock'])){
	$rez = send_to_avr('u');
        $code_id = 4;
}else if(isset($_GET['lock'])){
	$rez = send_to_avr('l');
        $code_id = 3;
}else if(isset($_GET['status'])){
	$rez = send_to_avr('s');
	$code_id = 5;
}else if(isset($_GET['reset'])){
	$rez = send_to_avr('r');
	$code_id = 5;//resetcode
}else if(isset($_GET['curstatus'])){
	$rez = send_to_avr('s');
	$code_id = 5;//resetcode
}

$rez = split(": ",$rez);
if($rez == ""){
 $rez[1] = -1;
}

$db = new mysql();
$rez_code = "select code_desc from statusCodes where code_id='$rez[1]'";
$code_desc = mysql_query($rez_code, $db->con);
$row_code_desc = mysql_fetch_array($code_desc);
echo $row_code_desc['code_desc'];


$log = new log();
$log->insert_log($usr_id, $code_id, $rez[1]);

echo "<br/>Event logged. <br/>Finished";


echo "||||$rez[1]"; 


?>
