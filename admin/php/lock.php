<!-- Licensed under the BSD. See License.txt for full text.  -->

<?php

// Access to global variables
require_once('../../global/include.php');

// Used to define which button the user has clicked
$func = $_POST['func'];

// Based on what the user clicked, will direct the path of the switch
switch ($func) {
    case "ToggleLock":
        toggleLock($db, $_POST['lock_id']);
        break;
}

function toggleLock($db, $lock_id) {

    // Get current info on lock
    $result = $db->query("SELECT * FROM system_locks WHERE system_lock_id = $lock_id;");
    $row = $result->fetch_assoc();
    //TODO what if lock not valid?
    $oldAtt = $row['locked'];

    // Toggle lock value
    $newAtt = $oldAtt == "t" ? "f" : "t";

    // Update the new value and send back to index
    $query = "UPDATE system_locks SET locked='$newAtt' WHERE system_lock_id='$lock_id'";
    $db->query($query);

}

?>
