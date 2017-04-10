<!-- Licensed under the BSD. See License.txt for full text.  -->

<!DOCTYPE html>
<html>

<?php

// Access to global variables
require_once('../global/include.php');

// Include the head for every page
require_once(SYSTEM_WEBHOME_DIR.'/admin/php/head.php');

?>

<style type="text/css">
body {
    padding-top: 40px;
    padding-bottom: 40px;
    background-color: #eee;
}

.form-signin {
    max-width: 330px;
    padding: 15px;
    margin: 0 auto;
}

.form-signin .form-signin-heading,.form-signin .checkbox {
    margin-bottom: 10px;
}

.form-signin .checkbox {
    font-weight: normal;
}

.form-signin .form-control {
    position: relative;
    font-size: 16px;
    height: auto;
    padding: 10px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

.form-signin .form-control:focus {
    z-index: 2;
}

.form-signin input[type="text"] {
    margin-bottom: -1px;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}

.form-signin input[type="password"] {
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}

</style>


<body>

    <div class="container">

        <div id="admin_login_alert_success"
            class="alert alert-success col-lg-2 col-lg-offset-5"></div>
        <div id="admin_login_alert_danger"
            class="alert alert-danger col-lg-2 col-lg-offset-5"></div>
        <script type="text/javascript"> $("#admin_login_alert_success").hide(); </script>
        <script type="text/javascript"> $("#admin_login_alert_danger").hide(); </script>

        <form class="form-signin">
            <h2 class="form-signin-heading">SIGCSE Admin</h2>
            <input id="admin_email" type="text" class="form-control"
                placeholder="Email address" required autofocus> <input
                id="admin_password" type="password" class="form-control"
                placeholder="Password">
            <button id="admin_login_submit"
                class="btn btn-lg btn-primary btn-block" type="button">Sign in</button>
        </form>

    </div>
    <!-- /container -->



</body>
</html>
