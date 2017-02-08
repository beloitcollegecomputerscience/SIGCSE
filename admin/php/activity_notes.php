<!-- Licensed under the BSD. See License.txt for full text.  -->

<?php

// Access to global variables
require_once('../../global/include.php');

$activity_id = $_POST['pk'];
$value = $_POST['value'];

$activity_id = mysqli_real_escape_string($db->getDB(), $activity_id);
$value = mysqli_real_escape_string($db->getDB(), $value);

$query = "UPDATE activity SET activity_notes='$value' WHERE activity_id='$activity_id';";
$result = $db->query($query);

?>
