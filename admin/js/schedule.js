$(document).ready(function() {
	
	 $(".day_toggle").click(function() {
		
		 
		 date = $(this).attr("date");
		 display = "#" + date + "_display"
		 status = $(display).attr("status");
		 		 
		 if (status == "expended") {
			 $(display).slideUp();
			 $(display).attr("status","closed");
			 $(this).children().removeClass("fa-minus");
			 $(this).children().addClass("fa-plus");
			 
		 } else if (status == "closed") {
			 $(display).slideDown();
			 $(display).attr("status","expended");
			 $(this).children().removeClass("fa-plus");
			 $(this).children().addClass("fa-minus");
		 }
		 
		 
	 });
	
});