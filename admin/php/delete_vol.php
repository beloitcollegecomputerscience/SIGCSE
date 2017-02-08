<!-- Licensed under the BSD. See License.txt for full text.  -->

<?php

// Access to global variables
require_once('../../global/include.php');

$student_id = $_POST['student_id'];

$query = "DELETE FROM student_arrivals WHERE student_id = $student_id;";
$db->query($query);

$query = "DELETE FROM student_availability WHERE student_id = $student_id;";
$db->query($query);

$query = "DELETE FROM student_departures WHERE student_id = $student_id;";
$db->query($query);

$query = "DELETE FROM student_shifts WHERE student_id = $student_id;";
$db->query($query);

$query = "DELETE FROM student_skills WHERE student_id = $student_id;";
$db->query($query);

$query = "DELETE FROM students WHERE student_id = $student_id;";
$db->query($query);

echo "true";


?>
