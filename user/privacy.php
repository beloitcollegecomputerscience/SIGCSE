<!DOCTYPE html>
<html lang="en">

<?php 

// Access to global variables
require_once('../global/include.php');

// Include the head for every page
require_once(SYSTEM_WEBHOME_DIR.'user/php/head.php');
?>

<body>

	<?php require(SYSTEM_WEBHOME_DIR."user/php/nav.php"); echoNav($system_text, $db, $isLoggedIn, $isAdmin, "privacy"); ?>

	<div style="" class="container">

		<div class="row col-lg-10 col-lg-offset-1">


			<h2 style="margin-top: 0px;" class="text-center"><?php echo $system_text["user_privacy"]["title"]; ?></h2>

			<p style="font-size: 18px;" class="lead"><?php echo $system_text["user_privacy"]["description"]; ?></p>

			<ul>

				<li style="font-size: 18px;" class="lead"><?php echo $system_text["user_privacy"]["bullet_1"]; ?></li>
				<li style="font-size: 18px;" class="lead"><?php echo $system_text["user_privacy"]["bullet_2"]; ?></li>
				<li style="font-size: 18px;" class="lead"><?php echo $system_text["user_privacy"]["bullet_3"]; ?></li>


			</ul>

			<p style="font-size: 18px;" class="lead">
				<?php echo $system_text["user_privacy"]["questions"]; ?>
			</p>

			<hr />

		</div>

	</div>

	<?php require_once("footer.html") ?>
	
</body>
</html>
