/* Licensed under the BSD. See License.txt for full text.  */

$(document).ready(function() {

	$('#createCount').on('show.bs.modal', function(e) {

		//get data-id attribute of the clicked element
		var actId = $(e.relatedTarget).data('act-id');
		var actName = $(e.relatedTarget).data('act-name');

		//populate the textbox
		$(e.currentTarget).find('input[name="actId"]').val(actId);
	});

});