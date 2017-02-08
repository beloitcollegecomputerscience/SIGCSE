<!-- Licensed under the BSD. See License.txt for full text.  -->

<?php
/*
    backend/timeformtwoprocess.php
    ------------------------------
    Processes information on submit of form from timeformtwo.php
        - Checks for error
        - If no errors, processes information and puts it into the database
        - If there is an error, redirects back to the same url with errors

    Notes:
        - Does this update the databse? Where? And Document lines 69 to 84. Alex isn't sure what they do.
*/

// Access to global variables
require_once('../../global/include.php');

$errno1 = false;

// Select all time slot id's
$result = $db->query("SELECT slot_id FROM time_slots WHERE student_available = 't' ORDER BY start_time");
$affected_rows = mysqli_num_rows($result);

// array to hold checked slots
$selected_slots = array();
$deselected_slots = array();

// create an array of the values posted from previous page
$posted_values = substr($_POST['posted_values'], 0, -1);
$posted_values = explode (',', $posted_values);

// loop through all slot_ids
for ($i = 0; $i < $affected_rows; $i++) {
    $row = $result->fetch_assoc();
    $slot_id = $row['slot_id'];

    // if a slot id is posted, add it to selected array, else, add it to the deselected array
    if (in_array ('ts'.$slot_id, $posted_values)) {
        array_push($selected_slots, "$slot_id");
    } else {
        array_push($deselected_slots, "$slot_id");
    }
}

// If none selected
if (sizeof($selected_slots) == 0) {
    $errno1 = true;
}

// Create a string with all the selected time slots' ids (to be used in the following query)
$values = "(";
foreach ($selected_slots as $id) {
    $values .= "$id, ";
}

$query = "SELECT (sum(time_to_sec(TS.end_time) - time_to_sec(TS.start_time)))/60 as total_minutes FROM time_slots TS WHERE TS.slot_id in ".$values;
$query = substr($query, 0, -2);
$query .= ")";

// Queries the database for the total number of minutes selected
$result = $db->query($query);
$row = $result->fetch_assoc();
$total_min = $row['total_minutes'];

if ($total_min < 720) {
    $errno1 = true;
}

// If 720 minutes of time or more was selected
if (($errno1 != true)) {

    $current_slots = array();

    // Queries the database for the student's available times
    $result = $db->query("SELECT slot_id FROM student_availability WHERE student_id = ".$_SESSION['student_id']);
    $affected_rows = mysqli_num_rows($result);
    for ($i = 0; $i < $affected_rows; $i++) {
        $row = $result->fetch_assoc();
        $slot_id = $row['slot_id'];
        array_push($current_slots, "$slot_id");
    }

    // For each deselected slot, if it is in the current_slots then delete it.
    foreach ($deselected_slots as $id) {
        if (in_array($id, $current_slots)) {
            $query = "DELETE FROM student_availability WHERE student_id = '".$_SESSION['student_id']."' and slot_id = '$id'";
            $result = $db->query($query);
        }
    }

    // For each selected slot, if it is not in the current_slots then add it.
    foreach ($selected_slots as $id) {
        if (!in_array($id, $current_slots)) {
            $query = "INSERT INTO student_availability (student_id, slot_id) VALUES (".$_SESSION['student_id'].",$id)";
            echo $query;
            $result = $db->query($query);
        }
    }

    // send to profile
    echo "true";
}

// If less than 720 minutes of time was selected
else {


    // Errors to send back
    $response = "";

    // If the following error numbers exist then they are to be added to the URL to be displayed on register.php
    if ($errno1 == true) {
        $response .= "err1,";
    }

    $response = substr($response, 0, -1);

    // Send back the appropriate errors
    echo $response;
}


?>
