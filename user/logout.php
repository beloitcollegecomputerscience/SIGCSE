<!-- Licensed under the BSD. See License.txt for full text.  -->

<?php
/*
 logoutprocess.php
-----------------
Used to log out users.
*/

// Access to global variables
require_once('../global/include.php');

//session_destroy();
unset($_SESSION['student_id']);
header('Location: '.SYSTEM_WEB_BASE_ADDRESS.'user/profile.php');
?>
