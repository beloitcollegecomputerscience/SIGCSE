$(document).ready(function() {
	
	handleLocks();

});

function handleLocks() {

	$("div[id^='lock']").on('switch-change', function(e, data) {
		lock_id = $(this).attr("lock_id");
				
		$.ajax({
			type : "POST",
			url : "php/lock.php",
			data : {
				func : "ToggleLock",
				lock_id : lock_id
			}
		}).done(function(msg) {
			// code could go here
		});

	});

}