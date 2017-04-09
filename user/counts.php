<!-- Licensed under the BSD. See License.txt for full text.  -->

<!DOCTYPE html>
<html lang="en">
<?php

// Access to global variables
require_once('../global/include.php');

// Include the head for every page
require_once (SYSTEM_WEBHOME_DIR . 'user/php/head.php');

// Redirect to index if not logged in.
if (! $isLoggedIn) {
    header ( 'Location: ' . SYSTEM_WEB_BASE_ADDRESS . 'user/index.php' );
}

// Get user info from database. This may not be necessary
$query = "SELECT * FROM students WHERE students.student_id =" . $_SESSION ['student_id'];
$result = $db->query ( $query );
$row = $result->fetch_assoc ();
$numUserRow = mysqli_num_rows($result);


// Get user's counts
$countQuery = "SELECT * FROM counts WHERE counts.student_id =" . $_SESSION ['student_id'];
$countResult = $db->query ( $countQuery );
$cRow = $countResult->fetch_assoc ();
mysqli_data_seek($countResult, 0);
$numCountRows = mysqli_num_rows($countResult);


// Get boolean as to if the user can enter counts
// todo: make a system lock for this
/*
$query = "SELECT locked FROM system_locks WHERE name='enter_count'";
$result = $db->query ( $query );
$lockRow = $result->fetch_assoc ();
$displayingSchedule = $lockRow ['locked'] == "t" ? false : true;

*/

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


                            ?>
                            <th><?php echo $key2; ?><i class="fa fa-clock-o pull-right"></i></th>
                            <?php
                        }
                    }
                    ?>



                </tr>
                </thead>
                <tbody>
                <?php

                //Iterate through
                for ($i = 0; $i < $numCountRows; $i++) {

                    $row = $countResult->fetch_assoc();

                    echo "<tr>";

                    // TODO: make link to either a user-visible activity, a display for the count, or something useful

                    if (is_array($row)) {
                        foreach ($row as $value) {
                             echo "<td>$value</td>";
                        }
                    } else echo "<td>$row</td>";

                    echo "</tr>";
                } ?>

                </tbody>
            </table>
        </div>

    </div>
</div>

<?php
//query to get all upcoming activities for the student
$upcomingQuery = "SELECT activity_name FROM activity, student_shifts WHERE student_shifts.student_id =" . $_SESSION ['student_id'] . " AND activity.activity_id = student_shifts.activity_id";
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


                            ?>
                            <th><?php echo $key2; ?><i class="fa fa-clock-o pull-right"></i></th>
                            <?php
                        } ?>
                        <th>Counts</th>
                    <?php
                    }
                    ?>


                </tr>
                </thead>
                <tbody>
                <?php

                for ($i = 0; $i < $numUpRows; $i++) {

                    $row = $upResult->fetch_assoc();

                    echo "<tr>";


                    if (is_array($row)) {
                        foreach ($row as $value) {
                                echo "<td>$value</td> <td></td>";
                        }
                        // TODO: make this button change after a count is entered.
                        ?>
                        <!-- This creates the submit count dialog -->
                        <?php
                    } else echo "<td>$row</td>";

                    echo "</tr>";
                } ?>

                </tbody>
            </table>
        </div>

    </div>
</div>


<!-- Modal -->
<div id="createCount" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Enter New Count</h4>
            </div>
            <div class="modal-body">
                <p>Entry fields go here, auto-populate what you can.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>

    </div>
</div>