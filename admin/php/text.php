<?php

// Access to global variables
require_once('../../global/include.php');

$text_id = $_POST['pk'];
$value = $_POST['value'];

$text_id = mysqli_real_escape_string($db->getDB(), $text_id);
$value = mysqli_real_escape_string($db->getDB(), $value);

$query = "UPDATE system_text SET value='$value' WHERE text_id='$text_id';";
$result = $db->query($query);

?>
