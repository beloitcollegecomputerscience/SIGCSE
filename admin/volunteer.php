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
	$student_id = $_GET['id'];

	if (is_numeric($student_id)) {
		$result = $db->query("SELECT * FROM students where student_id = $student_id");
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

		<?php require("php/sidebar.php"); echoNav($db, "volunteer"); ?>

		<div id="page-wrapper">

			<div class="row">
				<div class="col-lg-12">
					<h1>Volunteers</h1>
					<ol class="breadcrumb">
						<li><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a>
						</li>
						<li <?php echo !$show ? 'class="active"' : "" ?>><?php echo $show ? '<a href="volunteer.php">' : "" ?><i
							class="fa fa-users"></i> Volunteers<?php echo $show ? '</a>' : "" ?>
						</li>
						<?php 
						if ($show) { ?>
						<li class="active"><i class="fa fa-user"></i> <?php echo $objectRow['first_name'] . " " . $objectRow['last_name']; ?>
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
								<i class="fa fa-user"></i> Contact Information
							</h3>
						</div>
						<div class="panel-body">

							<div id="righthandside" class="pull-right" >
								<button student_id="<?php echo $student_id; ?>" id="delete_vol" type="button" class="btn btn-danger pull-right">Delete</button>
								
								<br>

								<?php
									$query_arrival = "SELECT start_time FROM student_arrivals, time_slots WHERE student_arrivals.slot_id = time_slots.slot_id AND 
student_id=$student_id;";
									$result_arrival = $db->query($query_arrival);
									$row_arrival = $result_arrival->fetch_assoc();

									$query_departure = "SELECT end_time FROM student_departures, time_slots WHERE student_departures.slot_id = time_slots.slot_id AND 
student_id=$student_id;";
									$result_departure = $db->query($query_departure);
									$row_departure = $result_departure->fetch_assoc();

								?>
								
								<p style="margin-top:115px;" class="pull-right"> 
									Arrival Time: <?php echo $row_arrival['start_time']; ?>
									<br> 
									Departure Time: <?php echo $row_departure['end_time']; ?>
								</p>
							</div>

							<h4>
								<?php echo $objectRow['first_name'] . " " . $objectRow['last_name']; ?>
							</h4>

							<?php 
							if (isset($objectRow['preferred_name'])) {
								?>
							<p style="margin: 0px;">
								Goes by:
								<?php echo $objectRow['preferred_name']; ?>
							</p>
							<?php
							}
							?>

							<p style="margin: 0px;">
								<?php echo $objectRow['email']; ?>
							</p>

							<?php 
							if (isset($objectRow['cell_phone'])) {
								?>
							<p style="margin: 0px;">
								<?php echo $objectRow['cell_phone']; ?>
							</p>
							<?php
							}
							?>

							<?php 
							if (isset($objectRow['tshirt_size'])) {
								?>
							<p style="margin: 0px;">
								Shirt Size: <span class="label label-default"><?php echo $objectRow['tshirt_size']; ?>
								</span>
							</p>
							<br />
							<?php
							}
							?>

							<?php 
							if (isset($objectRow['school'])) {
								?>
							<p style="margin: 0px;">
								<?php echo $objectRow['school']; ?>
							</p>
							<?php
							}
							?>

							<?php 
							if (isset($objectRow['standing'])) {
								?>
							<p style="margin: 0px;">
								<?php echo $objectRow['standing']; ?>
							</p>
							<?php
							}
							?>

							<?php 
							if (isset($objectRow['advisor_name'])) {
								?>
							<p style="margin: 0px;">
								<?php echo $objectRow['advisor_name']; ?>
							</p>
							<?php
							}
							?>

							<?php 
							if (isset($objectRow['advisor_email'])) {
								?>
							<p style="margin: 0px;">
								<?php echo $objectRow['advisor_email']; ?>
							</p>
							<?php
							}
							?>
							<?php 
							$query_kids_camp = "SELECT * FROM student_skills WHERE skill_id = -1 AND 
student_id=$student_id;";
							$result_kids_camp = $db->query($query_kids_camp);
							if(mysqli_num_rows($result_kids_camp)!=0){?>
							<p style="margin: 0px;"><b>
								Can volunteer with Kid's Camp
							</b></p>
							<?php
							} else{
							?>
							<p style="margin: 0px;"><b>
								Can not volunteer with Kid's Camp
							</b></p>
							<?php } ?>
							

						</div>
					</div>
				</div>

				<div class="col-lg-6">

					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">
								<i class="fa fa-comments"></i> Status
							</h3>
						</div>
						<div class="panel-body">
							<div class="col-md-6">
								<h4 style="margin: 0px; margin-bottom: 5px">
									Profile Complete <small>Input contact information?</small>
								</h4>
								<div class="make-switch switch-small" data-on="success"
									data-off="danger" data-on-label="<i       class='fa fa-check'>
									</i>" data-off-label="<i class='fa fa-times'></i>"> <input
										type="checkbox"
										<?php echo $objectRow['profile_complete'] == 't' ? "checked" : ""; ?>
										disabled>
								</div>
								<hr />
							</div>
							<div class="col-md-6">
								<h4 style="margin: 0px; margin-bottom: 5px">
									Times Complete <small>Input availability?</small>
								</h4>
								<div id="vol_times_complete" student_id="<?php echo $student_id; ?>"
									class="make-switch switch-small" data-on="success"
									data-off="danger" data-on-label="<i       class='fa fa-check'>
									</i>" data-off-label="<i class='fa fa-times'></i>"> <input
										type="checkbox"
										<?php echo $objectRow['times_complete'] == 't' ? "checked" : ""; ?>
										>
								</div>
								<hr />
							</div>
							<div class="col-md-6">
								<h4 style="margin: 0px; margin-bottom: 5px">
									Checked In <small>Toggle when they check in at conference</small>
								</h4>
								<div id="check_in" student_id="<?php echo $student_id; ?>"
									class="make-switch switch-small" data-on="success"
									data-off="danger" data-on-label="<i       class='fa fa-check'>
									</i>" data-off-label="<i class='fa fa-times'></i>"> <input
										type="checkbox"
										<?php echo $objectRow['checked_in'] == 't' ? "checked" : ""; ?>>
								</div>
								<hr />
							</div>
							<div class="col-md-6">
								<h4 style="margin: 0px; margin-bottom: 5px">
									Applies for Refund <small>Able to get refund for admission?</small>
								</h4>
								<div id="toggle_refund" student_id="<?php echo $student_id; ?>"
									class="make-switch switch-small" data-on="success"
									data-off="danger" data-on-label="<i       class='fa fa-check'>
									</i>" data-off-label="<i class='fa fa-times'></i>"> <input
										type="checkbox"
										<?php echo $objectRow['refund'] == 't' ? "checked" : ""; ?>
										>
								</div>
								<hr />
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">

					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">
								<i class="fa fa-th-list"></i> Scheduled Activities
							</h3>
						</div>
						<div class="panel-body">


							<table class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<td><strong>Activity</strong></td>
										<td><strong>Mark Attended</strong></td>
										<td><strong>Grant Hours</strong></td>
									</tr>
								</thead>

								<?php 
								$query = "SELECT * FROM student_shifts ss, activity a, rooms r, time_slots ts WHERE student_id= $student_id AND ss.activity_id = a.activity_id AND a.room_id = r.room_id AND ts.slot_id = a.slot_id;";
								$result = $db->query($query);
								$affected_rows = mysqli_num_rows($result);
									
								for ($i = 0; $i < $affected_rows; $i++) {
									$row = $result->fetch_assoc();

									$currently_granted_hour = floor($row['hours_granted']*60 / 60);
									$currently_granted_min = round((($row['hours_granted'] - $currently_granted_hour) * 60), 0);

									?>
								<tr id="row_<?php echo $row['activity_id']; ?>">
									<td>
										<p style="margin: 0px;">
											<a href="activity.php?id=<?php echo $row['activity_id']; ?>"><?php echo $row['activity_name']; ?>
											</a> <small><?php echo $row['room_location']; ?> </small>
										</p>
										<p style="margin: 0px;">
											<small><?php echo date("F j, Y, g:i a", strtotime($row['start_time'])); ?>
												- <?php echo date("g:i a", strtotime($row['end_time'])); ?>
											</small>
										</p>
										<p style="margin: 0px;">
											<span class="label label-info">Currently granted <span
												id="<?php echo $row['activity_id']; ?>_<?php echo $student_id; ?>_hours_display"><?php echo $currently_granted_hour; ?>
											</span> hour(s), <span
												id="<?php echo $row['activity_id']; ?>_<?php echo $student_id; ?>_minutes_display"><?php echo $currently_granted_min; ?>
											</span> min(s).
											</span>
										</p>
										<p style="margin: 0px;">
											<button student_id="<?php echo $student_id; ?>"
												activity_id=<?php echo $row['activity_id']; ?> type="button"
												class="btn btn-danger btn-xs pull-right unschedule">Unschedule</button>
										</p>
									</td>

									<td><div id="attended"
											activity_id="<?php echo $row['activity_id']; ?>"
											student_id="<?php echo $student_id; ?>"
											class="make-switch switch-small" data-on="success"
											data-off="danger" data-on-label="<i       class='fa fa-check'>
											</i>" data-off-label="<i class='fa fa-times'></i>"> <input
												type="checkbox"
												<?php echo $row['attended'] == "t" ? "checked" : ""; ?>>
										</div></td>
									<td style="min-width: 325px;"><form class="form-inline"
											style="margin-bottom: 5px;">

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

											<select
												id="<?php echo $row['activity_id']; ?>_<?php echo $student_id; ?>_hours_input"
												style="width: 75px;" class='form-control input-sm'>
												<option
												<?php echo $activity_hours == "0" ? "selected" : ""?>>0</option>
												<option
												<?php echo $activity_hours == "1" ? "selected" : ""?>>1</option>
												<option
												<?php echo $activity_hours == "2" ? "selected" : ""?>>2</option>
												<option
												<?php echo $activity_hours == "3" ? "selected" : ""?>>3</option>
												<option
												<?php echo $activity_hours == "4" ? "selected" : ""?>>4</option>
											</select> hour(s) and <select
												id="<?php echo $row['activity_id']; ?>_<?php echo $student_id; ?>_minutes_input"
												style="width: 75px;" class='form-control input-sm'>
												<option <?php echo $activity_mins == "0" ? "selected" : ""?>>0</option>
												<option <?php echo $activity_mins == "5" ? "selected" : ""?>>5</option>
												<option
												<?php echo $activity_mins == "10" ? "selected" : ""?>>10</option>
												<option
												<?php echo $activity_mins == "15" ? "selected" : ""?>>15</option>
												<option
												<?php echo $activity_mins == "20" ? "selected" : ""?>>20</option>
												<option
												<?php echo $activity_mins == "25" ? "selected" : ""?>>25</option>
												<option
												<?php echo $activity_mins == "30" ? "selected" : ""?>>30</option>
												<option
												<?php echo $activity_mins == "35" ? "selected" : ""?>>35</option>
												<option
												<?php echo $activity_mins == "40" ? "selected" : ""?>>40</option>
												<option
												<?php echo $activity_mins == "45" ? "selected" : ""?>>45</option>
												<option
												<?php echo $activity_mins == "50" ? "selected" : ""?>>50</option>
												<option
												<?php echo $activity_mins == "55" ? "selected" : ""?>>55</option>
											</select> minute(s)
										</form>
										<button id="grant"
											activity_id="<?php echo $row['activity_id']; ?>"
											student_id="<?php echo $student_id; ?>"
											class="btn btn-primary btn-xs pull-right" type="button">Save</button>
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
							<p class="pull-right">Activities compatible with availability</p>
							<h3 class="panel-title">
								<i class="fa fa-thumb-tack"></i> Schedule
							</h3>
						</div>
						<div class="panel-body">

							<table
								class="datatable table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>Activity</th>
										<th>Type</th>
										<th>Location</th>
										<th>Start Time</th>
										<th>End Time</th>
										<th>Min</th>
										<th>Desired</th>
										<th>Max</th>
										<th>Cur. Sched.</th>
										<th></th>
									</tr>
								</thead>

								<?php 

								$query = "SELECT * FROM student_availability WHERE student_id = $student_id;";
								$result = $db->query($query);
								$affected_rows = mysqli_num_rows($result);

								$available_slots = array();
								for ($i = 0; $i < $affected_rows; $i++) {
									$row = $result->fetch_assoc();

									array_push($available_slots, $row["slot_id"]);

								}
									
								$query = "SELECT * FROM activity a, rooms r, time_slots ts WHERE a.room_id = r.room_id AND a.slot_id = ts.slot_id";
								$result = $db->query($query);
								$affected_rows = mysqli_num_rows($result);
									
									

								for ($i = 0; $i < $affected_rows; $i++) {
									$row = $result->fetch_assoc();
									$activity_id = $row["activity_id"];

									$result3 = $db->query("SELECT count(*) as count FROM student_shifts WHERE activity_id = $activity_id");
									$row3 = $result3->fetch_assoc();
									$numScheduled = $row3['count'];

									$query2 = "SELECT slot_id FROM covering_time_slots WHERE activity_id = $activity_id";
									$result2 = $db->query($query2);
									$affected_rows2 = mysqli_num_rows($result2);

									$covering_slots = array();
									for ($j = 0; $j < $affected_rows2; $j++) {
										$row2 = $result2->fetch_assoc();

										array_push($covering_slots, $row2["slot_id"]);
											
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
										<p style="margin: 0px;">
											<a href="activity.php?id=<?php echo $row["activity_id"]; ?>"><?php echo $row["activity_name"]; ?>
											</a>
										</p>
									</td>
									<td><?php echo $row["activity_type"]; ?></td>
									<td><?php echo $row["room_location"]; ?></td>
									<td><?php echo date("F j, Y, g:i a", strtotime($row['start_time'])); ?>
									</td>
									<td><?php echo date("F j, Y, g:i a", strtotime($row['end_time'])); ?>
									</td>
									<td><?php echo $row["min_workers"]; ?></td>
									<td><?php echo $row["desired_workers"]; ?></td>
									<td><?php echo $row["max_workers"]; ?></td>
									<td><?php echo $numScheduled; ?></td>
									<td>
										<button student_id="<?php echo $student_id; ?>"
											activity_id="<?php echo $row["activity_id"]; ?>"
											type="button"
											class="btn btn-success btn-xs pull-right schedule_manual">Schedule</button>
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


			<div class="row">
				<div class="col-lg-12">

					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">
								<i class="fa fa-envelope"></i> Email
							</h3>
						</div>
						<div class="panel-body">
							<div id="summernote">
								Hello
								<?php echo $objectRow['first_name'] . " " . $objectRow['last_name']; ?>
								,<br /> <br /> <br />
							</div>
							<br />
							<button id="send_student_email"
								student_id="<?php echo $student_id; ?>" type="button"
								class="btn btn-primary pull-right">Send</button>

						</div>
					</div>
				</div>
			</div>

			
			
			
			<!-- _______Notes starts here______________ -->
			<!-- _______Notes starts here______________ -->
			<!-- _______Notes starts here______________ -->
			<!-- _______Notes starts here______________ -->
			<!-- _______Notes starts here______________ -->
			
			
	<div class="row">
				<div class="col-lg-12">
	
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">
									<i class="fa fa-comments"></i> Notes
								</h3>
							</div>
							<div class="panel-body">
								<p><span class="label label-warning"><i class="fa fa-exclamation"></i></span> Click text below to edit note.</p>
								<a href="#" id="student_note" data-type="textarea" data-pk="<?php echo $student_id; ?>"><?php echo $objectRow['student_notes']; ?></a>
							</div>
						</div>
					</div>
					
				</div> </div>
			
			
			
			
			
			
			
	<!-- _______Notes ends here______________ -->
	<!-- _______Notes ends here______________ -->
	<!-- _______Notes ends here______________ -->		
			
			<?php
			}         //What's this for????!!!!!!
			?>

			<div class="row" id="not_found">
				<div class="col-lg-4 col-lg-offset-4">

					<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert"
							aria-hidden="true">&times;</button>
						Volunteer not found.
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

					<h2>Create New Volunteer</h2>
					<p>Enter the new volunteer's email address and instruct them to
							use the "Forgot Password?" feature. They will recieve a new
							password which they can change after logging in.</p>
					<div class="form-inline" role="form">
						<div class="form-group">
							<input type="email" class="form-control" id="new_vol_email"
								placeholder="Enter email">
						</div>
						<button type="button" id="new_vol" class="btn btn-primary">Create</button>
					</div>

					<hr />

					<table cellpadding="0" cellspacing="0" border="0"
						class="datatable table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>School</th>
								<th>Advisor</th>
								<th>Advisor Email</th>
								<th>Cur. Sched. Hours</th>
								<th>Notes</th>
							</tr>
						</thead>
						<tbody>

							<?php 
							$result = $db->query("SELECT * FROM students");
							$affected_rows = mysqli_num_rows($result);

							for ($i = 0; $i < $affected_rows; $i++) {
								$row = $result->fetch_assoc();

//								$result3 = $db->query("SELECT sum(hours_granted) as sum FROM student_shifts WHERE student_id={$row['student_id']}");
								$result3 = $db->query("SELECT sum(time_to_sec(timediff(TS.end_time, TS.start_time)) / 60) as sum FROM time_slots TS, activity A , 
students S, student_shifts SS where A.slot_id = TS.slot_id AND A.activity_id = SS.activity_id AND S.student_id = SS.student_id and S.student_id={$row['student_id']};");
								$row3 = $result3->fetch_assoc();
								$hoursScheduled = $row3['sum'] / 60;

								?>
							<tr style="font-size: 100%;">
							
								<?php 
								
								$fullName = ($row['first_name'] . " " . $row['last_name']) ==  " " ? "null" : $row['first_name'] . " " . $row['last_name'];
								
								?>
								
							
								<td><a href="volunteer.php?id=<?php echo $row['student_id']?>"><?php echo $fullName; ?>
								</a></td>
								<td><?php echo $row['email']; ?></td>
								<td><?php echo $row['school']; ?></td>
								<td><?php echo $row['advisor_name']; ?></td>
								<td><?php echo $row['advisor_email']; ?></td>
								<td><?php echo round($hoursScheduled, 2); ?></td>
								<td><?php echo $row['student_notes']; ?></td>
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
