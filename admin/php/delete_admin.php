<?php 

// Access to global variables
require_once('../../global/include.php');

$admin_id = $_POST['admin_id'];
$admin_id = mysqli_real_escape_string($db->getDB(), $admin_id);

$query = "DELETE FROM admin WHERE admin_id = $admin_id";
$result = $db->query($query);

if ($admin_id == $_SESSION['admin_id']) {
	echo "true2";
} else {
	echo "true";
}


?>