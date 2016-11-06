<?php 

// Access to global variables
require_once('../../global/include.php');

// TODO: could change password - don't do?
$currentPassword = mysqli_real_escape_string($db->getDB(), $_POST['old_password']);
$newPassword = mysqli_real_escape_string($db->getDB(), $_POST['new_password']);
$confirmPassword = mysqli_real_escape_string($db->getDB(), $_POST['new_password_confirm']);

// Hash all posted passwords
$hashed_currentPassword = sha1($currentPassword);
$hashed_newPassword = sha1($newPassword);
$hashed_confirmPassword = sha1($confirmPassword);
// TODO: if want, check hashed for nasty stuff and reject.

// Grab user's data
$query = "SELECT * FROM admin WHERE admin_id={$_SESSION['admin_id']}";
$result = $db->query($query);
$row = $result->fetch_assoc();

// If currentPassword isn't same as in database then error
if ($row['password'] != $hashed_currentPassword) {
	echo "err1";
} else

// If the 2 new passwords aren't the same then error
	if ($hashed_newPassword != $hashed_confirmPassword) {
echo "err2";
} else

// If the new password isn't valid error
	if (checkPass($newPassword) == false) {
echo "err3";
} else {

	// If we get passed all those redirects then it is same to update the password.
	$query = "UPDATE admin SET password='$hashed_newPassword' WHERE admin_id={$_SESSION['admin_id']}";
	$db->query($query);
	echo "true";
}



?>