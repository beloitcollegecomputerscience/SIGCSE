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

$idSet = isset($_GET['id']);
if ($idSet) {
	// Queries the database for a student's information
	$activity_id = $_GET['id'];

	if (is_numeric($activity_id)) {
		$query = "SELECT * FROM activity a, rooms r, time_slots ts WHERE activity_id = " . $activity_id . " AND a.room_id = r.room_id AND a.slot_id = ts.slot_id;";
		$result = $db->query($query);
		$affected_rows = mysqli_num_rows($result);
		$objectRow = $result->fetch_assoc();
		$isValid = $affected_rows != 0 ? true : false;
	} else {
		$isValid = false;
	}
}

$show = $idSet && $isValid ? true : false;

?>

<body>

	<div id="wrapper">

		<?php require("php/sidebar.php"); echoNav($db, "activity"); ?>

		<div id="page-wrapper">

			<div class="row">
				<div class="col-lg-12">
					<h1>Activities<a class="btn btn-primary btn-sm" type="button"  href= php/add_activity.php >
					Add Acitivity </a></h1>


					<ol class="breadcrumb">
						<li><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a>
						</li>
						<li <?php echo !$show ? 'class="active"' : "" ?>><?php echo $show ? '<a href="activity.php">' : "" ?><i class="fa fa-th"></i> Activities<?php echo $show ? '</a>' : "" ?></li>
						<?php
						if ($show) { ?>
						<li class="active"><i class="fa fa-th-large"></i> <?php echo $objectRow['activity_name']; ?>
						</li>
						<?php }
						?>
					</ol>
				</div>
			</div>
			<!-- /.row -->

			<?php
			if ($show) {
				?>

				<div class="row">
					<div class="col-lg-6">

						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">
									<i class="fa fa-user"></i> Activity Information
								</h3>
							</div>
							<div class="panel-body">

							<h4>
								<?php echo $objectRow['activity_name']; ?>
							</h4>

							<p style="margin: 0px;">
								<?php echo $objectRow['room_location']; ?>
							</p>

							<p style="margin: 0px;">
								<strong>Begins:</strong> <?php echo date("F j, Y, g:i a", strtotime($objectRow['start_time'])); ?>
							</p>

							<p style="margin: 0px;">
								<strong>Ends:</strong> <?php echo date("F j, Y, g:i a", strtotime($objectRow['end_time'])); ?>
							</p>

							<?php

							$now = time();
							//$now = strtotime("2013-03-07 14:00:00");
							$start = strtotime($objectRow['start_time']);
							$end = strtotime($objectRow['end_time']);

							if (($now >= $start) && ($now < $end)) {
								?>
								<p style="margin: 0px;"><span class="label label-success">In Progress</span></p>
								<?php
							}
							?>

							<br/>

							<p style="margin: 0px;">
								Minimum Workers: <span class="badge"><?php echo $objectRow['min_workers']; ?></span>
							</p>

							<p style="margin: 0px;">
								Desired Workers: <span class="badge"><?php echo $objectRow['desired_workers']; ?></span>
							</p>

							<p style="margin: 0px;">
								Maximum Workers: <span class="badge"><?php echo $objectRow['max_workers']; ?></span>
							</p>

							</div>
						</div>
					</div>

					<div class="col-lg-6">

						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">
									<i class="fa fa-comments"></i> Notes
								</h3>
							</div>
							<div class="panel-body">
								<p><span class="label label-warning"><i class="fa fa-exclamation"></i></span> Click text below to edit note.</p>
								<a href="#" id="activity_note" data-type="textarea" data-pk="<?php echo $activity_id; ?>"><?php echo $objectRow['activity_notes']; ?></a>
							</div>
						</div>
					</div>

				</div>

				<div class="row">
					<div class="col-lg-12">

						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">
									<i class="fa fa-users"></i> Scheduled Volunteers
								</h3>
							</div>
							<div class="panel-body">


				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<td><strong>Volunteer</strong></td>
							<td><strong>Mark Attended</strong></td>
							<td><strong>Grant Hours</strong></td>
						</tr>
					</thead>

					<?php
					$result = $db->query("SELECT * FROM student_shifts ss, students s, activity a  WHERE ss.activity_id = " . $activity_id . " AND ss.student_id = s.student_id AND ss.activity_id = a.activity_id;");
					$affected_rows = mysqli_num_rows($result);

					for ($i = 0; $i < $affected_rows; $i++) {
						$row = $result->fetch_assoc();

						$currently_granted_hour = floor($row['hours_granted']*60 / 60);
						$currently_granted_min = round((($row['hours_granted'] - $currently_granted_hour) * 60), 0);

						?>
							<tr id="row_<?php echo $row['activity_id']; ?>">
								<td>
									<p style="margin:0px;"><a href="volunteer.php?id=<?php echo $row['student_id']; ?>"><?php echo $row['first_name'] . " " . $row['last_name']; ?></a></p>
									<p style="margin:0px;"><span class="label label-info">Currently granted <span id="<?php echo $activity_id; ?>_<?php echo $row['student_id']; ?>_hours_display"><?php echo $currently_granted_hour; ?></span> hour(s), <span id="<?php echo $activity_id; ?>_<?php echo $row['student_id']; ?>_minutes_display"><?php echo $currently_granted_min; ?></span> min(s).</span></p>
									<p style="margin:0px;"><button student_id="<?php echo $row['student_id']; ?>" activity_id=<?php echo $activity_id; ?> type="button" class="btn btn-danger btn-xs pull-right unschedule">Unschedule</button></p>
								</td>

								<td><div id="attended" activity_id="<?php echo $activity_id; ?>" student_id="<?php echo $row['student_id']; ?>" class="make-switch switch-small" data-on="success"
										data-off="danger"
										data-on-label="<i class='fa fa-check'></i>"
										data-off-label="<i class='fa fa-times'></i>">
										<input type="checkbox" <?php echo $row['attended'] == "t" ? "checked" : ""; ?>>
									</div></td>
								<td style="min-width:325px;"><form class="form-inline" style="margin-bottom: 5px;">

										<?php
										$query = "SELECT time_format(timediff(TS.end_time, TS.start_time), '%l%:%i') as hours_granted
												FROM time_slots TS, activity A
												WHERE A.slot_id = TS.slot_id
												AND A.activity_id = '". $row['activity_id'] ."';";

										$result2 = $db->query($query);
										$row2 = $result2->fetch_assoc();

										// calculate hours/mins granted
										$times = explode(':', $row2['hours_granted']);
										$activity_hours = $times[0];
										$activity_mins = $times[1];

										?>

										<select id="<?php echo $activity_id; ?>_<?php echo $row['student_id']; ?>_hours_input" style="width:75px;"class='form-control input-sm'>
											<option <?php echo $activity_hours == "0" ? "selected" : ""?>>0</option>
											<option <?php echo $activity_hours == "1" ? "selected" : ""?>>1</option>
											<option <?php echo $activity_hours == "2" ? "selected" : ""?>>2</option>
											<option <?php echo $activity_hours == "3" ? "selected" : ""?>>3</option>
											<option <?php echo $activity_hours == "4" ? "selected" : ""?>>4</option>
										</select> hour(s) and <select id="<?php echo $activity_id; ?>_<?php echo $row['student_id']; ?>_minutes_input" style="width:75px;" class='form-control input-sm'>
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
										<button id="grant" activity_id="<?php echo $activity_id; ?>" student_id="<?php echo $row['student_id']; ?>" class="btn btn-primary btn-xs pull-right" type="button">Grant</button>
									</td>

							</tr>

						<?php
					}
					?>
				</table>


							</div>
						</div>
					</div>
				</div>

				<div class="row">

					<div class="col-lg-12">

						<div class="panel panel-primary">
							<div class="panel-heading">
								<p class="pull-right">Volunteers compatible with availability</p>
								<h3 class="panel-title">
									<i class="fa fa-thumb-tack"></i> Schedule
								</h3>
							</div>
							<div class="panel-body">

							<table class="datatable table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th><strong>Name</strong></th>
										<th>Email</th>
										<th>School</th>
										<th>Advisor</th>
										<th>Advisor Email</th>
										<th>Cur. Sched. Hours</th>
										<th></th>
									</tr>
								</thead>

								<?php

								$query = "SELECT slot_id FROM covering_time_slots WHERE activity_id = $activity_id";
								$result = $db->query($query);
								$affected_rows = mysqli_num_rows($result);

								$covering_slots = array();
								for ($i = 0; $i < $affected_rows; $i++) {
									$row = $result->fetch_assoc();
									array_push($covering_slots, $row["slot_id"]);
								}

								$query = "SELECT * FROM students;";
								$result = $db->query($query);
								$affected_rows = mysqli_num_rows($result);

								for ($i = 0; $i < $affected_rows; $i++) {
									$row = $result->fetch_assoc();
									$student_id = $row["student_id"];

//									$result3 = $db->query("SELECT sum(hours_granted) as sum FROM student_shifts WHERE student_id=$student_id");
//									$result3 = $db->query("SELECT time_format(sum(timediff(TS.end_time, TS.start_time)), '%l%:%i') as sum FROM time_slots TS, activity A , students S, student_shifts SS where A.slot_id = TS.slot_id AND A.activity_id = SS.activity_id AND S.student_id = SS.student_id and S.student_id=$student_id;");
									$result3 = $db->query("SELECT sum(time_to_sec(timediff(TS.end_time, TS.start_time)) / 60) as sum FROM time_slots TS, activity A ,
students S, student_shifts SS where A.slot_id = TS.slot_id AND A.activity_id = SS.activity_id AND S.student_id = SS.student_id and S.student_id=$student_id;");
									$row3 = $result3->fetch_assoc();
									$hoursScheduled = ($row3['sum'] / 60);

									$query2 = "SELECT * FROM student_availability WHERE student_id = $student_id";
									$result2 = $db->query($query2);
									$affected_rows2 = mysqli_num_rows($result2);

									$available_slots = array();
									for ($j = 0; $j < $affected_rows2; $j++) {
										$row2 = $result2->fetch_assoc();
										array_push($available_slots, $row2["slot_id"]);
									}

									$valid = true;
									foreach ($covering_slots as $covering_slot) {
										if (!in_array($covering_slot, $available_slots)) {
											$valid = false;
										}
									}



									if ($valid) {
										?>

										<tr>
											<td>
												<p style="margin:0px;"><a href="volunteer.php?id=<?php echo $row["student_id"]; ?>"><?php echo $row["first_name"] . " " . $row["last_name"]; ?></a></p>
											</td>
											<td><?php echo $row["email"]; ?></td>
											<td><?php echo $row["school"]; ?></td>
											<td><?php echo $row["advisor_name"]; ?></td>
											<td><?php echo $row["advisor_email"]; ?></td>
											<td><?php echo round($hoursScheduled, 2); ?></td>
											<td>
												<button student_id="<?php echo $row["student_id"]; ?>" activity_id="<?php echo $activity_id; ?>" type="button" class="btn btn-success btn-xs pull-right schedule_manual">Schedule</button>
											</td>
										</tr>

										<?php
									}

								}

								?>
								</table>

							</div>
						</div>
					</div>
				</div>

			<?php
			}
			?>

			<div class="row" id="not_found">
				<div class="col-lg-4 col-lg-offset-4">

					<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert"
							aria-hidden="true">&times;</button>
						Activity not found.
					</div>
				</div>
			</div>
			<?php
			if (!($idSet && !$isValid)) {
				?>
			<script type="text/javascript"> $("#not_found").hide(); </script>
			<?php
			}
			?>

			<div class="row" id="search">



				<div class="col-lg-12">

					<table cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>Name</th>
								<th>Type</th>
								<th>Location</th>
								<th>Start Time</th>
								<th>End Time</th>
								<th>Min</th>
								<th>Desired</th>
								<th>Max</th>
								<th>Cur. Sched.</th>
								<th>Notes</th>
							</tr>
						</thead>
						<tbody>

							<?php
							$result = $db->query("SELECT * FROM activity a, rooms r, time_slots ts WHERE a.room_id = r.room_id AND a.slot_id = ts.slot_id");
							$affected_rows = mysqli_num_rows($result);



							for ($i = 0; $i < $affected_rows; $i++) {
								$row = $result->fetch_assoc();

								$result3 = $db->query("SELECT count(*) as count FROM student_shifts WHERE activity_id = {$row['activity_id']}");
								$row3 = $result3->fetch_assoc();
								$numScheduled = $row3['count'];

								?>
							<tr>
								<td><a href="activity.php?id=<?php echo $row['activity_id']?>"><?php echo $row['activity_name']; ?>
								</a></td>
								<td><?php echo $row['activity_type']; ?></td>
								<td><?php echo $row['room_location']; ?></td>
								<td><?php echo date("F j, Y, g:i a", strtotime($row['start_time'])); ?></td>
								<td><?php echo date("F j, Y, g:i a", strtotime($row['end_time'])); ?></td>
								<td><?php echo $row['min_workers']; ?></td>
								<td><?php echo $row['desired_workers']; ?></td>
								<td><?php echo $row['max_workers']; ?></td>
								<td><?php echo $numScheduled; ?></td>
								<td><?php echo $row['activity_notes']; ?></td>
							</tr>
							<?php
							}
							?>
						</tbody>
					</table>

				</div>
			</div>
			<!-- /.row -->

			<?php
			if ($idSet && $isValid) {
				?>
			<script type="text/javascript"> $("#search").hide(); </script>
			<?php
			}
			?>

		</div>
		<!-- /#page-wrapper -->

		<?php require_once("footer.html"); ?>

	</div>
	<!-- /#wrapper -->

</body>
</html>
