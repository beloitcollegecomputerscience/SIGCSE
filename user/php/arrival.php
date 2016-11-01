<?php

// Access to global variables
require_once('../../global/include.php');

// Grab values
$student_id = $_SESSION['student_id'];
$slot_id = $_POST['slot_id'];

if (is_numeric($slot_id)) {

	// Set times_complete to 'f'
	$db->query("UPDATE students SET times_complete='f' WHERE student_id='$student_id'");

	// Remove student_departure for user
	$db->query("DELETE FROM student_departures WHERE student_id='$student_id'");

	// Remove student_arrival for user
	$db->query("DELETE FROM student_arrivals WHERE student_id='$student_id'");

	// Remove all student_availability for user
	$db->query("DELETE FROM student_availability WHERE student_id='$student_id'");

	// Set student_arrival for user
	$db->query("INSERT INTO student_arrivals (`student_id`, `slot_id`) VALUES ('$student_id', '$slot_id')");

	echo "true";

} else {

	echo "false";

}



?>
