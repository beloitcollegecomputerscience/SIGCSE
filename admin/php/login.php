<?php 


// Access to global variables
require_once('../../global/include.php');

// 1 second delay to prevent attack
sleep(1);

// Make quick references to all form data
$email = mysqli_real_escape_string($db->getDB(), strtolower($_POST['email']));
// Hash the passwords for database checking
// Keep non-hashed password to check against the regex
$password = $_POST['password'];
$hashed_password = sha1($_POST['password']);

// Grab rows where database email == input email
$query = "SELECT * FROM admin WHERE email = '$email'";
$result = $db->query($query);
// Number of users with that email
$num_rows = mysqli_num_rows($result);

$row = $result->fetch_assoc();
$real_password = $row['password'];

if ($num_rows == 0) {
	echo "false"; # Email not recognized
} else if ($hashed_password != $real_password) {
	echo "false"; # Email recognized but password doesn't match
} else {
	
	// Mark a session variable to see if they are admin
	$_SESSION['admin_id'] = $row['admin_id'];;
	
	echo "true"; # Email recognized and password matches
}

?>