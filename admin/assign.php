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

		<?php require("php/sidebar.php"); echoNav($db, "assign"); ?>

		<div id="page-wrapper">

			<div class="row">
				<div class="col-lg-12">
					<h1>Manual Schedule Volunteers</h1>
					<ol class="breadcrumb">
						<li><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a>
						</li>
						<li class="active"><i class="fa fa-thumb-tack"></i> Manual
							Schedule Volunteers</li>
					</ol>
				</div>
			</div>
			<!-- /.row -->

			<div class="row">

				<p class="lead" style="margin-left: 20px">Schedule 1 or more
					volunteers to 1 or more activities.</p>

			</div>

			<div class="row">
				<div class="col-lg-5">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<p class="pull-right">To be scheduled</p>
							<h3 class="panel-title">
								<i class="fa fa-users"></i> Volunteers
							</h3>
						</div>
						<div class="panel-body">

							<ul id="volunteer_list" class="list-group">
							</ul>
						</div>
					</div>
				</div>

				<div class="col-lg-2 text-center">
					<p style="margin-top:10px"><i class="fa fa-arrow-right fa-5x"></i></p>
					<p><button id="schedule_assign" type="button" class="btn btn-primary">Schedule</button></p>
				</div>

				<div class="col-lg-5">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<p class="pull-right">To be scheduled</p>
							<h3 class="panel-title">
								<i class="fa fa-th"></i> Activities
							</h3>
						</div>
						<div class="panel-body">

							<ul id="activity_list" class="list-group">
							</ul>
						</div>
					</div>
				</div>
			</div>

			<hr />

			<div class="row">

				<div class="col-lg-6">
					<h3>Add Volunteers</h3>

					<table class="datatable table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<td><strong>Volunteers</strong></td>
							</tr>
						</thead>

						<?php

						$result = $db->query("SELECT * FROM students");
						$affected_rows = mysqli_num_rows($result);

						for ($i = 0; $i < $affected_rows; $i++) {
							$row = $result->fetch_assoc();
							?>
						<tr>
							<td>
								<button id="<?php echo $row["student_id"]; ?>" type="button" class="btn btn-success btn-xs pull-right add_volunteer"><i class="fa fa-plus"></i></button>

								<div id="<?php echo $row["student_id"]; ?>_stu_title">
									<p style="margin:0px;"><a href="volunteer.php?id=<?php echo $row["student_id"]; ?>"><?php echo $row["first_name"]." ".$row["last_name"]; ?></a></p>
									<p style="margin:0px;"><small><?php echo $row["email"]; ?></small></p>
								</div>
							</td>
						</tr>

						<?php
						}
						?>
					</table>
				</div>

				<div class="col-lg-6">
					<h3>Add Activities</h3>

					<table class="datatable table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<td><strong>Activities</strong></td>
							</tr>
						</thead>

						<?php

						$result = $db->query("SELECT * FROM activity a, rooms r, time_slots ts WHERE a.room_id = r.room_id AND a.slot_id = ts.slot_id");
						$affected_rows = mysqli_num_rows($result);

						for ($i = 0; $i < $affected_rows; $i++) {
							$row = $result->fetch_assoc();
							?>
						<tr>
							<td>
								<button id="<?php echo $row["activity_id"]; ?>" type="button" class="btn btn-success btn-xs pull-right add_activity"><i class="fa fa-plus"></i></button>

								<div id="<?php echo $row["activity_id"]; ?>_act_title">
									<p style="margin:0px;"><a href="activity.php?id=<?php echo $row["activity_id"]; ?>"><?php echo $row["activity_name"]; ?></a> - <small><?php echo $row["room_location"]; ?></small></p>
									<p style="margin:0px;"><small><?php echo date("F j, Y, g:i a", strtotime($row['start_time'])); ?> - <?php echo date("F j, Y, g:i a", strtotime($row['end_time'])); ?></small></p>
								</div>
							</td>
						</tr>

						<?php
						}
						?>
					</table>
				</div>

			</div>

		</div>

		<?php require_once("footer.html"); ?>

	</div>


</body>
