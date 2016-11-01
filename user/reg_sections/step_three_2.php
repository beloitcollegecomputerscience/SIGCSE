<?php

if ($isLoggedIn) {
	// Queries the database
	$result = $db->query("SELECT SA.slot_id as arrival FROM student_arrivals SA WHERE SA.student_id={$_SESSION['student_id']};");
	$aff = mysqli_num_rows($result);

	// If no rows affected
	if ($aff == 0) {
		$arrival = null;
	} else {
		$row = $result->fetch_assoc();
		$arrival = $row['arrival'];
	}
} else {
	$arrival = null;
}


?>


<!-- Step Three -->
<div id="step_three_2">

	<input type="hidden" id="step_three_status_2" value="part_one">

	<input type="hidden" id="step_three_arrival" value="">
	<input type="hidden" id="step_three_departure" value="">

	<h2 style="margin-top: 0px;" class="text-center">Availability</h2>

	<div id="step_three_part_one_inst_2">

		<p style="font-size: 18px;" class="lead"><?php echo $system_text["user_register_part3"]["description_1"]; ?></p>

		<p style="font-size: 18px; color: red;" class="lead"><?php echo $system_text["user_register_part3"]["instruction_1"]; ?></p>


	</div>

	<div id="step_three_part_two_inst_2">

		<p style="font-size: 18px;" class="lead"><?php echo $system_text["user_register_part3"]["description_2"]; ?></p>

		<p style="font-size: 18px; color: red;" class="lead"><?php echo $system_text["user_register_part3"]["instruction_2"]; ?></p>


	</div>
	<script type="text/javascript"> $("#step_three_part_two_inst_2").hide(); </script>

	<div id="step_three_part_three_inst_2">

		<p style="font-size: 18px;" class="lead"><?php echo $system_text["user_register_part3"]["description_3_1"]; ?></p>

		<p style="font-size: 18px;" class="lead"><?php echo $system_text["user_register_part3"]["description_3_2"]; ?></p>

		<p style="font-size: 18px; color: red;" class="lead"><?php echo $system_text["user_register_part3"]["required"]; ?></p>

	</div>
	<script type="text/javascript"> $("#step_three_part_three_inst_2").hide(); </script>




	<hr />

	<div id="step_three_alert_success_2"
		class="alert alert-success col-lg-8 col-lg-offset-2"></div>
	<div id="step_three_alert_danger_2"
		class="alert alert-danger col-lg-8 col-lg-offset-2"></div>
	<script type="text/javascript"> $("#step_three_alert_success_2").hide(); </script>
	<script type="text/javascript"> $("#step_three_alert_danger_2").hide(); </script>

	<div id="radio_input" class="col-lg-12">




		<?php

		$dayResult = $db->query("SELECT DISTINCT YEAR(start_time) as year, MONTH(start_time) as month, DAY(start_time) as day from time_slots WHERE student_available = 't' ORDER BY start_time");
		$affected_rows_day = mysqli_num_rows($dayResult);
		for ($i = 0; $i < $affected_rows_day; $i++) {

			if ((($i+1) % 4) == 1) {
				?><div class="row" class="text-center"><?php
			}

			$day = $dayResult->fetch_assoc();
			$date = $day['year'] . "-" . sprintf("%02s", $day['month']) . "-" . sprintf("%02s", $day['day']);
			?>
				<div class="col-lg-3">
				<h5><?php echo date('l F j, Y', strtotime($date)); ?></h5>
			<?php

			$timeSlotResult = $db->query("SELECT * FROM time_slots WHERE date(start_time) = Date('$date') and student_available = 't' ORDER BY start_time");
			$affected_timeSlots = mysqli_num_rows($timeSlotResult);
			for ($j = 0; $j < $affected_timeSlots; $j++) {
				$timeSlot = $timeSlotResult->fetch_assoc();

				?>
					<div class="radio">
					  <label>
					    <input type="radio" name="time_slot_radio" id="time_slot_input_<?php echo $timeSlot['slot_id']; ?>" value="<?php echo $timeSlot['slot_id']; ?>" <?php echo ($arrival == $timeSlot['slot_id']) ? "checked" : "" ?> >
					   		<?php echo date('g:ia', strtotime($timeSlot['start_time'])); ?> - <?php echo date('g:ia', strtotime($timeSlot['end_time'])); ?>
					  </label>
					</div>
				<?php
			}

			?></div><?php

			if (((($i+1) % 4) == 0) || ($i+1 == $affected_rows_day))  {
				?></div><?php
			}
		}
		?>

		<div class="col-lg-offset-3 col-lg-9 text-right">
			<button id="step_three_submit_2" type="button"
				class="btn btn-primary">Submit</button>
			<button id="step_three_later_2" type="button"
				class="btn btn-warning">Do Later</button>
		</div>

	</div>

	<div id="checkbox_input" class="col-lg-12">

		<?php

		$dayResult = $db->query("SELECT DISTINCT YEAR(start_time) as year, MONTH(start_time) as month, DAY(start_time) as day from time_slots WHERE student_available = 't' ORDER BY start_time");
		$affected_rows_day = mysqli_num_rows($dayResult);
		for ($i = 0; $i < $affected_rows_day; $i++) {

			if ((($i+1) % 4) == 1) {
				?><div class="row" class="text-center"><?php
			}

			$day = $dayResult->fetch_assoc();
			$date = $day['year'] . "-" . sprintf("%02s", $day['month']) . "-" . sprintf("%02s", $day['day']);
			?>
				<div class="col-lg-3">
				<h5><?php echo date('l F j, Y', strtotime($date)); ?></h5>
			<?php

			$timeSlotResult = $db->query("SELECT * FROM time_slots WHERE date(start_time) = Date('$date') and student_available = 't' ORDER BY start_time");
			$affected_timeSlots = mysqli_num_rows($timeSlotResult);
			for ($j = 0; $j < $affected_timeSlots; $j++) {
				$timeSlot = $timeSlotResult->fetch_assoc();

				?>
					<p><input type='checkbox' name="ts<?php echo $timeSlot['slot_id']; ?>"> <?php echo date('g:ia', strtotime($timeSlot['start_time'])); ?> - <?php echo date('g:ia', strtotime($timeSlot['end_time'])); ?></p>
				<?php
			}

			?></div><?php

			if (((($i+1) % 4) == 0) || ($i+1 == $affected_rows_day))  {
				?></div><?php
			}
		}
		?>

		<div class="col-lg-offset-3 col-lg-9 text-right">
			<button id="step_three_submit_2_2" type="button"
				class="btn btn-primary"><?php echo $system_text["user_register_part3"]["submit_button"]; ?></button>
			<button id="step_three_later" type="button"
				class="btn btn-warning"><?php echo $system_text["user_register_part3"]["skip"]; ?></button>
		</div>

	</div>
	<script type="text/javascript"> $("#checkbox_input").hide(); </script>

	<div style="clear: both;"></div>

	<hr />

</div>

<?php
if (!$stepThree) {
	?>
<script type="text/javascript"> $("#step_three_2").hide(); </script>
<?php
}
?>
