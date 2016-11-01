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

		<?php require("php/sidebar.php"); echoNav($db, "system_text"); ?>

		<div id="page-wrapper">

			<div class="row">
				<div class="col-lg-12">
					<h1>System Text</h1>
					<ol class="breadcrumb">
						<li><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a>
						</li>
						<li class="active"><i class="fa fa-pencil"></i> System Text</li>
					</ol>
				</div>
			</div>
			<!-- /.row -->

			<div class="row">

				<p class="lead" style="margin-left:20px">Edit all snippets of text accross the entire public site visable by volunteers.</p>

				<?php

				$page_result = $db->query("SELECT DISTINCT page from system_text");
				$affected_pages = mysqli_num_rows($page_result);

				for ($i = 0; $i < $affected_pages; $i++) {
					$page = $page_result->fetch_assoc();
					?>

					<div class="col-lg-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<p class="pull-right">Click value text to edit</p>
								<h3 class="panel-title">
									<i class="fa fa-pencil"></i> <?php echo $page['page']; ?>
								</h3>
							</div>
							<div class="panel-body">

								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<td style="width:25%;"><strong>Key</strong></td>
											<td><strong>Value</strong></td>
										</tr>
									</thead>

									<?php

									$text_result = $db->query("SELECT * FROM system_text WHERE page = '{$page['page']}'");
									$affected_text = mysqli_num_rows($text_result);

									for ($j = 0; $j < $affected_text; $j++) {
										$text = $text_result->fetch_assoc();
										?>

										<tr>
											<td><?php echo $text['key']; ?></td>
											<td><a href="#" class="system_text" data-type="textarea" data-pk="<?php echo $text['text_id']; ?>"><?php echo htmlentities($text['value']); ?></a></td>
										</tr>

									<?php
									}
									?>
								</table>

							</div>
						</div>
					</div>

				<?php
				}
				?>


			</div>

		</div>

		<?php require_once("footer.html"); ?>

	</div>


</body>
