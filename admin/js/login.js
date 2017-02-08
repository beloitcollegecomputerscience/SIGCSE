/* Licensed under the BSD. See License.txt for full text.  */


$(document).ready(function() {

    $admin_login_alert_success = $("#admin_login_alert_success");
    $admin_login_alert_danger = $("#admin_login_alert_danger");
    $admin_login_submit = $("#admin_login_submit");

    $admin_login_submit.click(function() {

        $admin_login_alert_success.slideUp();
        $admin_login_alert_danger.slideUp();

        $.ajax({
            type : "POST",
            url : "php/login.php",
            data : {
                email : $("#admin_email").val(),
                password : $("#admin_password").val()
            }
        }).done(function($msg) {

            if ($msg == "true") {
                setTimeout(function() {
                    $admin_login_alert_success.html("Success");
                    $admin_login_alert_success.slideDown();
                }, 500);

                setTimeout(function() {
                    window.location.href = "index.php";
                }, 3000);

            } else if ($msg == "false") {
                setTimeout(function() {
                    $admin_login_alert_danger.html("Failure");
                    $admin_login_alert_danger.slideDown();
                }, 500);
            }
        });
    });

    $("#admin_email").keyup(function(event){
        if(event.keyCode == 13){
            $admin_login_submit.click();
        }
    });

    $("#admin_password").keyup(function(event){
        if(event.keyCode == 13){
            $admin_login_submit.click();
        }
    });

});
