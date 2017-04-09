<!-- Licensed under the BSD. See License.txt for full text.  -->

<?php

// Access to global variables
require_once('../../global/include.php');

// 1 second delay to prevent attack
sleep(1);

// Queries the database to see if login lock is on
$query = "SELECT locked FROM system_locks WHERE name = 'enter_counts'";
$result = $db->query($query);
$row = $result->fetch_assoc();

// If login lock is on, send back to login page with an error
if ($row['locked'] == 't') {
    echo "locked";
} else { echo "countAdd would attempt to add the count";}

echo "countAdd has run!";
