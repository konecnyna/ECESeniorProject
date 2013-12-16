//doorlock.js

$(document).on('pageshow', function(event){
	$("#dialog-message").hide();
	$.get("serial.php?curstatus=true",function(data,status){				//when the page loads, set curstatus get true				
		$('#curstate').hide().html("Current State: " + data).fadeIn("slow");		//display the state of the lock with a slow fadein
	});

    $("body").delegate('a','click', function(){							//function begin
	
		if(this.id == "unlock" || this.id == "lock" || this.id == "status" || this.id == "reset")	//if one of these get variables are set.
		{
			var request = this.id;
			$('#popupcontentdiv').html('Operation in process...<br/><img src="http://www.webdevstuff.com/wp-content/uploads/postimages/65_cube.gif" />');	//popup loading gif
			var url = "serial.php?";
			if(this.id == "lock") url += "lock=true";													//set url based on button pressed
			else if (this.id == "unlock") url += "unlock=true";
			else if (this.id == "status") url += "status=true";
			else if (this.id == "reset"){
				url += "reset=true";
			}
			
			
			var arr;
			$.get(url,function(data,status){
				console.log("status: "+status+"||"+request);
	 		    arr = data.split("||||");					//parse response
			    if(parseInt(arr[1]) == "80"){
					arr[0] = arr[0] + '	 <a href="serial.php?reset=true" data-rel="popup" id="reset">Reset?</a>';			//if sensor error offer reset.
			    }else if(request== "lock" && parseInt(arr[1]) == "2"){
					parent.jQuery('#curstate').hide().html("Current State: <font color='green'>Locked</font>").fadeIn("slow");		//if lock success show locked
				}else if(request == "unlock" && parseInt(arr[1]) == "2"){
					parent.jQuery('#curstate').hide().html("Current State: <font color='blue'>Unlocked</font>").fadeIn("slow");		//if unlock success show unlocked
				}else if(request == "reset" && parseInt(arr[1]) == "2"){
					parent.jQuery('#curstate').hide().html("Current State: <font color='green'>Locked</font>").fadeIn("slow");		//if reset success show locked
				}else if(request == "status" && parseInt(arr[1]) == "3"){
					parent.jQuery('#curstate').hide().html("Current State: <font color='green'>Locked</font>").fadeIn("slow");		//if status locked show locked
				}else if(request == "status" && parseInt(arr[1]) == "4"){
					parent.jQuery('#curstate').hide().html("Current State: <font color='blue'>Unlocked</font>").fadeIn("slow");		//if status unlocked show unlocked
				}
				$('#popupcontentdiv').html(arr[0]);												//show popup
		
				
			});
		}
		
	});
			
			

});

var toast=function(msg){

	$("<div class='ui-loader ui-overlay-shadow ui-body-e ui-corner-all'><h3>"+msg+"</h3></div>")
	.css({ display: "block", 
		opacity: 0.90, 
		position: "fixed",
		padding: "7px",
		"text-align": "center",
		width: "270px",
		left: ($(window).width() - 284)/2,
		top: $(window).height()/2 })
	.appendTo( $.mobile.pageContainer ).delay( 2000 )
	.fadeOut( 400, function(){
		$(this).remove();
	});
}




