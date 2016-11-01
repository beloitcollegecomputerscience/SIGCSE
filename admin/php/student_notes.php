<?php

// Access to global variables
require_once('../../global/include.php');

$student_id = $_POST['pk'];
$value = $_POST['value'];

$student_id = mysqli_real_escape_string($db->getDB(), $student_id);
$value = mysqli_real_escape_string($db->getDB(), $value);

$query = "UPDATE students SET student_notes='$value' WHERE student_id='$student_id';";
$result = $db->query($query);

?>
