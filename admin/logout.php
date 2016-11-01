<?php
/*
 logoutprocess.php
-----------------
Used to log out users.
*/

// Access to global variables
require_once('../global/include.php');

//session_destroy();
unset($_SESSION['admin_id']);
header('Location: '.SYSTEM_WEB_BASE_ADDRESS.'admin/login.php');
?>
