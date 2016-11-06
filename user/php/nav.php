<?php 


function echoNav($system_text, $db, $isLoggedIn, $isAdmin, $page) {
		
	if ($isLoggedIn) {
		
		$query = "SELECT * FROM students WHERE students.student_id =".$_SESSION['student_id'];
		
		// Query the database
		$result = $db->query($query);
		$row = $result->fetch_assoc();
		
		// If user has a preferred name then address them as such otherwise use first name
		$displayName = $row['preferred_name'] == null ? $row['first_name'] : $row['preferred_name'];
		
		// Calculate the status of the two steps to display correct info on page.
		$stepOne = $row['profile_complete'] == "t" ? true : false;
		$stepTwo = $row['times_complete'] == "t" ? true : false;
	}
	
	?>
	
	<!-- Static navbar -->
	<div class="navbar navbar-inverse navbar-static-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse"
					data-target=".navbar-collapse">
					<span class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo SIGCSE_VOL_PAGE; ?>"><?php echo $system_text["nav"]["title"]; ?></a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li <?php echo $page == "index" ? "class='active'" : ""; ?>><a href="<?php echo SYSTEM_WEB_BASE_ADDRESS; ?>user/index.php"><?php echo $system_text["nav"]["home"]; ?></a></li>
					
					<?php
					if (!$isLoggedIn) {
						?>
						<li <?php echo $page == "register" ? "class='active'" : ""; ?>><a href="<?php echo SYSTEM_WEB_BASE_ADDRESS; ?>user/register.php"><?php echo $system_text["nav"]["register"]; ?></a></li>
						<?php
					}
					?>
					
					<?php
					if ($isLoggedIn) {
						?>
						<li <?php echo $page == "profile" ? "class='active'" : ""; ?>><a href="<?php echo SYSTEM_WEB_BASE_ADDRESS; ?>user/profile.php"><?php echo $system_text["nav"]["profile"]; ?></a></li>
						<?php
					}
					?>
					
					<li <?php echo $page == "faq" ? "class='active'" : ""; ?>><a href="<?php echo SYSTEM_WEB_BASE_ADDRESS; ?>user/faq.php"><?php echo $system_text["nav"]["faq"]; ?></a></li>
					<li <?php echo $page == "privacy" ? "class='active'" : ""; ?>><a href="<?php echo SYSTEM_WEB_BASE_ADDRESS; ?>user/privacy.php"><?php echo $system_text["nav"]["privacy"]; ?></a></li>
					
					<?php 
					if ($isAdmin) {
						?>
						<li><a href="<?php echo SYSTEM_WEB_BASE_ADDRESS; ?>admin/"><?php echo $system_text["nav"]["admin"]; ?></a></li>
						<?php
					}
					?>
					
				</ul>
				<ul class="nav navbar-nav navbar-right">
				
					<?php
					if (!$isLoggedIn) {
						?>
						<li><a href="<?php echo SYSTEM_WEB_BASE_ADDRESS; ?>user/index.php"><?php echo $system_text["nav"]["login"]; ?></a></li>
						<?php
					}
					?>
					
					<?php
					if ($isLoggedIn) {
						?>
						<li class="dropdown"><a href="#" class="dropdown-toggle"
							data-toggle="dropdown"><span class="fa fa-user"></span> <?php echo $displayName." ".$row['last_name']?> <b class="caret"></b>
						</a>
							<ul class="dropdown-menu">
	
								<li class="dropdown-header"><?php echo $system_text["nav"]["status"]; ?></li>
								<li><a href="<?php echo SYSTEM_WEB_BASE_ADDRESS; ?>user/register.php?two"><span class="label label-<?php echo $stepOne ? "success" : "warning"; ?>"><span
											class="fa fa-<?php echo $stepOne ? "check" : "exclamation"; ?>"></span></span> <?php echo $system_text["nav"]["update_info"]; ?>
								</a></li>
								<li><a href="<?php echo SYSTEM_WEB_BASE_ADDRESS; ?>user/register.php?three"><span class="label label-<?php echo $stepTwo ? "success" : "warning"; ?>"><span
											class="fa fa-<?php echo $stepTwo ? "check" : "exclamation"; ?>"></span></span> <?php echo $system_text["nav"]["update_avail"]; ?> </a></li>
								<li class="divider"></li>
								
								<li class="dropdown-header"><?php echo $system_text["nav"]["settings"]; ?></li>
								<li><a href="<?php echo SYSTEM_WEB_BASE_ADDRESS; ?>user/profile.php"><span class="label label-info"><span
											class="fa fa-user"></span></span> <?php echo $system_text["nav"]["profile"]; ?> </a>
								</li>
								<li><a href="<?php echo SYSTEM_WEB_BASE_ADDRESS; ?>user/password.php"><span class="label label-info"><span
											class="fa fa-gear"></span></span> <?php echo $system_text["nav"]["change_password"]; ?> </a>
								</li>
								
								<li class="divider"></li>
								<li><a href="<?php echo SYSTEM_WEB_BASE_ADDRESS; ?>user/logout.php"><span class="label label-danger"><span
											class="fa fa-power-off"></span></span> <?php echo $system_text["nav"]["logout"]; ?> </a>
								</li>
	
							</ul>
						</li>
						<?php
					}
					?>
					
				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</div>
	
	<?php 
}

?>