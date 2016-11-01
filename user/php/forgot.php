<?php
/*
 passwordrecoveryprocess.php
-------------
- Checks if the email even exists in our records, if it does then reset the password and send them an email.
- Redirects to login when successful, back to passwordrecovery when not.
*/

// Access to global variables
require_once('../../global/include.php');

// 1 second delay to prevent attack
sleep(1);

// grab posted data
$email = mysqli_real_escape_string($db->getDB(), $_POST['email']);

// See how many users in the DB have that email
$query = "SELECT count(*) as count FROM students WHERE email='$email' GROUP BY student_id";
$result = $db->query($query);
$row = $result->fetch_assoc();
$count = $row['count'];

// If only 1 person, then it is a match and we can set the password to something random
if ($count == 1) {

	// Find the student_id of the user we have a match with
	$query = "SELECT student_id FROM students WHERE email='$email'";
	$result = $db->query($query);
	$row = $result->fetch_assoc();
	$student_id = $row['student_id'];

	// Generate password and set it in the DB
	$newPass = generatePassword();
	$query = "UPDATE students SET password=SHA1('$newPass') WHERE student_id='$student_id'";
	$result = $db->query($query);

	// Email the user the new password
	sendPasswordRecoveryEmail($email, $newPass);

	// Send back to login
	//header('Location: '.SYSTEM_WEB_BASE_ADDRESS.'login.php?newpass');
	echo "true";


} else {
	// no match with password so send back to password recovery
	//header('Location: '.SYSTEM_WEB_BASE_ADDRESS.'passwordrecovery.php?bademail');
	echo "err1";

}

// Function to generate passwords
function generatePassword ($length = 8){

	// start with a blank password
	$password = "";

	// TODO: force password change if this done.
	// define possible characters - any character in this string can be
	// picked for use in the password, so if you want to put vowels back in
	// or add special characters such as exclamation marks, this is where
	// you should do it
	$possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

	// we refer to the length of $possible a few times, so let's grab it now
	$maxlength = strlen($possible);

	// check for length overflow and truncate if necessary
	if ($length > $maxlength) {
		$length = $maxlength;
	}

	// set up a counter for how many characters are in the password so far
	$i = 0;

	// add random characters to $password until $length is reached
	while ($i < $length) {

		// pick a random character from the possible ones
		$char = substr($possible, mt_rand(0, $maxlength-1), 1);

		// have we already used this character in $password?
		if (!strstr($password, $char)) {
			// no, so it's OK to add it onto the end of whatever we've already got...
			$password .= $char;
			// ... and increase the counter by one
			$i++;
		}
	}
	// done!
	return $password;
}


?>
