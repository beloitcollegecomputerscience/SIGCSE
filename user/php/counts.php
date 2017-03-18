<!-- Licensed under the BSD. See License.txt for full text.  -->

<!DOCTYPE html>
<html lang="en">
<?php

// Access to global variables
require_once ('../../global/include.php');

// Include the head for every page
require_once (SYSTEM_WEBHOME_DIR . 'user/php/head.php');

// Redirect to index if not logged in.
if (! $isLoggedIn) {
    header ( 'Location: ' . SYSTEM_WEB_BASE_ADDRESS . 'user/index.php' );
}

// Get user info from database.
$query = "SELECT * FROM students WHERE students.student_id =" . $_SESSION ['student_id'];
$result = $db->query ( $query );
$row = $result->fetch_assoc ();

// Get boolean as to if the user can enter counts
// todo: make a system lock for this
/*
$query = "SELECT locked FROM system_locks WHERE name='enter_count'";
$result = $db->query ( $query );
$lockRow = $result->fetch_assoc ();
$displayingSchedule = $lockRow ['locked'] == "t" ? false : true;

*/

$displayName = $row ['preferred_name'] == null ? $row ['first_name'] : $row ['preferred_name'];

?>
<p>Counts page. Welcome, <?php echo $displayName ?>.</p>
