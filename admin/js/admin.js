$(document).ready(function() {

	handleNewAdmin();
	handleDeleteAdmin();
	handleAdminPassword();

});

function handleDeleteAdmin() {

	$(".delete_admin").click(function() {
		admin_id = $(this).attr("admin_id");

		bootbox.confirm("Are you sure you want to delete this administrator?", function(result) {

			  if (result == true) {
				  $.ajax({
						type : "POST",
						url : "php/delete_admin.php",
						data : {
							admin_id : admin_id
						}
					}).done(function(msg) {
						console.log(msg);
						if (msg == "true") {
							setTimeout(function() {
								bootbox.alert("Admin deleted.", function() {
									location.reload();
								});
							}, 1000);

						} else if (msg == "true2") {
							bootbox.alert("Admin deleted.  Logging out.", function() {
								window.location.href = "logout.php";
							});
						}

					});
			  }
		});
	});
}

function handleAdminPassword() {

	$("#change_admin_current_password").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#change_admin_password").click();
	    }
	});

	$("#change_admin_new_password").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#change_admin_password").click();
	    }
	});

	$("#change_admin_confirm_password").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#change_admin_password").click();
	    }
	});

	$("#change_admin_password").click(function() {

		old_password = $("#change_admin_current_password").val();
		new_password = $("#change_admin_new_password").val();
		new_password_confirm = $("#change_admin_confirm_password").val();

		 $.ajax({
				type : "POST",
				url : "php/admin_password.php",
				data : {
					old_password : old_password,
					new_password : new_password,
					new_password_confirm : new_password_confirm
				}
			}).done(function(msg) {
				if (msg == "true") {
					setTimeout(function() {
						bootbox.alert("Password Changed");
						$("#change_admin_current_password").val("");
						$("#change_admin_new_password").val("");
						$("#change_admin_confirm_password").val("");
					}, 1000);

				} else {
					bootbox.alert("Error Occured");
				}

			});


	});

}

function handleNewAdmin() {

	$("#admin_email").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#new_admin").click();
	    }
	});

	$("#admin_password").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#new_admin").click();
	    }
	});

	$("#new_admin").click(function() {

		admin_email = $("#admin_email").val();
		admin_password = $("#admin_password").val();

		bootbox.confirm("Are you sure you want to create a new administrator?", function(result) {

			  if (result == true) {
				  $.ajax({
						type : "POST",
						url : "php/new_admin.php",
						data : {
							admin_email : admin_email,
							admin_password : admin_password
						}
					}).done(function(msg) {
						if (msg == "true") {
							setTimeout(function() {
								bootbox.alert("Admin created.", function() {
									location.reload();
								});
							}, 1000);

						} else {
							setTimeout(function() {
								bootbox.alert("Error. Invalid email or password.")
							}, 1000);
						}

					});
			  }
		});
	});

}
