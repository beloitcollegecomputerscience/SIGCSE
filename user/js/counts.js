/* Licensed under the BSD. See License.txt for full text.  */

$(document).ready(function() {

	$('#CreateCount').on('show.bs.modal', function(e) {

		//get data-id attribute of the clicked element
		// For some reason these aren't getting the info right
		var actId = $(e.relatedTarget).data('act-Id');
		var actTime = $(e.relatedTarget).data('rec-Time');
		//populate the textbox
		$(e.currentTarget).find('input[name="actIdC"]').val(actId);
		$(e.currentTarget).find('input[name="countTimeC"]').val(actTime);
	});

	$('#EditCount').on('show.bs.modal', function(e) {

		//get data-id attribute of the clicked element
		var actId = $(e.relatedTarget).data('act-Id');
		var actTime = $(e.relatedTarget).data('rec-Time');
		var val = $(e.relatedTarget).data('count-val');
		//populate the textbox
		$(e.currentTarget).find('input#actIdE').val(actId);
		$(e.currentTarget).find('input#countTimeE').val(actTime);
		$(e.currentTarget).find('input#oldTimeE').val(actTime);
		$(e.currentTarget).find('input#countE').val(val);
	});

	$(".toggler").click(function(e){
		e.preventDefault();
		$('.cat'+$(this).attr('data-row-type')).toggle();
	});

});

