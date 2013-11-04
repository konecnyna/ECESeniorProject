$(document).on('pageshow', function(event){
	$("#dialog-message").hide();

$.get("serial.php?curstatus=true",function(data,status){
	
	$('#curstate').hide().html("Current State: " + data).fadeIn("slow");		
});
    $("a").click(function(){
	
		if(this.id == "unlock" || this.id == "lock" || this.id == "status")
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
			    }
				$('#popupcontentdiv').html(arr[0]);

				
			});
		}
		
	});
			
			

});
