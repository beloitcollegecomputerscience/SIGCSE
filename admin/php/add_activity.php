<!DOCTYPE html>
<html lang="en">
<?php
/*
this is the form that the admin is going to fill out to add the activity.
admin is directed to this page after clicking on the add activity button on the activity page.
*/

// Access to global variables
require_once('../../global/include.php');

// Make sure user is allowed to view admin area
if (!$isAdmin) {
	header('Location: '.SYSTEM_WEB_BASE_ADDRESS.'admin/login.php');
}
//add_activity.js is added to the head php so can be used here.
require("head.php");
?>

  
<script></script>
<body>


<div class="col-lg-6 col-md-6 col-sm-6">	

<!-- heading -->
					<div class="text-center">
						<h3 class="center-text"> Create New Activity</h3>
						<p>&nbsp;</p>
					</div>
<!-- input for activity name -->
					<form class="form-horizontal" role="form" action="add_form.php" method="post" id="add_activity_form" >
						
						
						<div class="form-group">
							<label for="activity_name" class="col-lg-3 control-label ">Activity Name<span
				style="color: red;">*</span></label>
							<div class="col-lg-7">
								<input type="text" class="form-control required" id="activity_name"
									
									>
							</div>
						</div>

						
						
<!-- input for activity type,
use select tag here to do a dropdown selection. get all the differnent activity_type from the activity table. put each one of them as the value of a option.  -->	
											
								<div class="form-group">
							<label for="activity_type" class="col-lg-3 control-label">Activity Type<span
				style="color: red;">*</span></label>
							<div class="col-lg-7">
							
							
	<select class="form-control" id="activity_type">
	<?php 
							$result = $db->query("SELECT distinct activity_type from activity ORDER by activity_type");
							$affected_rows = mysqli_num_rows($result); 							
							for ($i = 0; $i < $affected_rows; $i++) {
								$row = $result->fetch_assoc();
								$value= $row['activity_type'];
								?>
    <option value= '<?php echo $value?>' >  <?php echo $value?>   </options>

							<?php
							}
							?>
							<!-- admin can choose other if none of the type fits -->
 <option value="Other">Other</option>
  </select>								
													
								
								
							</div>
						</div>
						
							
						
<!-- this is the input for the admin to input an new type, this is hidden unless other is chosen on the dropdown list, this is down in the add_activity.js -->						
<div class="form-group" id="other_activity_type_form" style="display:none;">
							
							<div class="col-lg-7">
							<label> input new type:<span
				style="color: red;">*</span>
								<input type="text" class="form-control required" id="other_activity_type"
									 
									> </label>
							</div>
						</div>	

						
						
						
						
<!-- dropdown for location, query database to get the locations, but the correponding room_id is in the value of each option instead of the name of the location. but the name of the location is shown to the admin. -->
						<div class="form-group">
							<label for="activity_location" class="col-lg-3 control-label">Activity Location<span
				style="color: red;">*</span></label>
							<div class="col-lg-7">
								
															
<select class="form-control" id="activity_location">

<?php 
							$result = $db->query("SELECT * from rooms ORDER by room_location");
							$affected_rows = mysqli_num_rows($result);							
							for ($i = 0; $i < $affected_rows; $i++) {
								$row = $result->fetch_assoc();
								$value= $row['room_location'];
								?>
								<option value= '<?php echo $row['room_id']?>' ><?php echo $value; ?></option>
							
							<?php
							}
							?>
							<!-- this other may not work -->
 <option value="Other">Other</option>
  </select>									
							</div>
						</div>
						
						
			<div class="form-group" id="other_activity_location_form" style="display:none">
							
							<div class="col-lg-7">
							<label> input new location:<span
				style="color: red;">*</span>
								<input type="text" class="form-control required" id="other_activity_location"
									 
									> </label>
							</div>
						</div>			
						
						
						
						
<!-- dropdown list for organizer -->						
						<div class="form-group">
							<label for="activity_organizer" class="col-lg-3 control-label">Activity Organizer<span
				style="color: red;">*</span></label>
							<div class="col-lg-7">					
	<select class="form-control" id="activity_organizer">
	<?php 
							$result = $db->query("SELECT * from organizer order by first_name, last_name");
							$affected_rows = mysqli_num_rows($result); 							
							for ($i = 0; $i < $affected_rows; $i++) {
								$row = $result->fetch_assoc();
								$value= $row['first_name']." ".$row['last_name'];
								$organizer_id=$row['organizer_id'];
								?>
    <option value= '<?php echo $organizer_id?>' ><?php echo $value?></options>

							<?php
							}
							?>
							
 <option value="Other">Other</option>
  </select>									
							</div>
						</div>
						
 			 	<div class="form-group" id="other_activity_organizer_form" style="display:none">
							
							<div class="col-lg-7">
							<label> input new organizer first name:<span
				style="color: red;">*</span>
								<input type="text" class="form-control required" id="other_activity_organizer_first"
									></label>
								<label> input new organizer last name:<span
				style="color: red;">*</span> <input type="text" class="form-control required" id="other_activity_organizer_last"
									 
									></label>
							</div>
						</div>	
						
						
						
						
						
							
<!-- start time and end time. Havent down. right now just number input but has to be changed -->
						<div class="form-group">
							<label for="activity_start_time" class="col-lg-3 control-label">Start Time<span
				style="color: red;">*</span></label>
							<div class="col-lg-7">
								
 
 <div class="input-group date form_date col-md-9"  data-date-format="yyyy-mm-dd  hh:ii:00" >
                    <input class="form-control required"  type="datetime" readonly id="activity_start_time" >
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>         




							</div>
						</div>
						
						
						

						<div class="form-group">
							<label for="activity_end_time" class="col-lg-3 control-label">End Time<span
				style="color: red;">*</span></label>
							<div class="col-lg-7">
								
 
 <div class="input-group date form_date col-md-9"  data-date-format="yyyy-mm-dd  hh:ii:00" >
                    <input class="form-control required"  type="datetime" readonly id="activity_end_time" >
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>         



							</div>
						</div>
						
						
	<!-- these are just input numbers -->					
						<div class="form-group">
							<label for="min_num"
								class="col-lg-3 control-label">Min Number<span
				style="color: red;">*</span></label>
							<div class="col-lg-7">
								<input type="number" min=0 class="form-control required" id="min_num"
									
									>
							</div>
						</div>
						
						<div class="form-group">
							<label for="desired_num"
								class="col-lg-3 control-label">Desired Number<span
				style="color: red;">*</span></label>
							<div class="col-lg-7">
								<input type="number" min =0 class="form-control required" id="desired_num"
									
									>
							</div>
						</div>
						
						<div class="form-group">
							<label for="max_num"
								class="col-lg-3 control-label">Max Number<span
				style="color: red;">*</span></label>
							<div class="col-lg-7">
								<input type="number" min=0 class="form-control required" id="max_num"
									
									>
							</div>
						</div>
						
						
							<div class="form-group">
							<label for="activity_notes"
								class="col-lg-3 control-label">Notes</label>
							<div class="col-lg-7">
							<textarea class="form-control" rows="5" id="activity_notes"></textarea>	
							</div>
						</div>
						
<!-- buttons. When create actvity button is clicked the input will be processed. see add_activity.js -->
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-9">
							
								<button id="add_activity_submit" type="button"
									class="btn btn-primary"
									s>Create Activity</button>
								<button id="add_activity_reset" type="reset"
									class="btn btn-primary"
									s>Reset</button>
									<a href="../activity.php" class="btn btn-link" role="button">Back</a>
							</div>
						</div>
		
					</form>

				</div>

			</div>
			
	<script type="text/javascript">

	$('.form_date').datetimepicker({
        language:  'en',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse:0,
		showMeridian:1
    });

</script>		
</body>
</html>

	