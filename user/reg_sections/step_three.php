<!-- Licensed under the BSD. See License.txt for full text.  -->

<!-- Step Three -->
<div id="step_three">

    <input type="hidden" id="step_three_status" value="part_one">

    <h2 style="margin-top: 0px;" class="text-center">Availability</h2>

    <div id="step_three_part_one_inst">

        <p style="font-size: 18px;" class="lead">These times indicate the
            first and last available times you can volunteer. They are not
            arrival and departure times of your flight. You should leave
            sufficient time for local travel as needed. If you are a local
            person or available the entire time, please check the first and
            last available times. You must be available for the full time
            slot (at begining on arrival and at end on departure). On the
            next page you will be able to indicate times you cannot work
            in-between these two times.</p>

        <p style="font-size: 18px; color: red;" class="lead">* only check
            2</p>

    </div>

    <div id="step_three_part_two_inst">

        <p style="font-size: 18px;" class="lead">Times before and after
            your indicated arrival and departure are crossed out and
            unavailable. If you wish to change these you must redo the
            previous step (Back). You should unselect any time ranges for
            which you are unavailable for any part of that time. Note that
            you are only indicating your available times which will be used
            to schedule the times you will actually work. To make this
            process run smoothly it is important that you only uncheck times
            when you cannot work and not times you find undesirable. If you
            do not indicate availability for a sufficient number of hours
            your submission will not be accepted and you will have to
            re-enter the information. You may change your available times
            after you submit.</p>

        <p style="font-size: 18px;" class="lead">All times that are
            checked will be used in assigning your volunteer hours and it is
            important that this information is accurate. You may revisit this
            page to update the information until hours are are assigned.
            (Normally in February)</p>

        <p style="font-size: 18px; color: red;" class="lead">* uncheck
            times you are unavailable</p>

    </div>
    <script type="text/javascript"> $("#step_three_part_two_inst").hide(); </script>




    <hr />

    <div id="step_three_alert_success"
        class="alert alert-success col-lg-8 col-lg-offset-2"></div>
    <div id="step_three_alert_danger"
        class="alert alert-danger col-lg-8 col-lg-offset-2"></div>
    <script type="text/javascript"> $("#step_three_alert_success").hide(); </script>
    <script type="text/javascript"> $("#step_three_alert_danger").hide(); </script>

    <?php

    if ($isLoggedIn) {
        // Queries the database
        $result = $db->query("SELECT SA.slot_id as arrival, SD.slot_id as departure FROM student_arrivals SA, student_departures SD WHERE SA.student_id = SD.student_id and SA.student_id =".$_SESSION['student_id']);
        $aff = mysqli_num_rows($result);

        // If no rows affected
        if ($aff == 0) {
            $arrival = null;
            $depart = null;
        } else {
            $row = $result->fetch_assoc();
            $arrival = $row['arrival'];
            $depart = $row['departure'];
        }
    } else {
        $arrival = null;
        $depart = null;
    }



    // get all time slots where student_available = 't'
    $query = "SELECT slot_id, start_time, end_time FROM time_slots WHERE student_available = 't' ORDER BY start_time";
    $result = $db->query($query);

    // multidimensional array.  arrays for each day holding an array of time slots of those days.
    $time_slots = array();

    // temp array used to keep track of if we have assigned an array to the specific day in $time_slots
    $usedDays = array();

    // loop through all rows
    $affected_time_slots = mysqli_num_rows($result);
    for ($i = 0; $i < $affected_time_slots; $i++) {
        $row = $result->fetch_assoc();

        $slot_id = $row['slot_id'];

        // [YEAR-MONTH-DAY, HOUR:MIN:SEC]
        $start_time_array = explode(' ',$row['start_time']);
        $end_time_array = explode(' ',$row['end_time']);

        // YEAR-MONTH-DAY
        $start_day = $start_time_array[0];
        $end_day = $end_time_array[0];

        // HOUR:MIN:SEC
        $start_time = $start_time_array[1];
        $end_time = $end_time_array[1];

        // If the day hasn't been added to $usedDays, then add it to $usedDays and create an array for it in $time_slots
        if (!in_array($start_day, $usedDays)) {
            array_push($usedDays, $start_day);
            $time_slots[$start_day] = array();
        }

        // Construct a string "HOUR:MIN:SEC HOUR:MIN:SEC SLOT_ID" and push it into the specific day's array in $time_slots
        if (!in_array($start_time.' '.$end_time.' '.$slot_id, $time_slots[$start_day])) {
            array_push($time_slots[$start_day], $start_time.' '.$end_time.' '.$slot_id);
        }
    }

    $currentDay = 1;

    // for each day
    foreach ($usedDays as $day) {

        if (($currentDay % 4) == 1) {
            ?>
    <div class="row" class="text-center">
        <?php
        }

        ?>
        <div class="col-lg-3">
            <h4>
                <?php echo date('l F j, Y', strtotime($day)); ?>
            </h4>
            <?php


            // for each time slot in that day
            foreach ($time_slots[$day] as $timeString) {

                // Get the start time, end time, and id from the array item
                $timeStringArray = explode(' ', $timeString);
                $time_start = $timeStringArray[0];
                $time_end = $timeStringArray[1];
                $time_id = $timeStringArray[2];

                ?>

            <p>
                <input type='checkbox' name="ts<?php echo $time_id; ?>"
                <?php echo (($arrival == $time_id) or ($depart == $time_id)) ? "checked" : "" ?> />
                <?php echo date('g:ia', strtotime($time_start)); ?>
                to
                <?php echo date('g:ia', strtotime($time_end)); ?>
            </p>

            <?php
            }

            ?>
        </div>
        <?php

        if (($currentDay % 4) == 0) {
            ?>
    </div>
    <?php
        }
        $currentDay = $currentDay + 1;
    }

    ?>



    <div class="col-lg-offset-3 col-lg-9 text-right">
        <button id="step_three_submit" type="button"
            class="btn btn-primary">Submit</button>
        <button id="step_three_later" type="button"
            class="btn btn-warning">Do Later</button>
    </div>

    <div style="clear: both;"></div>

</div>

<?php
if (!$stepThree) {
    ?>
<script type="text/javascript"> $("#step_three").hide(); </script>
<?php
}
?>
