<!-- Licensed under the BSD. See License.txt for full text.  -->

<!DOCTYPE html>
<html lang="en">

<?php

// Access to global variables
require_once ('../global/include.php');

// Include the head for every page
require_once (SYSTEM_WEBHOME_DIR . 'user/php/head.php');

if (! $isLoggedIn) {
    header ( 'Location: ' . SYSTEM_WEB_BASE_ADDRESS . 'user/index.php' );
}

$query = "SELECT * FROM students WHERE students.student_id =" . $_SESSION ['student_id'];

// Query the database
$result = $db->query ( $query );
$row = $result->fetch_assoc ();



/* ----------------this part here- (This part here what? PT 04/03/17) */

$result2= $db->query ( "SELECT * FROM student_skills WHERE student_id = " . $_SESSION ['student_id']." and skill_id= -1"  );
$kids_camp_result = mysqli_num_rows($result2);

/* ----------------this part here- */



// If user has a preferred name then address them as such otherwise use first name
$displayName = $row ['preferred_name'] == null ? $row ['first_name'] : $row ['preferred_name'];

// Calculate the status of the two steps to display correct info on page.
$stepOne = $row ['profile_complete'] == "t" ? true : false;
$stepTwo = $row ['times_complete'] == "t" ? true : false;

// Get boolean as to if the user can view their schedule
$query = "SELECT locked FROM system_locks WHERE name='view_schedule'";
$result = $db->query ( $query );
$lockRow = $result->fetch_assoc ();
$displayingSchedule = $lockRow ['locked'] == "t" ? false : true;

?>

<body>

    <?php require(SYSTEM_WEBHOME_DIR."user/php/nav.php"); echoNav($system_text, $db, $isLoggedIn, $isAdmin, "profile"); ?>

    <div style="" class="container">

        <div class="row col-lg-10 col-lg-offset-1">


            <h2 style="margin-top: 0px;" class="text-center"><?php echo $system_text["user_profile"]["title"]; ?></h2>

            <p style="font-size: 18px;" class="lead"><?php echo $system_text["user_profile"]["description"]; ?></p>

            <hr />

            <div class="row">

                <div
                    class="col-lg-<?php echo $displayingSchedule ? "4" : "6";?> col-md-<?php echo $displayingSchedule ? "4" : "6";?> col-sm-<?php echo $displayingSchedule ? "4" : "6";?>">
                    <h3>
                        <span
                            class="label label-<?php echo $stepOne ? "success" : "warning"; ?>"><span
                            class="fa fa-<?php echo $stepOne ? "check" : "exclamation"; ?>"></span></span> <?php echo $system_text["user_profile"]["contact"]; ?>
                            <a
                            href="<?php echo SYSTEM_WEB_BASE_ADDRESS; ?>user/register.php?two"><button
                                type="button" class="btn btn-primary btn-xs"><?php echo $system_text["user_profile"]["contact_button"]; ?></button></a>
                    </h3>

                    <hr />

                    <p style="font-size: 18px;" class="lead"><?php echo $system_text["user_profile"]["contact_desc"]; ?> <?php echo !$stepOne ? $system_text["user_profile"]["contact_update"] : ""; ?></p>


                    <p style="margin: 0px;">
                        <b><?php echo $row['first_name'] . " " . $row['last_name']; ?> </b>
                    </p>


                    <!-- --------------THIS PART --------------->

                    <br />


                    <p style="margin: 0px;">





                        <?php if($kids_camp_result==0){echo "Can not volunteer with Kid's Camp";}
                        else {echo "Can volunteer with Kid's Camp";} ?>
                    </p>



                    <!-- ----------------------- --------------->


                    <?php
                    if (isset ( $row ['preferred_name'] ) && $row ['preferred_name'] != "") {
                        ?>
                    <p style="margin: 0px;">
                        Nickname:
                        <?php echo $row['preferred_name']; ?>
                    </p>
                    <?php
                    }
                    ?>

                    <p style="margin: 0px;">
                        <?php echo $row['email']; ?>
                    </p>

                    <?php
                    if (isset ( $row ['cell_phone'] )) {
                        ?>

                    <p style="margin: 0px;">
                        <?php echo $row['cell_phone']; ?>
                    </p>
                    <?php
                    }
                    ?>

                    <?php
                    if (isset ( $row ['tshirt_size'] )) {
                        ?>
                    <p style="margin: 0px;">
                        Shirt Size: <span class="label label-default"><?php echo $row['tshirt_size']; ?>
                        </span>
                    </p>
                    <?php
                    }
                    ?>

                    <a href="<?php echo SYSTEM_WEB_BASE_ADDRESS; ?>user/password.php"><button
                            style="margin-top: 3px;" type="button"
                            class="btn btn-default btn-xs"><?php echo $system_text["user_profile"]["password_change"]; ?></button></a>

                    <?php
                    if (isset ( $row ['tshirt_size'] )) {
                        ?>
                        <br /> <br />
                    <?php
                    }
                    ?>

                    <?php
                    if (isset ( $row ['school'] )) {
                        ?>
                    <p style="margin: 0px;">
                        <?php echo $row['school']; ?>
                    </p>
                    <?php
                    }
                    ?>

                    <?php
                    if (isset ( $row ['standing'] )) {
                        ?>
                    <p style="margin: 0px;">
                        <?php echo $row['standing']; ?>
                    </p>
                    <?php
                    }
                    ?>

                    <?php
                    if (isset ( $row ['advisor_name'] )) {
                        ?>
                    <p style="margin: 0px;">
                        Advisor:
                        <?php echo $row['advisor_name']; ?>
                    </p>
                    <?php
                    }
                    ?>

                    <?php
                    if (isset ( $row ['advisor_email'] )) {
                        ?>
                    <p style="margin: 0px;">
                        <?php echo $row['advisor_email']; ?>
                    </p>
                    <?php
                    }
                    ?>

                </div>



                <div
                    class="col-lg-<?php echo $displayingSchedule ? "4" : "6";?> col-md-<?php echo $displayingSchedule ? "4" : "6";?> col-sm-<?php echo $displayingSchedule ? "4" : "6";?>">
                    <h3>
                        <span
                            class="label label-<?php echo $stepTwo ? "success" : "warning"; ?>"><span
                            class="fa fa-<?php echo $stepTwo ? "check" : "exclamation"; ?>"></span></span> <?php echo $system_text["user_profile"]["availability"]; ?>
                            <a
                            href="<?php echo SYSTEM_WEB_BASE_ADDRESS; ?>user/register.php?three"><button
                                type="button" class="btn btn-primary btn-xs"><?php echo $system_text["user_profile"]["avail_button"]; ?></button>
                        </a>
                    </h3>

                    <hr />

                    <?php
                    if ($stepTwo) {
                        availability ( $system_text, $db );
                    } else {
                        ?>
                        <p style="font-size: 18px;" class="lead"><?php echo $system_text["user_profile"]["avail_update"]; ?></p>
                        <?php
                    }
                    ?>
                </div>



                <?php
                // This was done to limit when can see schedule but not used now.
                // Only show if within 15 mintues of work time.
                // Dummy time
                // $show = new DateTime ( '2015-03-08' );
                // Real time
                // $show = new DateTime ();
                // Subtract 15 minutes
                // $show->modify ( '-15 minutes' );
                // For printing times for testing
                // echo $show->format ( "D, d M Y H:i:s" );
                // echo (new DateTime ( $row ['start_time'] ))->format ( "D, d M Y H:i:s" );
                // Don't show if not already that time
                // if ($show >= new DateTime ( $row ['start_time'] )) {
                // $displayingSchedule = false;
                // }

                if ($displayingSchedule) {
                    // Shows general instructions for student that can always see.
                    ?>
                    <a href="<?php echo SYSTEM_WEB_BASE_ADDRESS."user/generalinstruction.php" ?>"
                    target="_blank"><h4>General student instructions</h4></a>
                    <?php
                    schedule ( $system_text, $db );
                }
                ?>

            </div>

            <hr />

        </div>

    </div>

    <?php require_once("footer.html")?>

</body>
</html>

<?php
function availability($system_text, $db) {
    ?>
<p style="font-size: 18px;" class="lead"><?php echo $system_text["user_profile"]["avail_desc"]; ?></p>
<ul style="margin-left: -22px;">
    <?php

    $query = "SELECT * FROM student_availability SA, time_slots TS WHERE SA.student_id = " . $_SESSION ['student_id'] . " AND SA.slot_id = TS.slot_id";

    // Query the database
    $result = $db->query ( $query );

    $affected_time_slots = mysqli_num_rows ( $result );
    for($i = 0; $i < $affected_time_slots; $i ++) {
        $row = $result->fetch_assoc ();
        ?>

    <li><?php echo date("F j, Y, g:i a", strtotime($row['start_time'])); ?> -
        <?php echo date('g:i a', strtotime($row['end_time'])); ?></li>

    <?php
    }

    ?>
</ul>
<?php
}
function schedule($system_text, $db) {
    ?>

<div class="col-lg-4 col-md-4 col-sm-4">
    <h3>Schedule</h3>
    <a href="<?php echo SYSTEM_WEB_BASE_ADDRESS; ?>user/php/counts.php"><button
                style="margin-top: 3px;" type="button"
                class="btn btn-default btn-xs"> Headcounts </button></a>
    <hr />

    <?php

    $query = "SELECT * from students where student_id = " . $_SESSION ['student_id'];
    $result = $db->query ( $query );
    $row = $result->fetch_assoc ();

    if ($row ['refund'] == "t") {
        ?>
        <span class="label label-success"><?php echo $system_text["user_profile"]["refund"]; ?></span>
        <?php
    }

    $query = "SELECT A.activity_id, TS.start_time, TS.end_time, SS.attended, SS.hours_granted
    FROM student_shifts SS, time_slots TS, students S, activity A
    WHERE SS.student_id = S.student_id AND
    SS.activity_id = A.activity_id AND
    A.slot_id = TS.slot_id AND
    S.student_id = " . $_SESSION ['student_id'] . "
    ORDER BY TS.start_time";

    $result = $db->query ( $query );
    $affected_rows = mysqli_num_rows ( $result );

    if ($affected_rows != 0) {
        ?>
        <p style="font-size: 18px;" class="lead"><?php echo $system_text["user_profile"]["schedule"]; ?></p>
        <?php
    }

    for($i = 0; $i < $affected_rows; $i ++) {
        $row = $result->fetch_assoc ();
        $activity_id = $row ['activity_id'];
        $attended = $row ['attended'] == "t" ? true : false;
        $grantedHours = $row ['hours_granted'] == "0" ? false : true;

        ?>

    <p style="margin-bottom: 0px;">
        <?php echo date("F j, Y, g:i a", strtotime($row['start_time'])); ?>
        -
        <?php echo date('g:i a', strtotime($row['end_time'])); ?>
    </p>

    <p style="margin-bottom: 0px;">
        <a
            href="<?php echo SYSTEM_WEB_BASE_ADDRESS."user/assemble.php?student_id={$_SESSION['student_id']}&activity_id=$activity_id" ?>"
            target="_blank">- Instructions</a>
    </p>

        <?php
        $show = new DateTime ();
        // Dummy date for testing.
//         $show = new DateTime ( '2015-03-06' );
        if ($show >= new DateTime ( $row ['end_time'] )) {

            ?>
        <span
        class="label label-<?php echo $attended ? "success" : "danger" ?>"><?php echo $attended ? $system_text["user_profile"]["attended"] : $system_text["user_profile"]["not_attended"] ?></span>

        <?php

            if ($attended) {
                ?>
            <span
        class="label label-<?php echo $grantedHours ? "success" : "danger" ?>"><?php echo $grantedHours ? $system_text["user_profile"]["granted"]." ".round($row['hours_granted'], 2)." Hour(s)" : "Not Granted Hours" ?></span>
            <?php
            }
        }
        // TODO }

        ?>

    <br /> <br />

    <?php
    }

    if ($affected_rows == 0) {
        ?>
    <p style="font-size: 18px;" class="lead">You have not been scheduled.</p>
    <?php
    }

    ?>
</div>
<?php
}
?>
