/* Licensed under the BSD. See License.txt for full text.  */

$(document).ready(function() {

	$('#CreateCount').on('show.bs.modal', function(e) {

		//get data-id attribute of the clicked element
		var actId = $(e.relatedTarget).data('act-id');
		var actTime = $(e.relatedTarget).data('act-datetime');

		//populate the textbox
		$(e.currentTarget).find('input[name="actId"]').val(actId);
		$(e.currentTarget).find('input[name="countTime"]').val(actTime);
	});

});