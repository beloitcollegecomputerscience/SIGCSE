/* Copyright (C) 2017  Beloit College

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program (License.txt).  If not, see <http://www.gnu.org/licenses/>. */

$(document).ready(function() {

    //stepThree();


    $step_three_indicator_2.click(function() {
        var attr = $step_three_indicator_2.attr('disabled');
        if (!(typeof attr !== 'undefined' && attr !== false)) {
           stepThree();
        }
    });

    $step_two_indicator_2.click(function() {
        var attr = $step_two_indicator_2.attr('disabled');
        if (!(typeof attr !== 'undefined' && attr !== false)) {
           stepTwo();
        }
    });

    $("#step_one_submit").click(function() {

        //$("#top").click();
        $step_one_alert_success.slideUp();
        $step_one_alert_danger.slideUp();

        $.ajax({
            type : "POST",
            url : "php/register.php",
            data : {
                first_name : $("#step_one_first_name").val(),
                last_name : $("#step_one_last_name").val(),
                email : $("#step_one_email").val(),
                password : $("#step_one_password").val(),
                confirm_password : $("#step_one_confirm_password").val()
            }
        }).done(function($msg) {

            console.log

            $('html, body').animate({ scrollTop: 0 }, 'fast');
            $response = parseResponse($msg);

            if (inArray("true", $response)) {

                setTimeout(function() {
                    displayAlert($step_one_alert_success, "Thank you for registering.  Please wait...");
                }, 500);

                $("#step_two_first_name").val($("#step_one_first_name").val());
                $("#step_two_last_name").val($("#step_one_last_name").val());

                setTimeout(function() {
                    stepTwo();
                }, 3000);

            } else if (inArray("locked", $response)) {

                setTimeout(function() {
                    displayAlert($step_one_alert_danger, "Registration locked.  Try again later.");
                }, 500);

            } else {

                $html = "<p>The following errors occured:</p><ul>";

                if (inArray("err1", $response)) {
                    $html = createError($html, "Invalid first name.  Must be 2-75 characters.");
                }

                if (inArray("err2", $response)) {
                    $html = createError($html, "Invalid last name.  Must be 2-75 characters.");
                }

                if (inArray("err3", $response)) {
                    $html = createError($html, "Invalid email.");
                }

                if (inArray("err4", $response)) {
                    $html = createError($html, "Email already in use.");
                }

                if (inArray("err5", $response)) {
                    $html = createError($html, "Passwords did not match.");
                }

                if (inArray("err6", $response)) {
                    $html = createError($html, "Invalid password.  Must be 6-18 characters.");
                }

                $html = $html + "</ul>"

                setTimeout(function() {
                    displayAlert($step_one_alert_danger, $html);
                }, 500);

            }
        });
    });






/*-------------------------------------------------------
 * ----------------------------------------------
 * ------------Look here
    Here is the things done after submit in step two is cliked
 * -----------    */



    $("#step_two_submit").click(function() {


        //LOOK HERE!!------------------------------

        $("#kids_camp_result :input").each(function() {
            if ($(this).is(':checked')) {
                $kids_camp_result = $(this).val();
            }
        });



        //---------------------------------------


        //$("#top").click();
        $step_two_alert_success.html("").slideUp();
        $step_two_alert_danger.html("").slideUp();

        $.ajax({
            type : "POST",
            url : "php/personalform.php",
            data : {
                first_name : $("#step_two_first_name").val(),
                preferred_name : $("#step_two_preferred_name").val(),
                last_name : $("#step_two_last_name").val(),
                cell_phone : $("#step_two_phone").val(),
                tshirt_size : $("#step_two_shirt_size option:selected").text(),
                prior_experience : $("#step_two_experience option:selected").val(),
                school : $("#step_two_school").val(),
                standing : $("#step_two_standing option:selected").val(),
                advisor_name : $("#step_two_advisor").val(),
                advisor_email : $("#step_two_advisor_email").val(),
                // LOOK HERE:
                kids_camp_result : $kids_camp_result


            }
        }).done(function($msg) {

            $('html, body').animate({ scrollTop: 0 }, 'fast');
            $response = parseResponse($msg);

            if (inArray("true", $response)) {

                setTimeout(function() {
                    displayAlert($step_two_alert_success, "Thank you for your information.  Please wait...");
                }, 500);

                setTimeout(function() {

                    if ($("#redirect").val() == "profile") {
                        window.location.href = "profile.php";
                    } else {
                        stepThree();
                    }

                }, 3000);

            } else {

                $html = "<p>The following errors occured:</p><ul>";

                if (inArray("err1", $response)) {
                    $html = createError($html, "Invalid first name.  Must be 2-75 characters.");
                }

                if (inArray("err2", $response)) {
                    $html = createError($html, "Invalid last name.  Must be 2-75 characters.");
                }

                if (inArray("err3", $response)) {
                    $html = createError($html, "Invalid t-shirt size.");
                }

                if (inArray("err4", $response)) {
                    $html = createError($html, "Invalid prior experience.");
                }

                if (inArray("err5", $response)) {
                    $html = createError($html, "Invalid School Name.");
                }

                if (inArray("err6", $response)) {
                    $html = createError($html, "Invalid standing");
                }

                if (inArray("err7", $response)) {
                    $html = createError($html, "Invalid advisor name. Must be 2-75 characters.");
                }

                if (inArray("err8", $response)) {
                    $html = createError($html, "Invalid advisor email.");
                }

                $html = $html + "</ul>"

                setTimeout(function() {
                    displayAlert($step_two_alert_danger, $html);
                }, 500);

            }
        });
    });





    /*-------------------------------------------------------
     * ----------------------------------------------
     * ------------ENDS HERE
     * -----------    */








    $("#step_two_later").click(function() {
        stepThree();
    });

    $("#step_three_later").click(function() {
        window.location.href = "profile.php";
    });

    $("#step_three_submit").click(function() {

        console.log("hi");

        //$("#top").click();
        $step_three_alert_success.html("").slideUp();
        $step_three_alert_danger.html("").slideUp();

        $posted_values = "";
        $("#step_three :input").each(function() {
            if ($(this).is(':checked')) {
                $posted_values = $posted_values + $(this).attr("name") + ",";
            }
        });

        if ($("#step_three_status").val() == "part_one") {
            stepThreePartOne($posted_values);
        } else if ($("#step_three_status").val() == "part_two") {
            stepThreePartTwo($posted_values);
        }


    });

});

function stepThreePartTwo($posted_values) {

    $.ajax({
        type : "POST",
        url : "php/timeformtwo.php",
        data : {
            posted_values : $posted_values
        }
    }).done(function($msg) {

        $('html, body').animate({ scrollTop: 0 }, 'fast');
        $response = parseResponse($msg);

        if (inArray("true", $response)) {

            setTimeout(function() {
                displayAlert($step_three_alert_success, "Thank you for your information.  Please wait...");
                displayAlert($('#step_three_alert_success_2'), "Thank you for your information.  Please wait...");
            }, 500);

            setTimeout(function() {
                window.location.href = "profile.php";
            }, 3000);

        } else {

            $html = "<p>The following errors occured:</p><ul>";

            if (inArray("err1", $response)) {
                $html = createError($html, "Need to select more time.");
            }

            $html = $html + "</ul>"

            setTimeout(function() {
                displayAlert($step_three_alert_danger, $html);
                displayAlert($('#step_three_alert_danger_2'), $html);
            }, 500);

        }

    });


}

function stepThreePartOne($posted_values) {

    console.log($posted_values);

    $.ajax({
        type : "POST",
        url : "php/timeformone.php",
        data : {
            posted_values : $posted_values
        }
    }).done(function($msg) {

        $('html, body').animate({ scrollTop: 0 }, 'fast');
        $response = parseResponse($msg);

        if (inArray("true", $response)) {

            $("#step_three_status").val("part_two");

            setTimeout(function() {
                displayAlert($step_three_alert_success, "Thank you for your information.  Please wait...");
            }, 500);

            setTimeout(function() {

                $two_values = parseResponse($posted_values);
                $first = $two_values[0];
                $second = $two_values[1];

                $inbetween = false;
                $("#step_three :checkbox").each(function() {

                    $name = $(this).attr("name");


                    if ($name == $first) {
                        $inbetween = true;
                    }

                    if (!$inbetween) {
                        $(this).prop('disabled', true);
                        $(this).parent("p").wrap("<strike>");
                    }

                    if ($name == $second) {
                        $inbetween = false;
                    }

                    if ($inbetween) {
                        $(this).prop("checked",true);
                    }
                });

                $step_three_alert_success.html("").slideUp();
                $step_three_alert_danger.html("").slideUp();
                $("#step_three_part_one_inst").slideUp();
                $("#step_three_part_two_inst").slideDown();

            }, 5000);

        } else {

            $html = "<p>The following errors occured:</p><ul>";

            if (inArray("err1", $response)) {
                $html = createError($html, "Only select two time slots.");
            }

            if (inArray("err2", $response)) {
                $html = createError($html, "Not enough time in between time slots selected.");
            }

            $html = $html + "</ul>"

            setTimeout(function() {
                displayAlert($step_three_alert_danger, $html);
            }, 500);

        }

    });

}

function stepTwo() {
    $step_one.slideUp();
    $step_two.slideDown();
    $step_three.slideUp();
    $('#step_three_2').slideUp();
    makeStepActive($step_two_indicator);

    $step_two_indicator_2.removeAttr("disabled");
    $step_three_indicator_2.removeAttr("disabled");

    $step_one_indicator_2.removeClass("btn-primary");
    $step_one_indicator_2.addClass("btn-default");

    $step_three_indicator_2.removeClass("btn-primary");
    $step_three_indicator_2.addClass("btn-default");

    $step_two_indicator_2.removeClass("btn-default");
    $step_two_indicator_2.addClass("btn-primary");

}

function stepOne() {
    $step_one.slideDown();
    $step_two.slideUp();
    $step_three.slideUp();
    makeStepActive($step_one_indicator);
}

function stepThree() {
    $step_one.slideUp();
    $step_two.slideUp();
    $step_three.slideDown();
    $('#step_three_2').slideDown();
    makeStepActive($step_three_indicator);

    $step_two_indicator_2.removeAttr("disabled");
    $step_three_indicator_2.removeAttr("disabled");

    $step_three_indicator_2.removeClass("btn-default");
    $step_three_indicator_2.addClass("btn-primary");

    $step_two_indicator_2.removeClass("btn-primary");
    $step_two_indicator_2.addClass("btn-default");

    $step_one_indicator_2.removeClass("btn-primary");
    $step_one_indicator_2.addClass("btn-default");

}

function makeStepActive($step) {

    $step_one_indicator.removeClass("label-primary");
    $step_two_indicator.removeClass("label-primary");
    $step_three_indicator.removeClass("label-primary");
    $step.addClass("label-primary");

}
