<!-- Step Two -->
<div id="step_two">

	<h2 style="margin-top: 0px;" class="text-center"><?php echo $system_text["user_register_part2"]["title"]; ?></h2>

	<p style="font-size: 18px;" class="lead"><?php echo $system_text["user_register_part2"]["description"]; ?></p>

	<p style="font-size: 18px; color: red;" class="lead"><?php echo $system_text["user_register_part2"]["required"]; ?></p>

	<hr />

	<div id="step_two_alert_success"
		class="alert alert-success col-lg-8 col-lg-offset-2"></div>
	<div id="step_two_alert_danger"
		class="alert alert-danger col-lg-8 col-lg-offset-2"></div>
	<script type="text/javascript"> $("#step_two_alert_success").hide(); </script>
	<script type="text/javascript"> $("#step_two_alert_danger").hide(); </script>

	<form class="form-horizontal" role="form">
		<div class="form-group">
			<label for="step_two_first_name" class="col-lg-3 control-label"><?php echo $system_text["user_register_part2"]["first_name"]; ?><span style="color: red;">*</span>
			</label>
			<div class="col-lg-7">
				<input type="text" class="form-control" id="step_two_first_name"
					value="<?php echo (isset($user['first_name']) && $isLoggedIn) ? $user['first_name'] : ""; ?>">
			</div>
		</div>

		<div class="form-group">
			<label for="step_two_preferred_name"
				class="col-lg-3 control-label"><?php echo $system_text["user_register_part2"]["pref_name"]; ?></label>
			<div class="col-lg-7">
				<input type="text" class="form-control"
					id="step_two_preferred_name"
					value="<?php echo (isset($user['preferred_name']) && $isLoggedIn) ? $user['preferred_name'] : ""; ?>">
			</div>
		</div>

		<div class="form-group">
			<label for="step_two_last_name" class="col-lg-3 control-label"><?php echo $system_text["user_register_part2"]["last_name"]; ?><span style="color: red;">*</span>
			</label>
			<div class="col-lg-7">
				<input type="text" class="form-control" id="step_two_last_name"
					value="<?php echo (isset($user['last_name']) && $isLoggedIn) ? $user['last_name'] : ""; ?>">
			</div>
		</div>

		<br />

		<div class="form-group">
			<label for="step_two_phone" class="col-lg-3 control-label"><?php echo $system_text["user_register_part2"]["phone"]; ?></label>
			<div class="col-lg-7">
				<input type="text" class="form-control" id="step_two_phone"
					value="<?php echo (isset($user['cell_phone']) && $isLoggedIn) ? $user['cell_phone'] : ""; ?>">
			</div>
		</div>

		<div class="form-group">
			<label for="step_two_shirt_size" class="col-lg-3 control-label"><?php echo $system_text["user_register_part2"]["shirt_size"]; ?><span style="color: red;">*</span>
			</label>
			<div class="col-lg-2">
				<select id="step_two_shirt_size" class="form-control">
					<option>Choose</option>
					<option
					<?php echo (isset($user['tshirt_size']) && $isLoggedIn) && ($user['tshirt_size'] == "S") ? "selected" : ""; ?>>S</option>
					<option
					<?php echo (isset($user['tshirt_size']) && $isLoggedIn) && ($user['tshirt_size'] == "M") ? "selected" : ""; ?>>M</option>
					<option
					<?php echo (isset($user['tshirt_size']) && $isLoggedIn) && ($user['tshirt_size'] == "L") ? "selected" : ""; ?>>L</option>
					<option
					<?php echo (isset($user['tshirt_size']) && $isLoggedIn) && ($user['tshirt_size'] == "XL") ? "selected" : ""; ?>>XL</option>
					<option
					<?php echo (isset($user['tshirt_size']) && $isLoggedIn) && ($user['tshirt_size'] == "XXL") ? "selected" : ""; ?>>XXL</option>
				</select>
			</div>

			<span class="help-block"><?php echo $system_text["user_register_part2"]["shirt_info"]; ?></span>

		</div>

		<div class="form-group">
			<label for="step_two_experience" class="col-lg-3 control-label"><?php echo $system_text["user_register_part2"]["experience"]; ?><span style="color: red;">*</span>
			</label>
			<div class="col-lg-3">
				<select id="step_two_experience" class="form-control">
					<option
					<?php echo (isset($user['prior_experience']) && $isLoggedIn) && ($user['prior_experience'] == "None") ? "selected" : ""; ?>>None</option>
					<option
					<?php echo (isset($user['prior_experience']) && $isLoggedIn) && ($user['prior_experience'] == "Once") ? "selected" : ""; ?>>Once</option>
					<option
					<?php echo (isset($user['prior_experience']) && $isLoggedIn) && ($user['prior_experience'] == "More than once") ? "selected" : ""; ?>>More
						than once</option>
				</select>
			</div>
		</div>

		<br />

		<div class="form-group">
			<label for="step_two_school" class="col-lg-3 control-label"><?php echo $system_text["user_register_part2"]["school"]; ?><span
				style="color: red;">*</span>
			</label>
			<div class="col-lg-7">
				<input type="text" class="form-control" id="step_two_school"
					value="<?php echo (isset($user['school']) && $isLoggedIn) ? $user['school'] : ""; ?>">
			</div>
		</div>

		<div class="form-group">
			<label for="step_two_standing" class="col-lg-3 control-label"><?php echo $system_text["user_register_part2"]["standing"]; ?><span
				style="color: red;">*</span>
			</label>
			<div class="col-lg-3">
				<select id="step_two_standing" class="form-control">
					<option
					<?php echo (isset($user['standing']) && $isLoggedIn) && ($user['standing'] == "Undergrad") ? "selected" : ""; ?>>Undergrad</option>
					<option
					<?php echo (isset($user['standing']) && $isLoggedIn) && ($user['standing'] == "Graduate") ? "selected" : ""; ?>>Graduate</option>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label for="step_two_advisor" class="col-lg-3 control-label"><?php echo $system_text["user_register_part2"]["advisor"]; ?><span
				style="color: red;">*</span>
			</label>
			<div class="col-lg-7">
				<input type="text" class="form-control" id="step_two_advisor"
					value="<?php echo (isset($user['advisor_name']) && $isLoggedIn) ? $user['advisor_name'] : ""; ?>">
			</div>
		</div>

		<div class="form-group">
			<label for="step_two_advisor_email"
				class="col-lg-3 control-label"><?php echo $system_text["user_register_part2"]["advisor_email"]; ?><span
				style="color: red;">*</span>
			</label>
			<div class="col-lg-7">
				<input type="text" class="form-control"
					id="step_two_advisor_email"
					value="<?php echo (isset($user['advisor_email']) && $isLoggedIn) ? $user['advisor_email'] : ""; ?>">
			</div>
		</div>






		<!-- ___________
		______________
		_____look at this part below for Kids Camp question____
		___
		____ -->



			<div class="form-group">
			<label for="kids_camp_radio"
				class="col-lg-3 control-label">Volunteer with Kid's Camp<span
				style="color: red;">*</span>
			</label>
			<div class="col-lg-7">
				<div class="radio" id="kids_camp_result">
					  <label>
					    <input type="radio" name="kids_camp_radio" id="result_yes" value="1" >
					   		Yes
					  </label>
					    <label>
					    <input type="radio" name="kids_camp_radio" id="result_no" value="0" checked >
					   		No
					  </label>
					</div>
					<p>Explore computing with elementary and middle school aged kids through applications like Scratch and Kodu.  </p>
			</div>

		</div>





		<!-- ___________
		______________
		_____ENDS HERE____
		___
		____ -->






		<div class="form-group">
			<div class="col-lg-offset-3 col-lg-9">
				<button id="step_two_submit" type="button"
					class="btn btn-primary"><?php echo $system_text["user_register_part2"]["submit_button"]; ?></button>
				<button id="step_two_later" type="button"
					class="btn btn-warning"><?php echo $system_text["user_register_part2"]["skip"]; ?></button>
			</div>
		</div>
	</form>

	<hr />

</div>

<?php
if (!$stepTwo) {
	?>
<script type="text/javascript"> $("#step_two").hide(); </script>
<?php
}
?>
