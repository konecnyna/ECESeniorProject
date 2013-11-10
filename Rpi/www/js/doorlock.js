

$(document).on('pageshow', function(event){
	$("#dialog-message").hide();
	

	
	//toast("boobs");

	$.get("serial.php?curstatus=true",function(data,status){
		$('#curstate').hide().html("Current State: " + data).fadeIn("slow");		
	});

    $("body").delegate('a','click', function(){
	

		if(this.id == "unlock" || this.id == "lock" || this.id == "status" || this.id == "reset")
		{
	
			$('#popupcontentdiv').html('Operation in process...<br/><img src="http://www.webdevstuff.com/wp-content/uploads/postimages/65_cube.gif" />');			
			var url = "serial.php?";
			if(this.id == "lock") url += "lock=true";
			else if (this.id == "unlock") url += "unlock=true";
			else if (this.id == "status") url += "status=true";
			else if (this.id == "reset"){
				url += "reset=true";
			}
			
			
			var arr;
			$.get(url,function(data,status){
				console.log("status: "+status);
	 		    arr = data.split("||||");

			    if(parseInt(arr[1]) == "80"){
					arr[0] = arr[0] + '	 <a href="serial.php?reset=true" data-rel="popup" id="reset">Reset?</a>';
			    }else if(parseInt(arr[1]) == "3"){
					parent.jQuery('#curstate').hide().html("Current State: <font color='green'>Locked</font>").fadeIn("slow");
				}else if(parseInt(arr[1]) == "4"){
					parent.jQuery('#curstate').hide().html("Current State: <font color='blue'>Unlocked</font>").fadeIn("slow");
				}else if(parseInt(arr[1]) == "5"){
					parent.jQuery('#curstate').hide().html("Current State: <font color='green'>Locked</font>").fadeIn("slow");
				}
				//else $('#curstate').hide().html("<font color='red'>Error communicating with AVR</font>").fadeIn('slow');
				
				$('#popupcontentdiv').html(arr[0]);
		
				
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




