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

<!DOCTYPE html>
<html lang="en">

<?php

// Access to global variables
require_once('../global/include.php');

// Make sure user is allowed to view admin area
if (!$isAdmin) {
    header('Location: '.SYSTEM_WEB_BASE_ADDRESS.'admin/login.php');
}

require("php/head.php");

$query = "SELECT * , time_format(timediff(TS.end_time, TS.start_time), '%l%:%i') as hours_granted
FROM activity A, time_slots TS, rooms R
WHERE A.room_id = R.room_id
AND A.slot_id = TS.slot_id
ORDER BY TS.start_time;";

?>

<body>

    <div id="wrapper">

        <?php require("php/sidebar.php"); echoNav($db, "schedule"); ?>

        <div id="page-wrapper">

            <div class="row">
                <div class="col-lg-12">
                    <h1>Schedule</h1>
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a>
                        </li>
                        <li class="active"><i class="fa fa-list-alt"></i> Schedule</li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->

            <div class="row">

            <?php

            $dayResult = $db->query("SELECT DISTINCT YEAR(start_time) as year, MONTH(start_time) as month, DAY(start_time) as day FROM time_slots;");
            $affected_rows_day = mysqli_num_rows($dayResult);

            for ($i = 0; $i < $affected_rows_day; $i++) {
                $day = $dayResult->fetch_assoc();
                $date = $day['year'] . "-" . sprintf("%02s", $day['month']) . "-" . sprintf("%02s", $day['day']);
                ?>

                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="fa fa-list-alt"></i> <?php echo date("F j, Y", strtotime($date)); ?>
                                <span style="cursor: pointer;" class="day_toggle" date="<?php echo $date; ?>"><i class="fa fa-plus pull-right"></i></span>
                            </h3>
                        </div>
                        <div id="<?php echo $date; ?>_display" status="closed" class="panel-body">
                            <div class="panel-group" id="accordion">

                <?php
                $query = "SELECT * FROM time_slots ts, activity a, rooms r
                            WHERE date(start_time) = Date('$date')
                            AND ts.slot_id = a.slot_id
                            AND a.room_id = r.room_id
                            ORDER BY ts.start_time;";
                $activityResult = $db->query($query);
                $affected_rows_activity = mysqli_num_rows($activityResult);

                for ($j = 0; $j < $affected_rows_activity; $j++) {
                    $activity = $activityResult->fetch_assoc();
                    $activity_id = $activity['activity_id'];
                    ?>


                    <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion"
                                        href="#collapseOne<?php echo $activity['activity_id']; ?>">


                                        <?php

                                        $now = time();
                                        //$now = strtotime("2013-03-07 14:00:00");
                                        $start = strtotime($activity['start_time']);
                                        $end = strtotime($activity['end_time']);

                                        if (($now >= $start) && ($now < $end)) {
                                            ?>
                                                <span class="label label-success pull-right">In Progress</span>
                                            <?php
                                        }
                                        ?>

                                        <p><?php echo $activity['activity_name']; ?></p>
                                        <p><small><?php echo date("F j, Y, g:i a", strtotime($activity['start_time'])); ?> - <?php echo date("g:i a", strtotime($activity['end_time'])); ?></small></p>
                                        <p><small><?php echo $activity['room_location']; ?></small></p>

                                        </a>
                                </h4>
                            </div>
                            <div id="collapseOne<?php echo $activity['activity_id']; ?>" class="panel-collapse collapse">
                                <div class="panel-body">





                                                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <td><strong>Student</strong></td>
                            <td><strong>Mark Attended</strong></td>
                            <td><strong>Grant Hours</strong></td>
                        </tr>
                    </thead>

                    <?php
                    $studentResult = $db->query("SELECT * FROM student_shifts ss, students s, activity a  WHERE ss.activity_id = " . $activity['activity_id'] . " AND ss.student_id = s.student_id AND ss.activity_id = a.activity_id;");
                    $affected_rows = mysqli_num_rows($studentResult);

                    for ($k = 0; $k < $affected_rows; $k++) {
                        $student = $studentResult->fetch_assoc();

                        $currently_granted_hour = floor($student['hours_granted']*60 / 60);
                        $currently_granted_min = round((($student['hours_granted'] - $currently_granted_hour) * 60), 0);

                        ?>
                            <tr id="row_<?php echo $student['activity_id']; ?>">
                                <td>
                                    <p style="margin:0px;"><a href="volunteer.php?id=<?php echo $student['student_id']; ?>">
                                        <div class="led <?php
                                            if ($student['checked_in'] == 't')
                                                echo "led-green";
                                            else
                                                echo "led-red";
                                            ?>">&nbsp;&nbsp;&nbsp;</div>
                                        <?php echo $student['first_name'] . " " . $student['last_name']; ?></a></p>
                                    <p style="margin:0px;"><span class="label label-info">Currently granted <span id="<?php echo $activity['activity_id']; ?>_<?php echo $student['student_id']; ?>_hours_display"><?php echo $currently_granted_hour; ?></span> hour(s), <span id="<?php echo $activity_id; ?>_<?php echo $student['student_id']; ?>_minutes_display"><?php echo $currently_granted_min; ?></span> min(s).</span></p>
                                    <p style="margin:0px;"><button student_id="<?php echo $student['student_id']; ?>" activity_id=<?php echo $activity_id; ?> type="button" class="btn btn-danger btn-xs pull-right unschedule">Unschedule</button></p>
                                    <?php // TODO make look nicer?>
                                            <a
            href="<?php echo SYSTEM_WEB_BASE_ADDRESS.'user/assemble.php?student_id='.$student['student_id'].'&activity_id='.$activity['activity_id'] ?>"
            target="_blank">Student instructions</a>
                                </td>

                                <td><div id="attended" activity_id="<?php echo $activity_id; ?>" student_id="<?php echo $student['student_id']; ?>" class="make-switch switch-small" data-on="success"
                                        data-off="danger"
                                        data-on-label="<i class='fa fa-check'></i>"
                                        data-off-label="<i class='fa fa-times'></i>">
                                        <input type="checkbox" <?php echo $student['attended'] == "t" ? "checked" : ""; ?>>
                                    </div></td>
                                <td style="min-width:325px;"><form class="form-inline" style="margin-bottom: 5px;">

                                        <?php
                                        $query = "SELECT time_format(timediff(TS.end_time, TS.start_time), '%l%:%i') as hours_granted
                                                FROM time_slots TS, activity A
                                                WHERE A.slot_id = TS.slot_id
                                                AND A.activity_id = '". $student['activity_id'] ."';";

                                        $result2 = $db->query($query);
                                        $student2 = $result2->fetch_assoc();

                                        // calculate hours/mins granted
                                        $times = explode(':', $student2['hours_granted']);
                                        $activity_hours = $times[0];
                                        $activity_mins = $times[1];

                                        ?>

                                        <select id="<?php echo $activity_id; ?>_<?php echo $student['student_id']; ?>_hours_input" style="width:75px;"class='form-control input-sm'>
                                            <option <?php echo $activity_hours == "0" ? "selected" : ""?>>0</option>
                                            <option <?php echo $activity_hours == "1" ? "selected" : ""?>>1</option>
                                            <option <?php echo $activity_hours == "2" ? "selected" : ""?>>2</option>
                                            <option <?php echo $activity_hours == "3" ? "selected" : ""?>>3</option>
                                            <option <?php echo $activity_hours == "4" ? "selected" : ""?>>4</option>
                                        </select> hour(s) and <select id="<?php echo $activity_id; ?>_<?php echo $student['student_id']; ?>_minutes_input" style="width:75px;" class='form-control input-sm'>
                                            <option <?php echo $activity_mins == "0" ? "selected" : ""?>>0</option>
                                              <option <?php echo $activity_mins == "5" ? "selected" : ""?>>5</option>
                                            <option <?php echo $activity_mins == "10" ? "selected" : ""?>>10</option>
                                            <option <?php echo $activity_mins == "15" ? "selected" : ""?>>15</option>
                                            <option <?php echo $activity_mins == "20" ? "selected" : ""?>>20</option>
                                            <option <?php echo $activity_mins == "25" ? "selected" : ""?>>25</option>
                                            <option <?php echo $activity_mins == "30" ? "selected" : ""?>>30</option>
                                            <option <?php echo $activity_mins == "35" ? "selected" : ""?>>35</option>
                                            <option <?php echo $activity_mins == "40" ? "selected" : ""?>>40</option>
                                            <option <?php echo $activity_mins == "45" ? "selected" : ""?>>45</option>
                                            <option <?php echo $activity_mins == "50" ? "selected" : ""?>>50</option>
                                            <option <?php echo $activity_mins == "55" ? "selected" : ""?>>55</option>
                                        </select> minute(s)</form>
                                        <button id="grant" activity_id="<?php echo $activity_id; ?>" student_id="<?php echo $student['student_id']; ?>" class="btn btn-primary btn-xs pull-right" type="button">Grant</button>
                                    </td>

                            </tr>

                        <?php
                    }
                    ?>
                </table>





                                </div>
                            </div>
                        </div>


                    <?php
                }

                ?>

                            </div>
                        </div>
                        <script type="text/javascript"> $("#<?php echo $date; ?>_display").hide(); </script>
                    </div>
                </div>

                <?php
            }

            ?>


            </div>


        </div>
        <!-- /#page-wrapper -->

        <?php require_once("footer.html"); ?>

    </div>
    <!-- /#wrapper -->

</body>
</html>
