<!DOCTYPE html>
<html lang="en">

<?php

// Access to global variables
require_once('../global/include.php');

// Include the head for every page
require_once(SYSTEM_WEBHOME_DIR.'user/php/head.php');
?>

<body>

	<?php require(SYSTEM_WEBHOME_DIR."user/php/nav.php"); echoNav($system_text, $db, $isLoggedIn, $isAdmin, "index"); ?>

	<?php

	$display = false;
	if ($isLoggedIn & $display) {
		?>
	<span class="label label-success">Logged In</span>
	<?php
	} else if (!$isLoggedIn & $display) {
		?>
	<span class="label label-danger">Not Logged In</span>
	<?php
	}
	?>

	<div style="" class="container">

		<div class="row col-lg-10 col-lg-offset-1">


			<h2 style="margin-top: 0px;" class="text-center"><?php echo $system_text["user_index"]["title"]; ?></h2>

			<p style="font-size: 18px;" class="lead"><?php echo $system_text["user_index"]["description"]; ?></p>


			<hr />

			<div class="row">

				<div class="col-lg-6 col-md-6 col-sm-6">

					<div class="text-center">
						<h3 class="center-text"><?php echo $system_text["user_index"]["login_title"]; ?></h3>
					</div>

					<div id="login_alert_success"
						class="alert alert-success col-lg-8 col-lg-offset-2"></div>
					<div id="login_alert_danger"
						class="alert alert-danger col-lg-8 col-lg-offset-2"></div>
					<script type="text/javascript"> $("#login_alert_success").hide(); </script>
					<script type="text/javascript"> $("#login_alert_danger").hide(); </script>

					<form class="form-horizontal" role="form">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label"><?php echo $system_text["user_index"]["login_email"]; ?></label>
							<div class="col-sm-7">
								<input type="email" class="form-control" id="login_email"
								<?php echo $isLoggedIn ? "disabled" : ""; ?>>
							</div>
						</div>

						<div class="form-group">
							<label for="inputPassword3" class="col-sm-3 control-label"><?php echo $system_text["user_index"]["login_password"]; ?></label>
							<div class="col-sm-7">
								<input type="password" class="form-control" id="login_password"
								<?php echo $isLoggedIn ? "disabled" : ""; ?>>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-6">

								<?php
								if ($isLoggedIn) {
									?>
								<a href="<?php echo SYSTEM_WEB_BASE_ADDRESS; ?>user/logout.php"><button type="button"
										class="btn btn-danger"><?php echo $system_text["user_index"]["logout_button"]; ?></button> </a>
								<?php
								} else {
									?>
								<button id="login_button" type="button" class="btn btn-primary"><?php echo $system_text["user_index"]["login_button"]; ?></button>
								<?php
								}
								?>

								<button id="forgot_button" type="button" class="btn btn-danger btn-xs"><?php echo $system_text["user_index"]["forgot_password_button"]; ?></button>

							</div>
						</div>
					</form>

				</div>

				<div class="col-lg-6 col-md-6 col-sm-6">

					<div class="alert alert-warning">
						<?php echo $system_text["user_index"]["registration_warning"]; ?>
					</div>

					<div class="text-center">
						<h3 class="center-text"><?php echo $system_text["user_index"]["register_title"]; ?></h3>
					</div>

					<form class="form-horizontal" role="form" action="<?php echo SYSTEM_WEB_BASE_ADDRESS; ?>user/register.php"
						method="post">
						<div class="form-group">
							<label for="step_one_first_name" class="col-lg-3 control-label"><?php echo $system_text["user_register"]["register_first_name"]; ?></label>
							<div class="col-lg-7">
								<input type="text" class="form-control"
									name="step_one_first_name"
									<?php echo $isLoggedIn ? "disabled" : ""; ?>>
							</div>
						</div>

						<div class="form-group">
							<label for="step_one_last_name" class="col-lg-3 control-label"><?php echo $system_text["user_register"]["register_last_name"]; ?></label>
							<div class="col-lg-7">
								<input type="text" class="form-control"
									name="step_one_last_name"
									<?php echo $isLoggedIn ? "disabled" : ""; ?>>
							</div>
						</div>

						<div class="form-group">
							<label for="step_one_email" class="col-lg-3 control-label"><?php echo $system_text["user_register"]["register_email"]; ?></label>
							<div class="col-lg-7">
								<input type="email" class="form-control" name="step_one_email"
								<?php echo $isLoggedIn ? "disabled" : ""; ?>>
							</div>
						</div>

						<div class="form-group">
							<label for="step_one_password" class="col-lg-3 control-label"><?php echo $system_text["user_register"]["register_password"]; ?></label>
							<div class="col-lg-7">
								<input type="password" class="form-control"
									name="step_one_password"
									<?php echo $isLoggedIn ? "disabled" : ""; ?>>
							</div>
						</div>

						<div class="form-group">
							<label for="step_one_confirm_password"
								class="col-lg-3 control-label"><?php echo $system_text["user_register"]["register_confirm_password"]; ?></label>
							<div class="col-lg-7">
								<input type="password" class="form-control"
									name="step_one_confirm_password"
									<?php echo $isLoggedIn ? "disabled" : ""; ?>>
							</div>
						</div>

						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-9">



															<?php
								if (!$isAdmin) {
									?>
								<button id="step_one_submit" type="submit"
									class="btn btn-primary"
									<?php echo $isLoggedIn ? 'disabled="disabled"' : ""; ?>><?php echo $system_text["user_register"]["register_button"]; ?></button>
								<?php
								} else {
									?>
								<button id="step_one_submit_admin" type="submit"
									class="btn btn-primary"
									<?php echo $isLoggedIn ? 'disabled="disabled"' : ""; ?>><?php echo $system_text["user_register"]["register_button"]; ?></button>
								<?php
								}
								?>





							</div>
						</div>
					</form>

				</div>

			</div>

			<hr />

		</div>

	</div>

	<?php require_once("footer.html") ?>

</body>

</html>
