<?php
//check logged in or not!
session_start();
error_reporting(E_ALL);
if(!isset($_SESSION['loggedIn'])){
	header('Location:index.php');
}
require('classes/sql.php');
require('classes/log.php');
?>
<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">

	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="http://jquery.bassistance.de/validate/demo/site-demos.css">
	
	<link rel="stylesheet" href="stylesheets/base.css">
	<link rel="stylesheet" href="stylesheets/skeleton.css">
	<link rel="stylesheet" href="stylesheets/layout.css">
	<link rel="stylesheet" href="skeleton.com/documentation-assets/docs.css">
	
	
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  
    <script>
    $(document).ready(function(){
	$("#dialog-message").hide();
	
    $("button").click(function(){
		var url = "serial.php?";
		if(this.id == "lock") url += "lock=true";
		else if (this.id == "unlock") url += "unlock=true";
		else if (this.id == "status") url += "status=true";
		else if (this.id == "reset"){
			$('#dialog-message').html('Please wait...<br/><img src="http://www.webdevstuff.com/wp-content/uploads/postimages/65_cube.gif" />');			
			url += "reset=true";
		}
		var arr;
		$.get(url,function(data,status){
			arr = data.split("||||");
			
		   if(parseInt(arr[1]) == "80"){
				arr[0] = arr[0] + '	<button type="button" class="new-button" id="reset">Reset</button >';
		   }
		    $('#dialog-message').html(arr[0]);
		});
		
		if(this.id=="lock" || this.id=="unlock" || this.id=="status")
		{

				 $( "#dialog-message" ).dialog({
					  
					  draggable:false,
					  buttons: {
						Ok: function() {
						  $( this ).dialog( "close" );
						  $('#dialog-message').html('Please wait...<br/><img src="http://www.webdevstuff.com/wp-content/uploads/postimages/65_cube.gif" />');
						}
					
					  }
				});
			
		}
	
	  });
		 
	

	});
    </script>


						
										


</head>

<body>
	<div class="header">
		<div class="container" style="display:block; padding:15px">
			<img src="images/icon.png" height=75px/>

				<a href="index.php?ch=logout" style="float:right">Logout</a><br/>	
		</div>
	</div>
	<div id="popup">
	<a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'">here</a></p>
	<div id="light" class="white_content">. <a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">Close</a></div>
	<div id="fade" class="black_overlay"></div>
	</div>
	
	<div class="bigback"/>
	<div class="container" style="text-align:center">

		<div class="sixteen columns" style="text-align:center;">
			<h3 id='lockedbtn'>Door Control</h3>
			

			
			<div id="dialog-message" title="Please wait..." style="text-align:center">
				<img src="http://www.webdevstuff.com/wp-content/uploads/postimages/65_cube.gif" />
			</div>
			
			<button  class="bluebtn" type="button"   id="lock">Lock</button >
			<button class="bluebtn" type="button" id="unlock" >Unlock</button >
			<button  class="bluebtn" type="button" id="status">Status</button >	
			<button type="button" class="bluebtn" id="reset">Reset</button >
				   
			<p></p>
			<p></p>
			<p></p>
			<br/>
			<br/>
			<h3>Account Management</h3>
			
			<br/>
			<form action='change_pw.php' method='post'>
					<button class="bluebtn" id="pwbtn" name="pwbtn">Change Password</button>
			</form>
			<form action='add_user.php' method='post'>
				<button class="bluebtn" id="addbtn" name="addbtn" >Add User</button>
			</form>
			<form action='remove_user.php' method='post'>
				<button class="bluebtn" id="rembtn" name="rembtn" >Remove User</button>
			</form>
			<form action='display_log.php' method='post'>
				<button class="bluebtn" id="logbtn" name "logbtn">View Log</button>
			</form>
			<form action='display_log.php?error=true' method='post'>
				<button  class="bluebtn" id="logbtn" name "logbtn">View Error Log</button>
			</form>
		
			<p></p>
			<p></p>
	</div>
	</div>


</body>
</html>
<?php

?>

