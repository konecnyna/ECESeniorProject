<?php
//serial.php
//enable error display
session_start();
error_reporting(E_ALL);

//check if in session
if(!isset($_SESSION['loggedIn'])){
	header('Location:index.php');
}
//uses functions from these scripts
require('classes/sql.php');
require('classes/log.php');

$usr_id = $_SESSION['loggedIn'];

//function that activates python communication script
function send_to_avr($action) {
   $cmd = "python classes/serialcomm.py $action";	//set python command
   $response = shell_exec($cmd);			//execute the shell command
   
  //if the python executed successfully and curstatus is set 
   if($response && isset($_GET['curstatus'])){
		$db = new mysql();
		$rez = split(": ",$response);
		if($rez[1]==3){				//if locked status code
			echo "<font color='green'>Locked</font>";
		}else if($rez[1]==4){			//if unlocked status code
			echo "<font color='blue'>Unlocked</font>";
		}else if($rez[1]==80){			//if sensor error status code, offer a reset
			echo "<font color='red'>Sensor Error.</font> <a href='#popupDialog' data-rel='popup' id='reset'>Reset?</a>";	
		}else{					//if timeout occured
			echo "<font color='red'>Error communicating with AVR</font>";
		}
		exit();
   }
   
   
   if(!$response){					//if python failed to execute
       echo "Error: python exec failed!<br/>";
   } else {
       //echo "Python script exec successfully!<br/>";
   }
   
   return $response;
   //in future change to redirect back to loggedin
  // maike jquery so it can be updated in real time
}



$rez = "";
$code_id = -1;
if(isset($_GET['unlock'])){		//from serial.php
	$rez = send_to_avr('u');	//send unlock code
	$code_id = 11;			//for log
}else if(isset($_GET['lock'])){		//from serial.php
	$rez = send_to_avr('l');	//send lock code
	$code_id = 10;			//for log
}else if(isset($_GET['status'])){	//from serial.php
	$rez = send_to_avr('s');	//send status code
	$code_id = 12;			//for log
}else if(isset($_GET['reset'])){	//from js
	$rez = send_to_avr('r');	//send reset code
	$code_id = 5;			//for log
}else if(isset($_GET['curstatus'])){	//from js
	$rez = send_to_avr('s');	//send status code
	$code_id = 12;			//for log
}

$rez = split(": ",$rez);		//organizes response from avr
if($rez == ""){				//if no response, give error
	$rez[1] = -1;
}

//new mysql variable
$db = new mysql();
$rez_code = "select code_desc from statusCodes where code_id='$rez[1]'";	//query for visual update 
$code_desc = mysql_query($rez_code, $db->con);					//on the ?= pages
$row_code_desc = mysql_fetch_array($code_desc);
echo $row_code_desc['code_desc'];

//new log varialbe
$log = new log();
$log->insert_log($usr_id, $code_id, $rez[1]);		//update log

//echo "<br/>Event logged. <br/>Finished";


echo "||||$rez[1]"; 


?>
