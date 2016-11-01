<!DOCTYPE html>
<html lang="en">

<?php

// Access to global variables
require_once('../global/include.php');

// Include the head for every page
require_once(SYSTEM_WEBHOME_DIR.'user/php/head.php');
?>

<body>

	<?php require(SYSTEM_WEBHOME_DIR."user/php/nav.php"); echoNav($system_text, $db, $isLoggedIn, $isAdmin, "profile"); ?>

	<div style="" class="container">

		<div class="row col-lg-10 col-lg-offset-1">


			<h2 style="margin-top: 0px;" class="text-center">Change Password</h2>

			<p style="font-size: 18px;" class="lead">Please enter your current
				and new password.</p>

			<p style="font-size: 18px; color: red;" class="lead">* are required</p>

			<hr />

			<div id="change_password_alert_success"
				class="alert alert-success col-lg-8 col-lg-offset-2"></div>
			<div id="change_password_alert_danger"
				class="alert alert-danger col-lg-8 col-lg-offset-2"></div>
			<script type="text/javascript"> $("#change_password_alert_success").hide(); </script>
			<script type="text/javascript"> $("#change_password_alert_danger").hide(); </script>

			<form class="form-horizontal" role="form">

				<div class="form-group">
					<label for="step_one_email" class="col-lg-3 control-label">Current
						Password<span style="color: red;">*</span>
					</label>
					<div class="col-lg-7">
						<input type="password" class="form-control" id="old_password">
					</div>
				</div>

				<div class="form-group">
					<label for="step_one_password" class="col-lg-3 control-label">New
						Password<span style="color: red;">*</span>
					</label>
					<div class="col-lg-7">
						<input type="password" class="form-control" id="new_password">
					</div>
				</div>

				<div class="form-group">
					<label for="step_one_confirm_password"
						class="col-lg-3 control-label">Confirm New Password<span
						style="color: red;">*</span>
					</label>
					<div class="col-lg-7">
						<input type="password" class="form-control"
							id="new_password_confirm">
					</div>
				</div>

				<div class="form-group">
					<div class="col-lg-offset-3 col-lg-9">
						<button id="change_password_submit" type="button"
							class="btn btn-primary">Submit</button>
					</div>
				</div>

			</form>
			<hr />

		</div>

	</div>

</body>
</html>
