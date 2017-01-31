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



    $("#forgot_button").click(function() {

        $login_alert_success.slideUp();
        $login_alert_danger.slideUp();

        $email = $("#login_email").val();

        $.ajax({
            type : "POST",
            url : "php/forgot.php",
            data : {
                email : $email
            }
        }).done(function($msg) {

            $response = parseResponse($msg);

            if (inArray("true", $response)) {

                setTimeout(function() {
                    displayAlert($login_alert_success, "A new password has been emailed to you.  Login to change.");
                }, 500);

            } else if (inArray("err1", $response)) {

                setTimeout(function() {
                    displayAlert($login_alert_danger, "Please type your email below.");
                }, 500);

            }


        });

    });


    $("#login_button").click(function() {

        $login_alert_success.slideUp();
        $login_alert_danger.slideUp();

        $email = $("#login_email").val();
        $password = $("#login_password").val();

        $.ajax({
            type : "POST",
            url : "php/login.php",
            data : {
                email : $email,
                password : $password
            }
        }).done(function($msg) {

            $response = parseResponse($msg);

            if (inArray("true", $response)) {

                setTimeout(function() {
                    displayAlert($login_alert_success, "Log in successful.  Please wait...");
                }, 500);

                setTimeout(function() {
                    window.location.href = "profile.php";
                }, 3000);

            } else if (inArray("locked", $response)) {

                setTimeout(function() {
                    displayAlert($login_alert_danger, "Log in locked.  Try again later.");
                }, 500);

            } else {

                $html = "<p>The following errors occured:</p><ul>";

                if (inArray("err1", $response)) {
                    $html = createError($html, "Invalid email.");
                }

                if (inArray("err2", $response)) {
                    $html = createError($html, "Email not in use.");
                }

                if (inArray("err3", $response)) {
                    $html = createError($html, "Invalid password.");
                }

                if (inArray("err4", $response)) {
                    $html = createError($html, "Incorrect password.");
                }

                $html = $html + "</ul>"

                setTimeout(function() {
                    displayAlert($login_alert_danger, $html);
                }, 500);
            }
        });
    });
});
