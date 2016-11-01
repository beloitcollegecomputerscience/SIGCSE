<!DOCTYPE html>
<html lang="en">

<?php

// Access to global variables
require_once('../global/include.php');

// Include the head for every page
require_once(SYSTEM_WEBHOME_DIR.'user/php/head.php');

$stepTwo = isset($_GET['two']) ? true : false;
$stepThree = (isset($_GET['three']) & !$stepTwo) ? true : false;
$stepOne = (!$stepTwo && !$stepThree) ? true : false;

if ($stepOne && $isLoggedIn) {
	header('Location: '.SYSTEM_WEB_BASE_ADDRESS.'user/profile.php');
}

if (($stepTwo || $stepThree) && !$isLoggedIn) {
	header('Location: '.SYSTEM_WEB_BASE_ADDRESS.'user/index.php');
}

if ($isLoggedIn) {
	$query = "SELECT * FROM students WHERE students.student_id =".$_SESSION['student_id'];
	// Query the database
	$result = $db->query($query);
	$user = $result->fetch_assoc();
}

?>

<body>
	<?php require(SYSTEM_WEBHOME_DIR."user/php/nav.php"); echoNav($system_text, $db, $isLoggedIn, $isAdmin, "register"); ?>

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

	<div style="margin-top: -40px" class="container">
		<div class="row col-lg-10 col-lg-offset-1">



			<!-- Indicators to let user know what step they are on -->
			<div class="row text-center" style="margin-top: 50px">
				<p>
				  <button id="step_one_indicator_2" disabled="disabled" type="button" class="btn btn-<?php echo $stepOne ? "primary" : "default"; ?> btn-lg">Step #1</button>
				  <button id="step_two_indicator_2" <?php echo $stepOne ? "disabled='disabled'" : ""; ?> type="button" class="btn btn-<?php echo $stepTwo ? "primary" : "default"; ?> btn-lg">Step #2</button>
				  <button  id="step_three_indicator_2" <?php echo $stepOne ? "disabled='disabled'" : ""; ?> type="button" class="btn btn-<?php echo $stepThree ? "primary" : "default"; ?> btn-lg">Step #3</button>
				</p>
			</div>

			<br />

			<!-- Canvas to hold the multiple steps -->
			<div id="canvas" class="">

				<input type="hidden" id="redirect"
					value="<?php echo ($stepTwo || $stepThree) ? "profile" : ""?>">

				<?php require_once("reg_sections/step_one.php"); ?>

				<?php require_once("reg_sections/step_two.php"); ?>

				<?php require_once("reg_sections/step_three_2.php"); ?>

			</div>
		</div>

		<hr />

	</div>

	<?php require_once("footer.html") ?>

</body>
</html>

<?php

if (isset($_POST['step_one_first_name'])) {
	?>
<script>

		setTimeout(function() {
			$("#step_one_submit").click();
		}, 2000);

	</script>
<?php
}

?>
