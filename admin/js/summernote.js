$(document).ready(function() {
  $('#summernote').summernote();


  $("#send_student_email").click(function() {

	  student_id = $(this).attr("student_id");
	  message = $('#summernote').code();

	  bootbox.confirm("Are you sure you want to send this email?", function(result) {

		  if (result == true) {
			  $.ajax({
					type : "POST",
					url : "php/email_volunteer.php",
					data : {
						message : message,
						student_id : student_id
					}
				}).done(function(msg) {

					if (msg == "") {
						setTimeout(function() {
							bootbox.alert("Message sent successfully");
						}, 1000);

					}

				});
		  }

		});

	});


});
