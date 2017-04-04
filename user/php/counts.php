<!-- Licensed under the BSD. See License.txt for full text.  -->

<!DOCTYPE html>
<html lang="en">
<?php

// Access to global variables
require_once ('../../global/include.php');

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
$numCountRows = mysqli_num_rows($countResult);


// Get boolean as to if the user can enter counts
// todo: make a system lock for this
/*
$query = "SELECT locked FROM system_locks WHERE name='enter_count'";
$result = $db->query ( $query );
$lockRow = $result->fetch_assoc ();
$displayingSchedule = $lockRow ['locked'] == "t" ? false : true;

*/

$displayName = $row ['preferred_name'] == null ? $row ['first_name'] : $row ['preferred_name'];

?>
<p>Counts page. Welcome, <?php echo $displayName ?>.</p>

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
                            <th><?php echo $key2; ?><i class="fa fa-plus pull-right"></i></th>
                            <?php
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
                        foreach ($row as $value) {
                            echo "<td>$value</td>";
                        }
                    }

                    echo "</tr>";
                } ?>

                </tbody>
            </table>
        </div>

    </div>
</div>
<!-- This is here for reference on how the paginating tables are created.

<div class="col-lg-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="fa fa-folder-open"></i>

            </h3>
        </div>
        <div class="panel-body">
            <?php/*

            $result2 = $db->query($query);
            $row2 = $result2->fetch_assoc();

            ?>

            <table class="datatable table table-striped table-bordered table-hover ">
                <thead>
                <tr>
                    <?php
                    if($numCountRows != 0) {
                        foreach ($row2 as $key2 => $value2) {


                            ?>
                            <th><?php echo $key2; ?><i class="fa fa-plus pull-right"></i></th>
                            <?php
                        }
                    }
                    ?>



                </tr>
                </thead>
                <tbody>
                <?php

                $result = $db->query($query);
                $affected_rows = mysqli_num_rows($result);

                if($stuclick && $affected_rows != 0){

                    for ($i = 0; $i < $affected_rows; $i++) {

                        $row = $result->fetch_assoc();

                        if(array_key_exists ( "email" , $row )){$stu_key_to_use="email";}
                        else if(array_key_exists ( "student_id" , $row )){$stu_key_to_use="student_id";}
                        $stu_link_query="select * from students where $stu_key_to_use = '$row[$stu_key_to_use]';";
                        $stu_link_result = $db->query($stu_link_query);
                        $stu_link_row = $stu_link_result->fetch_assoc();
                        $stu_link_id=$stu_link_row['student_id'];
                        echo "<tr>";
                        if (is_array($row)) {

                            foreach ($row as $value) {
                                echo "<td><a href='volunteer.php?id=".$stu_link_id."'>" . $value. "</a></td>";

                            }
                        }

                        echo "</tr>";
                    }
                }


                if($actclick && $affected_rows != 0){

                    for ($i = 0; $i < $affected_rows; $i++) {

                        $row = $result->fetch_assoc();

                        if(array_key_exists ( "activity_id" , $row )) {
                            $act_key_to_use="activity_id";
                        }

                        $act_link_query="select * from activity where $act_key_to_use = '$row[$act_key_to_use]';";
                        $act_link_result = $db->query($act_link_query);
                        $act_link_row = $act_link_result->fetch_assoc();
                        $act_link_id=$act_link_row['activity_id'];

                        echo "<tr>";
                        if (is_array($row)) {

                            foreach ($row as $value) {


                                echo "<td><a href='activity.php?id=".$act_link_id."'>" . $value. "</a></td>";



                            }
                        }




                        echo "</tr>";
                    }}

                else{
                    for ($i = 0; $i < $affected_rows; $i++) {

                        $row = $result->fetch_assoc();



                        echo "<tr>";
                        if (is_array($row)) {

                            foreach ($row as $value) {
                                echo "<td>" . $value . "</td>";
                            }
                        }




                        echo "</tr>";
                    }}





                ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

*/ ?>
