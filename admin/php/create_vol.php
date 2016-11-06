<?php 

// Access to global variables
require_once('../../global/include.php');

$email = $_POST['email'];

if (checkEmail($email)) {
	
	// Grab rows where database email == input email
	$query = "SELECT count(*) as num_using FROM students WHERE email = '$email'";
	$result = $db->query($query);
	$row = $result->fetch_assoc();
	
	// Number of users with that email
	$num_using = $row['num_using'];
	
	if ($num_using == 0) {
		$query = "INSERT INTO students (`email`) VALUES ('$email');";
		$db->query($query);
		
		echo "true";
	} else {
		echo "false";
	}
	
	
	
} else {
	echo "false";
}

?>