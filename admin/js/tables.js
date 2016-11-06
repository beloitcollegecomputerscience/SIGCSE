$(document).ready(function() {
	$(document).ready(function() {
		$('.datatable').dataTable({
			"sPaginationType": "bs_full"
		});	
		$('.datatable').each(function(){
			var datatable = $(this);
			// SEARCH - Add the placeholder for Search and Turn this into in-line form control
			var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
			search_input.attr('placeholder', 'Search');
			search_input.addClass('form-control input-sm');
			// LENGTH - Inline-Form control
			var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
			length_sel.addClass('form-control input-sm');
		});
	});

});
/* borrowed from schedule.js, possibly adapt to make query tables collapsible?
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
	
});*/