$(document).ready(function() {
	
	$.fn.editable.defaults.mode = 'popup';  
	
	$('#activity_note').editable({
		placement: 'right',
        url: 'php/activity_notes.php',
        title: 'enter note.',
        rows: 5
    });
	
	$.fn.editable.defaults.mode = 'inline';  
	
	$('.system_text').editable({
        url: 'php/text.php',
        title: 'Enter text.',
        rows: 5,
    });
	
});