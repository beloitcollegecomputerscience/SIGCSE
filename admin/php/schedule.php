<?php

// Access to global variables
require_once('../../global/include.php');

$activity_ids = $_POST['activity_ids'];
$activity_ids = mysqli_real_escape_string($db->getDB(), $activity_ids);

$student_ids = $_POST['student_ids'];
$student_ids = mysqli_real_escape_string($db->getDB(), $student_ids);

if (($student_ids == "") || ($activity_ids == "")) {
	echo "false";
} else {

	//INSERT IGNORE INTO student_shifts (`student_id`, `activity_id`, `attended`, `form`, `hours_granted`) VALUES ('117', '452', 'f', 'f', '0'), ('117', '389', 'f', 'f', '0');

	$activity_ids = explode(",", $activity_ids);
	$student_ids = explode(",", $student_ids);

	$activity_ids = array_unique($activity_ids);
	$student_ids = array_unique($student_ids);

	$values = "";
	foreach ($student_ids as $student_id) {
		foreach ($activity_ids as $activity_id) {

			if (is_numeric($student_id) && is_numeric($activity_id)) {
				$values .= "('$student_id', '$activity_id', 'f', 'f', '0'),";
			}


		}
	}

	$values = substr($values, 0, -1);
	$query = "INSERT IGNORE INTO student_shifts (`student_id`, `activity_id`, `attended`, `form`, `hours_granted`) VALUES " . $values;
	$result = $db->query($query);
	echo "true";
}


?>
