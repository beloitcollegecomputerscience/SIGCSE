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
            // If login lock is on, send back to login page with an error.
            if ($row['locked'] == 't') {
                echo "<h3>Adding counts is currently locked.</h3>";
            } else {
                $stuId = $_SESSION["student_id"];
                $actId = $_POST["actIdC"];
                $count = $_POST["countC"];
                $countTime = '"' . $_POST["countTimeC"] . '"';

                $insertQuery = "INSERT INTO headcounts(record_time, act_id, count_val, stu_id) VALUES ($countTime, $actId, $count, $stuId)";
                $db->query($insertQuery);
                echo "<h3>Added count.</h3><br>";
            }

            echo "<br> <button class='btn btn-default' onclick='goBack()'>Back to Counts</button> 
                    <script> function goBack() { window.history.back(); } </script>";
            ?>
        </div>
    </div>
</div>
