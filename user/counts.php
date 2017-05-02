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

//query to get all upcoming activities for the student.
$upcomingQuery = "SELECT activity_name, activity.activity_id, time_slots.start_time FROM activity, student_shifts, SIGCSE_testing.time_slots WHERE  student_shifts.student_id =" . $_SESSION ['student_id'] . " AND activity.activity_id = student_shifts.activity_id AND activity.slot_id = time_slots.slot_id GROUP BY activity_id";
$upResult = $db->query ( $upcomingQuery );
$uRow = $upResult->fetch_assoc ();
mysqli_data_seek($upResult, 0);
$numUpRows = mysqli_num_rows($upResult);

$allCountQuery = "SELECT * FROM headcounts GROUP BY act_id";
$allCountResult = $db->query ( $allCountQuery );
$numCountRows = mysqli_num_rows($allCountResult);
?>

<!-- New combined table -->
<div class="col-lg-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title" >
                <i class="fa fa-folder-open"><u style="font-size: x-large">Activities</u></i>
            </h3>
        </div>
        <div class="panel-body">

            <table class="datatable table table-striped table-bordered table-hover ">
                <thead>
                <tr>
                    <?php if($numUpRows != 0) { ?>

                    <th>activity_name<i class="fa fa-clock-o pull-right"></i></th>
                </tr>
                </thead>
                <tbody>
                <?php

                for ($i = 0; $i < $numUpRows; $i++) {

                    $row = $upResult->fetch_assoc();
                    if (is_array($row)) {

                        $rowTime = array_pop($row);
                        $rowId = array_pop($row);
                        $rowName = array_pop($row);

                        // Creates the activity row with toggler link.
                        echo "<tr><td><a href='#' class='toggler' data-row-type='" . $i . "'</a>$rowName</td></tr>";
                        // Creates the new count row
                        echo "<tr class='cat" . $i . "' style='display:none'><td>&emsp;<a data-target='#CreateCount' data-toggle='modal' data-act-Id='$rowId' data-rec-Time='$rowTime' type='button' </a>Add new count</td></tr>";
                        $printCount = 1;
                        $found = false;
                        for ($j = 0; $j < $numCountRows; $j++) {

                            $countRow = $allCountResult->fetch_assoc();
                            if ($countRow['act_id'] == $rowId) {
                                $found = true;
                                $rowStuId = array_pop($countRow);
                                $rowVal = array_pop($countRow);
                                $rowActId = array_pop($countRow);
                                $cRowTime = array_pop($countRow);

                                $countStr = $printCount . ") Students: " . $rowVal . " Recorded: " . $cRowTime . " by student " . $rowStuId;
                                $printCount++;

                                echo "<tr class='cat" . $i . "' style='display:none'><td>&emsp;<a href='#EditCount' data-toggle='modal' data-target='#EditCount' data-count-val='$rowVal' data-act-Id='$rowActId' data-rec-Time='$cRowTime' </a>$countStr</td></tr>";
                                $printCount++;
                            } elseif ($found) {
                                break;
                            }
                        }
                    }
                    mysqli_data_seek($allCountResult, 0);
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

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">x</button>
                <h4 class="modal-title">Record New Count: </h4>
            </div>

            <div class="modal-body">
                <form name="createForm" method="post" action="./php/countAdd.php">
                    <input name="actIdC" hidden id="actIdC" type="number">
                    <label for="countTimeC">Time Recorded:</label>
                    <input name="countTimeC" id="countTimeC" type="datetime">
                    <label for="countC">Attendees:</label>
                    <input name="countC" id="countC" type="number"><br>
                    <input id="submit" type="submit" class="btn btn-default">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>

        </div>

    </div>
</div>

<!-- Edit Count Modal -->
<div id="EditCount" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">x</button>
                <h4 class="modal-title">Edit Count: </h4>
            </div>

            <div class="modal-body">
                <form name="editForm" method="post" action="./php/countEdit.php">
                    <input name="actIdE" hidden id="actIdE" type="number">
                    <input name="oldTimeE" hidden id="oldTimeE" type="datetime">
                    <label for="countTimeE">Time Recorded:</label>
                    <input name="countTimeE" id="countTimeE" type="datetime">
                    <label for="countE">Attendees:</label>
                    <input name="countE" id="countE" type="number"><br>
                    <input id="submit" type="submit" class="btn btn-default">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>

        </div>

    </div>
</div>

