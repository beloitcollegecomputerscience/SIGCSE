$(document).ready(function() {

	registerVariables();
	registerKeyUps();

});

function registerVariables() {

	$change_password_alert_success = $("#change_password_alert_success");
	$change_password_alert_danger = $("#change_password_alert_danger");

	$login_alert_success = $("#login_alert_success");
	$login_alert_danger = $("#login_alert_danger");

	$step_one_indicator = $("#step_one_indicator");
	$step_two_indicator = $("#step_two_indicator");
	$step_three_indicator = $("#step_three_indicator");

	$step_one_indicator_2 = $("#step_one_indicator_2");
	$step_two_indicator_2 = $("#step_two_indicator_2");
	$step_three_indicator_2 = $("#step_three_indicator_2");

	$step_one = $("#step_one");
	$step_two = $("#step_two");
	$step_three = $("#step_three");

	$step_one_alert_success = $("#step_one_alert_success");
	$step_one_alert_danger = $("#step_one_alert_danger");

	$step_two_alert_success = $("#step_two_alert_success");
	$step_two_alert_danger = $("#step_two_alert_danger");

	$step_three_alert_success = $("#step_three_alert_success");
	$step_three_alert_danger = $("#step_three_alert_danger");

}

function registerKeyUps() {

	$("#top").click(function() {
		$("html, body").animate({ scrollTop: 0 }, "slow");
		return false;
	});

	$("#login_email").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#login_button").click();
	    }
	});

	$("#login_password").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#login_button").click();
	    }
	});

	$("#step_one_first_name").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#step_one_submit").click();
	    }
	});

	$("#step_one_last_name").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#step_one_submit").click();
	    }
	});

	$("#step_one_email").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#step_one_submit").click();
	    }
	});

	$("#step_one_password").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#step_one_submit").click();
	    }
	});

	$("#step_one_confirm_password").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#step_one_submit").click();
	    }
	});

	$("#step_two_first_name").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#step_two_submit").click();
	    }
	});

	$("#step_two_preferred_name").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#step_two_submit").click();
	    }
	});

	$("#step_two_last_name").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#step_two_submit").click();
	    }
	});

	$("#step_two_phone").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#step_two_submit").click();
	    }
	});

	$("#step_two_shirt_size").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#step_two_submit").click();
	    }
	});

	$("#step_two_experience").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#step_two_submit").click();
	    }
	});

	$("#step_two_school").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#step_two_submit").click();
	    }
	});

	$("#step_two_standing").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#step_two_submit").click();
	    }
	});

	$("#step_two_advisor").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#step_two_submit").click();
	    }
	});

	$("#step_two_advisor_email").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#step_two_submit").click();
	    }
	});

	$("#old_password").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#change_password_submit").click();
	    }
	});

	$("#new_password").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#change_password_submit").click();
	    }
	});

	$("#new_password_confirm").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#change_password_submit").click();
	    }
	});

}

function createError($html, $error) {
	return ($html + "<li>" + $error + "</li>");
}

function parseResponse($msg) {
	return $msg.split(',')
}

function inArray($value, $array) {
	if (jQuery.inArray($value, $array) < 0) {
		return false;
	} else {
		return true;
	}
}

function displayAlert($alert, $html) {
	$alert.html($html);
	$alert.slideDown();
}
