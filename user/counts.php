<!-- Licensed under the BSD. See License.txt for full text.  -->

<!DOCTYPE html>
<html lang="en">
<?php

// Access to global variables
require_once('../global/include.php');

// Include the head for every page
require_once (SYSTEM_WEBHOME_DIR . '/user/php/head.php');

// Redirect to index if not logged in.
if (! $isLoggedIn) {
    header ( 'Location: ' . SYSTEM_WEB_BASE_ADDRESS . 'user/index.php' );
}

require(SYSTEM_WEBHOME_DIR."/user/php/nav.php"); echoNav($system_text, $db, $isLoggedIn, $isAdmin, "profile");




// Get boolean as to if the user can enter counts
// todo: make a system lock for this
/*
$query = "SELECT locked FROM system_locks WHERE name='enter_count'";
$result = $db->query ( $query );
$lockRow = $result->fetch_assoc ();
$displayingSchedule = $lockRow ['locked'] == "t" ? false : true;

*/


// Get counts for activities the user is scheduled for.
$countQuery = "SELECT activity.activity_name, headcounts.record_time, headcounts.count_val, headcounts.stu_id, time_slots.start_time FROM student_shifts, headcounts, SIGCSE_testing.activity, SIGCSE_testing.time_slots WHERE student_shifts.student_id =" . $_SESSION ['student_id'] . " AND student_shifts.activity_id = activity.activity_id AND activity.activity_id = headcounts.act_id AND activity.slot_id = time_slots.slot_id";
$countResult = $db->query ( $countQuery );
$cRow = $countResult->fetch_assoc ();
mysqli_data_seek($countResult, 0);
$numCountRows = mysqli_num_rows($countResult);
?>

<div class="col-lg-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title" >
                <i class="fa fa-folder-open"><u style="font-size: x-large">Headcounts</u></i>
            </h3>
        </div>
        <div class="panel-body">

            <table class="datatable table table-striped table-bordered table-hover ">
                <thead>
                <tr>
                    <?php
                    if($numCountRows != 0) {
                        foreach ($cRow as $key2 => $value2) {

                            if ($key2 != 'start_time') {
                            ?>
                            <th><?php echo $key2; ?><i class="fa fa-clock-o pull-right"></i></th>
                            <?php
                        }
                        }
                    }
                    ?>



                </tr>
                </thead>
                <tbody>
                <?php

                for ($i = 0; $i < $numCountRows; $i++) {

                    $row = $countResult->fetch_assoc();

                    echo "<tr>";

                    if (is_array($row)) {
                        $oldTime = array_pop($row);
                        $rowId = array_pop($row);
                        $rowVal = array_pop($row);
                        $rowTime = array_pop($row);
                        $rowName = array_pop($row);

                        echo "<td>" . $rowName . "</td>";

                        echo "<td>$rowTime</td>";
                        echo "<td>$rowVal</td>";
                        echo "<td>$rowId</td>";

                    }
                    echo "</tr>";
                } ?>

                </tbody>
            </table>
        </div>

    </div>
</div>

<?php
//query to get all upcoming activities for the student that don't have counts.
$upcomingQuery = "SELECT activity_name, activity.activity_id, time_slots.start_time FROM activity, student_shifts, SIGCSE_testing.time_slots WHERE activity.activity_id NOT IN (SELECT act_id from headcounts) AND student_shifts.student_id =" . $_SESSION ['student_id'] . " AND activity.activity_id = student_shifts.activity_id AND activity.slot_id = time_slots.slot_id";
$upResult = $db->query ( $upcomingQuery );
$uRow = $upResult->fetch_assoc ();
mysqli_data_seek($upResult, 0);
$numUpRows = mysqli_num_rows($upResult);
?>

<!-- New counts table -->
<div class="col-lg-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title" >
                <i class="fa fa-folder-open"><u style="font-size: x-large">Upcoming Activities</u></i>
            </h3>
        </div>
        <div class="panel-body">

            <table class="datatable table table-striped table-bordered table-hover ">
                <thead>
                <tr>
                    <?php
                    if($numUpRows != 0) {
                    foreach ($uRow as $key2 => $value2) {

                        if ($key2 == 'activity_name') {
                            ?>
                            <th><?php echo $key2; ?><i class="fa fa-clock-o pull-right"></i></th>
                            <?php
                        }
                    } ?>
                    <?php

                    ?>


                </tr>
                </thead>
                <tbody>
                <?php


                for ($i = 0; $i < $numUpRows; $i++) {

                    $row = $upResult->fetch_assoc();

                    echo "<tr>";


                    if (is_array($row)) {
                        $rowTime = array_pop($row);
                        $rowId = array_pop($row);
                        $rowName = array_pop($row);

                        echo "<td><a data-toggle='modal' data-target='#CreateCount' data-act-dateTime='" . $rowTime . "' data-act-name='" . $rowName . "' data-act-id='" . $rowId . "'>" . $rowName . "</a></td>";
                    }
                    echo "</tr>";
                }
                }?>

                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- Create Count Modal -->
<div id="CreateCount" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Enter New Count: </h4>
            </div>

            <div class="modal-body">
                <form method="post" action="./php/countAdd.php">
                    <input name="actId" hidden id="actId" type="number">
                    <label for="countTime">Time Recorded:</label>
                    <input name="countTime" id="countTime" type="datetime">
                    <label for="count">Attendees:</label>
                    <input name="count" id="count" type="number"><br>
                    <input id="submit" type="submit" class="btn btn-default">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>

        </div>

    </div>
</div>
