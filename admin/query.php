<!-- Licensed under the BSD. See License.txt for full text.  -->

<?php

// Query to find students who can come to dinner

$queries = array(

        #query for shift soon but not checked in with us

        #query for missed shift

        "xxxxxxxx SELECT tshirt_size, count(tshirt_size) from students where times_complete = 't' group by tshirt_size;"
        => "find out needed t-shirt sizes for all students (does exclude ones not done with registration)",

    //Check whether this query should display activities with more than the desired number/if we want a separate query for it
        "actclick SELECT A.activity_id, A.desired_workers - (
        SELECT count(SS.activity_id)
        from student_shifts SS
        where SS.activity_id = A.activity_id
        ) as desired_workers
        from activity A
        where A.desired_workers >
        (
                SELECT count(SS.activity_id)
                from student_shifts SS
                where SS.activity_id = A.activity_id
        );"
        => "Check which activities don't have desired number of workers and determine how many - ugly but works",

    //This query should be changed to have activity_id and use id of -1 for the total, list by activity_id

        "actclick SELECT sum((A.desired_workers - (
        SELECT count(SS.activity_id)
        from student_shifts SS
        where SS.activity_id = A.activity_id
        )) * (time_to_sec(TS.end_time) - time_to_sec(TS.start_time)) / 3600) as short_hours
        from activity A, time_slots TS
        where A.slot_id = TS.slot_id
        and A.desired_workers <>
        (
                SELECT count(SS.activity_id)
                from student_shifts SS
                where SS.activity_id = A.activity_id
        );"
        => "Check which activities don't have desired number of workers and determine total time - ugly but works",

        "actclick SELECT SS.activity_id, count(SS.activity_id)
        from student_shifts SS
        group by SS.activity_id;"
        => "Number desired for each activity",

        "xxxxxxxx SELECT S.student_id, S.first_name, S.last_name
        from students S
        where S.checked_in = 'f'
        and S.student_id in
        (SELECT SS.student_id
                from student_shifts SS
                where S.student_id = SS.student_id
                and SS.attended = 't'
        );"
        => "fully not checked in but worked",

        "stuclick SELECT email FROM students where profile_complete = 'f';"
        => "Have not finished basic profile.",

        "stuclick SELECT email FROM students where times_complete = 'f' and profile_complete = 't';"
        => "Have not given available times.",

        "stuclick SELECT email FROM students where times_complete = 't' and profile_complete = 't';"
        => "who completely registered for sending notes",

        "stuclick SELECT first_name, last_name, email FROM students where times_complete = 't';"
        => "who gave times_complete for sending notes",

        "stuclick SELECT student_id, (sum(time_to_sec(TS.end_time) - time_to_sec(TS.start_time)))/60 as total_minutes FROM student_availability SA, time_slots TS where TS.slot_id=SA.slot_id group by student_id;"
        => "check how many hours students are available and if ok",

        "stuclick SELECT student_id, count(student_id) FROM student_availability SA group by student_id"
        => "check number of slots per student",

        "stuclick SELECT student_id, count(student_id) FROM student_availability SA group by student_id;"
        => "check number of slots per student",

        "stuclick SELECT SS.student_id, sum((time_to_sec(TS.end_time) - time_to_sec(TS.start_time)) / 60) as time_scheduled
                from time_slots TS, student_shifts SS, activity A
                where SS.activity_id = A.activity_id and A.slot_id = TS.slot_id
                group by SS.student_id
                order by time_scheduled;"
        => "Check time scheduled per student - won't find zero times",

        "stuclick SELECT S.student_id
                from students S
                where S.times_complete = 't'
                and S.student_id not in
                (SELECT SS.student_id
                from student_shifts SS
                where S.student_id = SS.student_id);"
        => "Find any not scheduled at all since above excludes these",

        "xxxxxxxx SELECT sum((time_to_sec(TS.end_time) - time_to_sec(TS.start_time)) / 3600) as total_time_scheduled_hrs
                from time_slots TS, student_shifts SS, activity A
                where SS.activity_id = A.activity_id and A.slot_id = TS.slot_id;"
        => "Check total time scheduled",

        "xxxxxxxx SELECT sum((time_to_sec(TS.end_time) - time_to_sec(TS.start_time)) * A.desired_workers / 3600) as total_time_activities_hrs
                from time_slots TS, activity A
                where A.slot_id = TS.slot_id;"
        => "Check total time for all activities at desired level",

        "stuclick SELECT SS.student_id, sum((time_to_sec(TS.end_time) - time_to_sec(TS.start_time)) / 60) as time_scheduled
                from time_slots TS, student_shifts SS, activity A
                where SS.activity_id = A.activity_id and A.slot_id = TS.slot_id
                group by SS.student_id
                having time_scheduled > 360;"
        => "Check if any student time scheduled exceeds limit",

        "stuclick SELECT SS.student_id, sum((time_to_sec(TS.end_time) - time_to_sec(TS.start_time)) / 60) as time_scheduled
                from time_slots TS, student_shifts SS, activity A
                where SS.activity_id = A.activity_id and A.slot_id = TS.slot_id
                group by SS.student_id
                having time_scheduled < 270;"
        => "Check if any student time scheduled less than minimum - check for ones with zero separately",

        "stuclick SELECT S.student_id, S.first_name, S.last_name
        from students S
        where S.times_complete = 't'
        and S.checked_in = 'f';"
        => "fully registered but not checked in - need to improve by sorting by arrival date"

);


?>


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

?>

<body>

    <div id="wrapper">

        <?php require("php/sidebar.php"); echoNav($db, "query"); ?>

        <div id="page-wrapper">

            <div class="row">
                <div class="col-lg-12">
                    <h1>Queries</h1>
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a>
                        </li>
                        <li class="active"><i class="fa fa-folder-open"></i> Queries</li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->

            <div class="row">

                <?php

                foreach ($queries as $query => $desc) {
                    $stuclick=false;
                    $actclick=false;
if (strpos($query,'stuclick') !== false) {
    $stuclick=true;
    $actclick=false;
}
if (strpos($query,'actclick') !== false) {
    $stuclick=false;
    $actclick=true;
}

$query=substr ( $query ,9);
                    ?>

                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="fa fa-folder-open"></i>
                                <?php echo $desc; ?>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <?php

                            $result2 = $db->query($query);
                            $affected_rows = mysqli_num_rows($result2);
                            $row2 = $result2->fetch_assoc();

                            ?>

                            <table class="datatable table table-striped table-bordered table-hover ">
                                <thead>
                                    <tr>
                                        <?php
                                        if($affected_rows != 0) {
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


                            if($actclick&& $affected_rows != 0){

                                for ($i = 0; $i < $affected_rows; $i++) {

                                    $row = $result->fetch_assoc();

                                    if(array_key_exists ( "activity_id" , $row )) {
                                        $act_key_to_use="activity_id";
                                    } else {$act_key_to_use="short_hours";}

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

                <?php
                }

                ?>



            </div>
        </div>

        <?php require_once("footer.html"); ?>

    </div>


</body>
