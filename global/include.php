<?php

/*
 * This file should be included at the start of all PHP files in the system. It defines global
 * constants that are often needed.
 */

/*
 * To avoid having to use == and all checks of these logically Boolean constants,
 * I use 0 for false and 1 for true. Not perfect but works.
 */
// If true then live system, otherwise at test server at Beloit.
//define('SYSTEM_LIVE', 1); // true
 define ( 'SYSTEM_LIVE', 0 ); // false

// If true then testing which means files are located in special location on server.
 define ( 'SYSTEM_TESTING', 1 ); // true
//define('SYSTEM_TESTING', 0); // false

// If true then PHP messages are enabled. By default only on if testing.
if (SYSTEM_TESTING) {
    define ( 'SYSTEM_PHP_MSG', 1 ); // true
} else {
    define ( 'SYSTEM_PHP_MSG', 0 ); // false
}

// Where is the top level of the web system.

/*
 * Fixed time warnings, must reset every year.
 * The warning was:
 * Warning: strtotime(): It is not safe to rely on the system's timezone settings.
 * You are *required* to use the date.timezone setting or the date_default_timezone_set() function.
 * In case you used any of those methods and you are still getting this warning, you most likely misspelled
 * the timezone identifier. We selected 'America/Chicago' for 'CDT/-5.0/DST' instead in
 * /home/huss/public_html/sigcse/sigcse_testing/project/admin/schedule.php on line 60
 * Call Stack: 0.2008 627600 1. {main}() /home/huss/public_html/sigcse/sigcse_testing/project/admin/schedule.php:0 0.2180 691192 2.
 * strtotime() /home/huss/public_html/sigcse/sigcse_testing/project/admin/schedule.php:60
 */
// TODO: check correct solution to timezone.
date_default_timezone_set ( 'America/Chicago' );
// TODO: Do we want to change SYSTEM_EMAIL_ADDRESS more?
if (SYSTEM_LIVE) {
    define ( 'SYSTEM_EMAIL_ADDRESS', 'sigcse2017-volunteers@cs.vt.edu' );

    if (SYSTEM_TESTING) {
        //define ( 'SYSTEM_WEBHOME_DIR', '/ubc/cs/home/s/sig-cse/public_html/sigcse_testing/project/' );
        define ( 'SYSTEM_WEBHOME_DIR', dirname(dirname(__FILE__)));
        define ( 'SYSTEM_WEB_BASE_ADDRESS', 'https://www.cs.ubc.ca/~sig-cse/sigcse_testing/project/' );
    } else {
        //define ( 'SYSTEM_WEBHOME_DIR', '/ubc/cs/home/s/sig-cse/public_html/sigcse/' );
        define ( 'SYSTEM_WEBHOME_DIR', dirname(dirname(__FILE__)));
        define ( 'SYSTEM_WEB_BASE_ADDRESS', 'https://www.cs.ubc.ca/~sig-cse/sigcse/' );
    }
} else {
    define ( 'SYSTEM_EMAIL_ADDRESS', 'huss@beloit.edu' );

    if (SYSTEM_TESTING) {
        define ( 'SYSTEM_WEBHOME_DIR', dirname(dirname(__FILE__)));
        define('SYSTEM_WEB_BASE_ADDRESS', 'http://csserver.beloit.edu/~twomeypm/SIGCSE-live/');
    } else {
        //define ( 'SYSTEM_WEBHOME_DIR', '/home/sigcse/public_html/project/' );
        define ( 'SYSTEM_WEBHOME_DIR', dirname(dirname(__FILE__)) );
        define('SYSTEM_WEB_BASE_ADDRESS', 'http://csserver.beloit.edu/~twomeypm/SIGCSE-live/');
    }
}

define ( 'SYSTEM_EMAIL_NAME', 'SIGCSE Volunteer Coordinators' );
define ( 'SYSTEM_ADDRESS', SYSTEM_WEB_BASE_ADDRESS );
define ( 'SIGCSE_HOME_PAGE', "http://sigcse2017.sigcse.org/" );
define ( 'SIGCSE_VOL_PAGE', "http://sigcse2017.sigcse.org/info/studentvolunteers.html" );

// Make all PHP regex methods available
require_once (SYSTEM_WEBHOME_DIR . '/global/regex.php');
// require_once(SYSTEM_WEBHOME_DIR."images/nav.php");
require_once (SYSTEM_WEBHOME_DIR . '/global/mail.php');

// If PHP messages are enabled then turn them on.
if (SYSTEM_PHP_MSG) {
    // If errors not on then turn it on.
    if (! ini_get ( 'display_errors' )) {
        ini_set ( 'display_errors', '1' );
    }
}

// On the live server we need to set session information.
if (SYSTEM_LIVE) {
    /*
     * This is where session files are stored. Note that the permissions are important. The are:
     * private is 700 so no on can read
     * tmp is 755 so PHP can access to read/write
     */
    session_save_path ( SYSTEM_WEBHOME_DIR . 'global/private/tmp/' );
    // This makes PHP clear out old session data so it does not hang around.
    ini_set ( 'session.gc_probability', 1 );
}

/*
 * The connect_db.php file must be in a secure place so general users cannot access
 * the information that contains passwords for the database. The first directory should
 * be 700 to stop anyone other than us from looking at it.
 * The subdirectory with the script should be 755 so PHP can read it.
 * We put this under the same private directory that the session files are in but in a
 * different subdirectory.
 */

// Connect to DB and choose schema.
require_once (SYSTEM_WEBHOME_DIR . '/global/private/db/dbaccess.php');
$db = new DBAccess ();

define ( 'DISPLAY_TODOS', 1 ); // true
                               // define('DISPLAY_TODOS', 0); // false
function toDo($string) {
    if (DISPLAY_TODOS) {
        echo ( "<div class=\"alert alert-info\">
    <span class=\"glyphicon glyphicon-hand-right\"></span> {$string} </div>");

    }
}

// Start session. Check if user is logged in.
session_start ();

// TODO: Error checking to make sure valid student_id.
$isLoggedIn = isset ( $_SESSION ['student_id'] ) && is_numeric ( $_SESSION ['student_id'] ) ? true : false;
// Check if user is an admin.
$isAdmin = isset ( $_SESSION ['admin_id'] ) ? true : false;
// Check if user is an admin.
// if (isset($_SESSION['admin'])) {
// $isAdmin = $_SESSION['admin'] == 't' ? true : false;
// } else {
// $isAdmin = false;
// }

$page_result = $db->query ( "SELECT DISTINCT page from system_text" );
$affected_pages = mysqli_num_rows ( $page_result );
$system_text = array ();

for($i = 0; $i < $affected_pages; $i ++) {
    $page = $page_result->fetch_assoc ();
    $system_text [$page ['page']] = array ();
    $text_result = $db->query ( "SELECT * FROM system_text WHERE page = '{$page['page']}'" );
    $affected_text = mysqli_num_rows ( $text_result );
    for($j = 0; $j < $affected_text; $j ++) {
        $text = $text_result->fetch_assoc ();
        $system_text [$page ['page']] [$text ['key']] = $text ['value'];
    }
}

$variables_result = $db->query ( "SELECT * FROM system_variables" );
$affected_variables = mysqli_num_rows ( $variables_result );
$variables = array ();
for($i = 0; $i < $affected_variables; $i ++) {
    $variable = $variables_result->fetch_assoc ();
    $variables [$variable ["key"]] = $variable ["value"];
}

foreach ( $system_text as $key => $value ) {
    foreach ( $value as $key2 => $value2 ) {
        foreach ( $variables as $key3 => $value3 ) {
            $system_text [$key] [$key2] = str_replace ( $key3, $value3, $system_text [$key] [$key2] );
        }
    }
}

$mass_email_queries = array(


        "SELECT * FROM students where profile_complete = 'f';"
            => "Have not finished basic profile.",

        "SELECT * FROM students where times_complete = 'f' and profile_complete = 't';"
            => "Have not given available times.",


        "SELECT * FROM students where times_complete = 't' and profile_complete = 't';"
            => "who completely registered for sending notes",





);

?>
