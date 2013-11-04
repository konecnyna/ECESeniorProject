<?php

echo "Please Wait...";
//send a U (unlock) or a L (lock)
function send_to_avr($action) {
   $cmd = "python classes/serialcomm.py $action";
   $response = exec($cmd);
   if(!$response){
       echo "Error: python exec failed!";
   } else {
       echo "<br />";
       echo "successfully executed!";
       echo "<br />";
       echo "Response: $response";
   }
   //in future change to redirect back to loggedin
  // make jquery so it can be updated in real time
}

if(isset($_GET['unlock'])){
	send_to_avr('u');
}else if(isset($_GET['lock'])){
	send_to_avr('l');
}else echo "Error, no post variables set";



?>
