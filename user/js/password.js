/* Licensed under the BSD. See License.txt for full text.  */

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
