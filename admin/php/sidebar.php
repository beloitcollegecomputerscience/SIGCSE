<?php 

function echoNav($db, $page) {
	
	// Query the database
	$query = "SELECT * FROM admin WHERE admin_id =".$_SESSION['admin_id'];
	$result = $db->query($query);
	$row = $result->fetch_assoc();
	
	?>

<!-- Sidebar -->
<nav
	class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse"
			data-target=".navbar-ex1-collapse">
			<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span>
			<span class="icon-bar"></span> <span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="index.php">SIGCSE Admin</a>
	</div>

	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse navbar-ex1-collapse">
		<ul class="nav navbar-nav side-nav">
			<li <?php echo $page == "index" ? "class='active'" : ""; ?>><a href="index.php"><i class="fa fa-dashboard"></i>
					Dashboard</a></li>
			<li <?php echo $page == "schedule" ? "class='active'" : ""; ?>><a href="schedule.php"><i class="fa fa-list-alt"></i> Daily Schedule</a></li>
			<li <?php echo $page == "volunteer" ? "class='active'" : ""; ?>><a href="volunteer.php"><i class="fa fa-users"></i> Volunteers</a>
			</li>
			<li <?php echo $page == "activity" ? "class='active'" : ""; ?>><a href="activity.php"><i class="fa fa-th"></i> Activities</a>
			</li>
			<li <?php echo $page == "assign" ? "class='active'" : ""; ?>><a href="assign.php"><i class="fa fa-thumb-tack"></i> Manually Schedule</a>
			</li>
			<li <?php echo $page == "query" ? "class='active'" : ""; ?>><a href="query.php"><i class="fa fa-folder-open"></i> Queries</a>
			</li>
			<li <?php echo $page == "system_text" ? "class='active'" : ""; ?>><a href="system_text.php"><i class="fa fa-pencil"></i> System Text</a>
			</li>
			<li <?php echo $page == "admin" ? "class='active'" : ""; ?>><a href="admin.php"><i class="fa fa-gear"></i> Administrators</a>
			</li>
			<li ><a href="../user/index.php"><i class="fa fa-arrow-left"></i> Public Site</a></li>
		</ul>

		<ul class="nav navbar-nav navbar-right navbar-user">
			<li class="dropdown user-dropdown"><a href="#"
				class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>
					<?php echo $row['email']; ?> <b class="caret"></b> </a>
				<ul class="dropdown-menu">
					<li><a href="logout.php"><i class="fa fa-power-off"></i> Log Out</a></li>
				</ul>
			</li>
		</ul>
	</div>
	<!-- /.navbar-collapse -->
</nav>

<?php
}
?>

