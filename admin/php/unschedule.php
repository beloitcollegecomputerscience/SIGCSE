<?php 

// Access to global variables
require_once('../../global/include.php');

$student_id = $_POST['student_id'];
$activity_id = $_POST['activity_id'];
$query = "DELETE FROM student_shifts WHERE student_id = $student_id  and activity_id = $activity_id";
$result = $db->query($query);

?>