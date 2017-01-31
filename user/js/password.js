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

    $("#change_password_submit").click(function() {

        $change_password_alert_success.slideUp();
        $change_password_alert_danger.slideUp();

        $.ajax({
            type : "POST",
            url : "php/password.php",
            data : {
                old_password : $("#old_password").val(),
                new_password : $("#new_password").val(),
                new_password_confirm : $("#new_password_confirm").val()
            }
        }).done(function($msg) {

            $response = parseResponse($msg);

            if (inArray("true", $response)) {

                setTimeout(function() {
                    displayAlert($change_password_alert_success, "Password change successful.");
                }, 500);

                setTimeout(function() {
                    window.location.href = "profile.php";
                }, 3000);

            } else {

                $html = "<p>The following errors occured:</p><ul>";

                if (inArray("err1", $response)) {
                    $html = createError($html, "Invalid current password.");
                }

                if (inArray("err2", $response)) {
                    $html = createError($html, "Passwords do not match");
                }

                if (inArray("err3", $response)) {
                    $html = createError($html, "Invalid new password.");
                }

                $html = $html + "</ul>";

                setTimeout(function() {
                    displayAlert($change_password_alert_danger, $html);
                }, 500);
            }
        });
    });
});
