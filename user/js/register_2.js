/* Licensed under the BSD. See License.txt for full text.  */

$(document).ready(function() {

    // If Do later is ever pressed send to profile
    $("#step_three_later_2").click(function() {
        window.location.href = "profile.php";
    });

    $("#step_three_submit_2_2").click(function() {

        $("#step_three_alert_success_2").html("").slideUp();
        $("#step_three_alert_danger_2").html("").slideUp();

        $posted_values = "";
        $("#checkbox_input :input").each(function() {
            if ($(this).is(':checked')) {
                $posted_values = $posted_values + $(this).attr("name") + ",";
            }
        });

        stepThreePartTwo($posted_values);

    });

    // Handle submits
    $("#step_three_submit_2").click(function() {

        // Scroll to top
        $('html, body').animate({ scrollTop: 0 }, 'fast');

        // Reset alerts
        $("#step_three_alert_success_2").html("").slideUp();
        $("#step_three_alert_danger_2").html("").slideUp();

        // Get all values selected
        $posted_values = "";
        $("#radio_input :input").each(function() {
            if ($(this).is(':checked')) {
                $posted_values = $posted_values + $(this).val() + ",";
            }
        });

        // Send to appropriate area
        $status = $("#step_three_status_2").val();
        if ($status == "part_one") {
            stepThreePartOne_2($posted_values);

        } else if ($status == "part_two") {
            stepThreePartTwo_3($posted_values);

        }

    });

});

function stepThreePartTwo_3($posted_values) {

    // Get slot_id out of junk
    $slot_id = $posted_values.split(',')[0];

    // POST slot_id to PHP
    $.ajax({
        type : "POST",
        url : "php/timeformone_2.php",
        data : {
            slot_id : $slot_id
        }
    }).done(function($msg) {

        // Get results from POST
        $response = parseResponse($msg);

        // If success
        if (inArray("true", $response)) {

            // Set status to two
            $("#step_three_status_2").val("part_three");

            // Display success message to user
            setTimeout(function() {
                displayAlert($("#step_three_alert_success_2"), "Thank you for your information.  Please wait...");
            }, 500);

            setTimeout(function() {

                $("#step_three_departure").val($slot_id);

                $inbetween = false;
                $("#checkbox_input :input").each(function() {

                    if ($(this).attr("type") == "checkbox") {

                        if ($(this).attr("name") == ("ts" + $("#step_three_arrival").val())) {
                            $inbetween = true;
                        }

                        if ($inbetween) {
                            $(this).prop("checked", true);
                        } else {
                            $(this).parent("p").wrap("<strike>");
                            $(this).prop('disabled', true);
                        }

                        if ($(this).attr("name") == ("ts" + $("#step_three_departure").val())) {
                            $inbetween = false;
                        }

                    }

                });


                // Reset warnings and show step_two instructions
                $("#step_three_alert_success_2").html("").slideUp();
                $("#step_three_alert_danger_2").html("").slideUp();
                $("#step_three_part_two_inst_2").slideUp();
                $("#step_three_part_three_inst_2").slideDown();

                $("#radio_input").slideUp();
                $("#checkbox_input").slideDown();

            }, 3000);
        } else {

            $html = "<p>The following errors occured:</p><ul>";

            if (inArray("err1", $response)) {
                $html = createError($html, "Not enough time between first and last time slot.");
            }

            if (inArray("err2", $response)) {
                $html = createError($html, "Not enough time in between time slots selected.");
            }

            $html = $html + "</ul>"

            setTimeout(function() {
                displayAlert($('#step_three_alert_danger_2'), $html);
            }, 500);

        }

    });

}

// Function to set arrival time slot
function stepThreePartOne_2($posted_values) {

    // Get slot_id out of junk
    $slot_id = $posted_values.split(',')[0];

    // POST slot_id to PHP
    $.ajax({
        type : "POST",
        url : "php/arrival.php",
        data : {
            slot_id : $slot_id
        }
    }).done(function($msg) {

        // Get results from POST
        $response = parseResponse($msg);

        // If success
        if (inArray("true", $response)) {

            // Set status to two
            $("#step_three_status_2").val("part_two");

            // Display success message to user
            setTimeout(function() {
                displayAlert($("#step_three_alert_success_2"), "Thank you for your information.  Please wait...");
            }, 500);

            setTimeout(function() {

                // Strikout/Disable time slots before and including arrival slot.
                $before = true;
                $("#radio_input :input").each(function() {

                    $(this).prop("checked", false);
                    if ($before) {
                        $(this).prop('disabled', true);
                        $(this).parent("label").wrap("<strike>");
                    }
                    if ($slot_id == $(this).val()) {
                        $before = false;
                    }
                });

                // Reset warnings and show step_two instructions
                $("#step_three_alert_success_2").html("").slideUp();
                $("#step_three_alert_danger_2").html("").slideUp();
                $("#step_three_part_one_inst_2").slideUp();
                $("#step_three_part_two_inst_2").slideDown();

                $("#step_three_arrival").val($slot_id);

            }, 3000);


        // If failure
        } else if (inArray("false", $response)) {


            $html = "<p>The following errors occured:</p><ul>";

            if (inArray("err1", $response)) {
                $html = createError($html, "Please mark a time slot.");
            }

            $html = $html + "</ul>"

            setTimeout(function() {
                displayAlert($('#step_three_alert_danger_2'), $html);
            }, 500);
        }
    });
}
