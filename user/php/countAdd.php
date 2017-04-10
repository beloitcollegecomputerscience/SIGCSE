<!-- Licensed under the BSD. See License.txt for full text.  -->

<?php

// Access to global variables
require_once('../../global/include.php');

// Include the head for every page
require_once(SYSTEM_WEBHOME_DIR . '/user/php/head.php');


// 1 second delay to prevent attack
sleep(1);

// Queries the database to see if login lock is on
$query = "SELECT locked FROM system_locks WHERE name = 'enter_counts'";
$result = $db->query($query);
$row = $result->fetch_assoc();
?>
<div class="col-lg-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="fa fa-folder-open"><u style="font-size: x-large">Add Count:</u></i>
            </h3>
        </div>
        <div class="panel-body">

            <?php
            // If login lock is on, send back to login page with an error
            if ($row['locked'] == 't') {
                echo "<h3>Adding counts is currently locked.</h3>";
            } else {
                $stuId = $_SESSION["student_id"];
                $actId = $_POST["actId"];
                $count = $_POST["count"];
                $countTime = '"' . $_POST["countTime"] . '"';

                $checkQuery = "SELECT * FROM counts WHERE counts.activity_id = $actId AND counts.student_id = $stuId";
                $checkResult = $db->query($checkQuery);
                $numCounts = mysqli_num_rows($checkResult);

                if ($numCounts != 0) {
                    echo "<h3>You have already submitted a count for this activity!</h3><br>";
                } else {

                    // TODO: implement database interaction here.
                    $insertQuery = "INSERT INTO counts(student_id, activity_id, record_time, headcount) VALUES ($stuId, $actId, $countTime, $count)";
                    $db->query($insertQuery);

                    echo "<h3>Added count.</h3><br>";

                }
            }

            echo "<br><button class=\"btn btn-default\" onclick=\"goBack()\">Back to Counts</button> 
                    <script>
                    function goBack() {
                        window.history.back();
                }   </script>"; ?>
        </div>
    </div>
</div>
