/* Licensed under the BSD. See License.txt for full text.  */

$(document).ready(function() {

	$('#CreateCount').on('show.bs.modal', function(e) {

		//get data-id attribute of the clicked element
		var actId = $(e.relatedTarget).data('actId');
		var actTime = $(e.relatedTarget).data('recTime');
		//populate the textbox
		$(e.currentTarget).find('input[name="actIdC"]').val(actId);
		$(e.currentTarget).find('input[name="countTimeC"]').val(actTime);
	});

	$('#EditCount').on('show.bs.modal', function(e) {

		//get data-id attribute of the clicked element
		var actId = $(e.relatedTarget).data('actId');
		var actTime = $(e.relatedTarget).data('recTime');

		alert($(e.relatedTarget).toString());
		//populate the textbox
		$(e.currentTarget).find('input#actIdE').val(actId);
		$(e.currentTarget).find('input#countTimeE').val(actTime);
		$(e.currentTarget).find('input #oldTimeE').val(actTime);
	});

	$(".toggler").click(function(e){
		e.preventDefault();
		$('.cat'+$(this).attr('data-row-type')).toggle();
	});

});
//
// $(document).on("click", ".countCreate", function () {
// 	var id = $(this).data('actId');
// 	var time = $(this).data('recTime');
// 	$(".modal-body #countTimeC").val( time );
// 	$(".modal-body #actIdC").val( id );
// });
//


