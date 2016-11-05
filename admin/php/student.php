<?php

// Access to global variables
require_once('../../global/include.php');

// Used to define which button the user has clicked
$func = $_POST['func'];

// Based on what the user clicked, will direct the path of the switch
switch ($func) {
	case "ToggleCheckedIn":
		toggleCheckedIn($db, $_POST['student_id']);
		break;
	case "ToggleRefund":
		togglerRefund($db, $_POST['student_id']);
		break;
	case "ToggleAttendedActivity":
		toggleAttendedActivity($db, $_POST['student_id'], $_POST['activity_id']);
		break;
	case "ToggleTimesComplete":
		toggleTimesComplete($db, $_POST['student_id']);
		break;
	case "GrantHours":
		grantHours($db, $_POST['student_id'], $_POST['activity_id'], $_POST['hours'], $_POST['minutes']);
		break;
	case "SaveStudentNotes":
		$new_student_notes = mysqli_real_escape_string($db->getDB(), $_POST["new_student_notes"]);
		$student_id =$_POST["student_id"];
		$db->query("update students set student_notes = '$new_student_notes' WHERE student_id = $student_id;");
		
}

function toggleTimesComplete($db, $student_id) {

	// Get current info on refund
	$result = $db->query("SELECT * FROM students WHERE student_id = $student_id;");
	$row = $result->fetch_assoc();
	//TODO what if student not valid?
	$oldAtt = $row['times_complete'];

	// Toggle value
	$newAtt = $oldAtt == "t" ? "f" : "t";

	// Update the new value
	$query = "UPDATE students SET times_complete='$newAtt' WHERE student_id='$student_id'";
	$db->query($query);

}

function togglerRefund($db, $student_id) {
	
	// Get current info on refund
	$result = $db->query("SELECT * FROM students WHERE student_id = $student_id;");
	$row = $result->fetch_assoc();
	//TODO what if student not valid?
	$oldAtt = $row['refund'];
	
	// Toggle value
	$newAtt = $oldAtt == "t" ? "f" : "t";
	
	// Update the new value
	$query = "UPDATE students SET refund='$newAtt' WHERE student_id='$student_id'";
	$db->query($query);
	
}

function toggleCheckedIn($db, $student_id) {
	
	// Get current info on checked in
	$result = $db->query("SELECT * FROM students WHERE student_id = $student_id;");
	$row = $result->fetch_assoc();
	//TODO what if student not valid?
	$oldAtt = $row['checked_in'];
	
	// Toggle value
	$newAtt = $oldAtt == "t" ? "f" : "t";
	
	// Update the new value 
	$query = "UPDATE students SET checked_in='$newAtt' WHERE student_id='$student_id'";
	$db->query($query);
}

function toggleAttendedActivity($db, $student_id, $activity_id) {
	
	// Get current info on attended
	$result = $db->query("SELECT * FROM student_shifts ss WHERE ss.student_id = $student_id AND ss.activity_id = $activity_id;");
	$row = $result->fetch_assoc();
	//TODO what if student/activity not valid?
	$oldAtt = $row['attended'];
	
	// Toggle value
	$newAtt = $oldAtt == "t" ? "f" : "t";
	
	// Update the new value
	$query = "UPDATE student_shifts SET attended='$newAtt' WHERE student_id='$student_id' AND activity_id='$activity_id'";
	$db->query($query);
}

function grantHours($db, $student_id, $activity_id, $hours, $minutes) {
	
	// Calculate value in terms of hours
	$value = ((($hours * 60) + $minutes) / 60);
	
	// Update the value and send back to schedule
	$query = "UPDATE student_shifts SET hours_granted='$value' WHERE student_id='$student_id' and activity_id='$activity_id'";
	$result = $db->query($query);
	
	// Get hours currently granted
	$result = $db->query("SELECT sum(hours_granted) as sum FROM student_shifts WHERE student_id=$student_id");
	$row = $result->fetch_assoc();
	$hoursScheduled = $row['sum'];
	
	// If more than 5 hours, grant them a refund.
	if ($hoursScheduled > 5.0) {
		$query = "UPDATE students SET refund='t' WHERE student_id='$student_id'";
		$db->query($query);
	}
	
}

?>