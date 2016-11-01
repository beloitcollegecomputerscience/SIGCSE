<!DOCTYPE html>
<html lang="en">

<?php

// Access to global variables
require_once('global/include.php');

// Queries the database to see if login lock is on
$query = "SELECT locked FROM system_locks WHERE name = 'can_login'";
$result = $db->query($query);
$row = $result->fetch_assoc();

if ($row['locked'] != 't') {
	header('Location: '.SYSTEM_WEB_BASE_ADDRESS.'user/index.php');
}

// Include the head for every page
require_once(SYSTEM_WEBHOME_DIR.'user/php/head.php');

?>

<body>

	<div style="margin-top: 50px;" class="container">

		<div class="jumbotron col-lg-6 col-lg-offset-3">
			<p class="text-center">
				<i class="fa fa-exclamation fa-5x"></i>
			</p>
			<h2>SIGCSE Volunteer Registration</h2>
			<p class="lead">We'll be back shortly. Website is undergoing
				maintence.</p>
		</div>

	</div>

</body>
</html>
