<!-- Copyright (C) 2017  Beloit College

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program (License.txt).  If not, see <http://www.gnu.org/licenses/>. -->

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
