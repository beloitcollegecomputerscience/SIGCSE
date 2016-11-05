<?php 
/*
 passwordchangeprocess.php
-------------
- Checks if the password is the same as the old one and the 2 new ones are identical and valid.
- Redirects to profile when successful, back to passwordchange when not.
*/

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
$query = "SELECT * FROM students WHERE student_id={$_SESSION['student_id']}";
$result = $db->query($query);
$row = $result->fetch_assoc();

// If currentPassword isn't same as in database then error
if ($row['password'] != $hashed_currentPassword) {
	//header('Location: '.SYSTEM_WEB_BASE_ADDRESS.'passwordchange.php?err1&');
	echo "err1";
} else

// If the 2 new passwords aren't the same then error
if ($hashed_newPassword != $hashed_confirmPassword) {
	//header('Location: '.SYSTEM_WEB_BASE_ADDRESS.'passwordchange.php?err2&');
	echo "err2";
} else

// If the new password isn't valid error
if (checkPass($newPassword) == false) {
	//header('Location: '.SYSTEM_WEB_BASE_ADDRESS.'passwordchange.php?err3&');
	echo "err3";
} else {

	// If we get passed all those redirects then it is same to update the password.
	$query = "UPDATE students SET password='$hashed_newPassword' WHERE student_id={$_SESSION['student_id']}";
	$db->query($query);
	//header('Location: '.SYSTEM_WEB_BASE_ADDRESS.'profile.php?passchange');
	echo "true";
}

?>