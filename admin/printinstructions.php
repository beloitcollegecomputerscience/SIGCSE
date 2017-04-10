<!-- Licensed under the BSD. See License.txt for full text.  -->

<?php
// The global include file
require_once ('../global/include.php');

// Function to create an instruction.
require_once (SYSTEM_WEBHOME_DIR . '/user/php/assemble.php');

// Start session and check if user is logged in
if (! $isAdmin) {
    header ( 'Location: ' . SYSTEM_WEB_BASE_ADDRESS . 'admin/login.php' );
}

// Queries the database for the activity's information
$query = "SELECT A.activity_id
        FROM activity A, time_slots TS, rooms R
        WHERE A.room_id = R.room_id
        AND A.slot_id = TS.slot_id
        ORDER BY TS.start_time";

// Loop through all activities
$result = $db->query ( $query );
$affected_time_slots = mysqli_num_rows ( $result );
for($i = 0; $i < $affected_time_slots; $i ++) {
    $row = $result->fetch_assoc ();
    $activity_id = $row ['activity_id'];

    // Queries the database for the all student's scheduled to work for that activity.
    $query2 = "SELECT S.student_id
    FROM students S, student_shifts SS, activity A
    WHERE S.student_id = SS.student_id
    AND SS.activity_id = A.activity_id
    AND A.activity_id = $activity_id";

    // Loop through all students scheduled for given activity
    $result2 = $db->query ( $query2 );
    $affected_time_slots2 = mysqli_num_rows ( $result2 );
    for($i2 = 0; $i2 < $affected_time_slots2; $i2 ++) {
        $row2 = $result2->fetch_assoc ();
        $student_id = $row2 ['student_id'];
        $instruction = assembleInstruction ( $db, $activity_id, $student_id, $isAdmin );
        echo $instruction;

        echo '<html>
                <head>
                <STYLE TYPE="text/css"> P.pagebreakhere {page-break-before: always} </STYLE>
                </head>
                <body>
                <P CLASS="pagebreakhere">';
    }
}

?>
