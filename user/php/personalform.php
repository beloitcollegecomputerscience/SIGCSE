<?php
/*
 backend/personalformprocess.php
-------------------------------
Processes information on submit of form from personalform.php
- Checks for error
- If no errors, processes information and puts it into the database
- If there is an error, redirects back to the same url with errors

Notes:
- What if someone puts a string in for the cell number, like 623-234-4587? Do we want to accept that?
- Do we want to check the Advisor's name and create an error for that?
*/

// Access to global variables
require_once('../../global/include.php');

// Grab the rest of information posted and escape strings.
$first_name = mysqli_real_escape_string($db->getDB(), $_POST['first_name']);
$preferred_name = mysqli_real_escape_string($db->getDB(), $_POST['preferred_name']);
$last_name = mysqli_real_escape_string($db->getDB(), $_POST['last_name']);

$cell_phone = mysqli_real_escape_string($db->getDB(), $_POST['cell_phone']);
$tshirt_size = mysqli_real_escape_string($db->getDB(), $_POST['tshirt_size']);
$prior_experience = mysqli_real_escape_string($db->getDB(), $_POST['prior_experience']);

$school = mysqli_real_escape_string($db->getDB(), $_POST['school']);
$standing = mysqli_real_escape_string($db->getDB(), $_POST['standing']);
$advisor_name = mysqli_real_escape_string($db->getDB(), $_POST['advisor_name']);
$advisor_email = mysqli_real_escape_string($db->getDB(), $_POST['advisor_email']);


/* -----------LOOK HERE -------------------*/

$kids_camp_result = mysqli_real_escape_string($db->getDB(), $_POST['kids_camp_result']);


/* -------------------------------------*/




$updateString = "UPDATE `students` SET ";
$updateNeeded = false;




/* -------------------LOOK HERE----------------------- */

$result= $db->query("SELECT * FROM student_skills WHERE student_id = ".$_SESSION['student_id']." and skill_id =-1");
if(mysqli_num_rows($result)==0){
	if($kids_camp_result=='1'){
		$db->query("INSERT INTO student_skills(student_id,skill_id) VALUES ('".$_SESSION['student_id']."','-1')"); }
}
else{
	if($kids_camp_result=='0'){
		$db->query("delete from student_skills where student_id= ".$_SESSION['student_id']." and skill_id= -1 "); ;
	}
}



/* -------------------------------------------------------- */

// Grab user data
$result = $db->query("SELECT * FROM students WHERE students.student_id = ".$_SESSION['student_id']);
$row = $result->fetch_assoc();

$errno1 = false;
$errno2 = false;
$errno3 = false;
$errno4 = false;
$errno5 = false;
$errno6 = false;
$errno7 = false;
$errno8 = false;

// If a new first name was entered then update it
if ($row['first_name'] != $first_name) {
	if (checkName($first_name) == false) {
		$errno1 = true;
	} else {
		$updateString .= "`first_name` = '$first_name', ";
		$updateNeeded = true;
	}
}

// If a new preferred name was entered then update it
if ($row['preferred_name'] != $preferred_name) {
	$updateString .= "`preferred_name` = '$preferred_name', ";
	$updateNeeded = true;

}

// If a new last name was entered then update it
if ($row['last_name'] != $last_name) {
	if (checkName($last_name) == false) {
		$errno2 = true;
	} else {
		$updateString .= "`last_name` = '$last_name', ";
		$updateNeeded = true;
	}
}

// If a new phone was entered then update it
if ($row['cell_phone'] != $cell_phone) {
	$updateString .= "`cell_phone` = '$cell_phone', ";
	$updateNeeded = true;
}

// If a new tshirt_size was entered then update it
if ($row['tshirt_size'] != $tshirt_size) {
	if (($tshirt_size != "S") and ($tshirt_size != "M") and ($tshirt_size != "L") and ($tshirt_size != "XL") and ($tshirt_size != "XXL")) {
		$errno3 = true;
	} else {
		$updateString .= "`tshirt_size` = '$tshirt_size', ";
		$updateNeeded = true;
	}
}

// If a new prior_experience was entered then update it
if ($row['prior_experience'] != $prior_experience) {
	if (($prior_experience != "None") and ($prior_experience != "Once") and ($prior_experience != "More than once")) {
		$errno4 = true;
	} else {
		$updateString .= "`prior_experience` = '$prior_experience', ";
		$updateNeeded = true;
	}
}

// If a new school was entered then update it
if (($row['school'] != $school) or ($row['school'] == null)) {
	if (checkSchool($school) == false) {
		$errno5 = true;
	}
	else {
		$updateString .= "`school` = '$school', ";
		$updateNeeded = true;
	}
}

// If a new standing was entered then update it
if ($row['standing'] != $standing) {
	if (($standing != "Undergrad") and ($standing != "Graduate") and ($standing != "Other")) {
		$errno6 = true;
	} else {
		$updateString .= "`standing` = '$standing', ";
		$updateNeeded = true;
	}
}

// If a new advisor name was entered then update it
if (($row['advisor_name'] != $advisor_name) or ($row['advisor_name'] == null)) {
	if (checkName($advisor_name) == false) {
		$errno7 = true;
	}
	else {
		$updateString .= "`advisor_name` = '$advisor_name', ";
		$updateNeeded = true;
	}
}

// If a new advisor email was entered then update it
if (($row['advisor_email'] != $advisor_email) or ($row['advisor_email'] == null)) {
	if (checkEmail($advisor_email) == false) {
		$errno8 = true;
	} else {
		$updateString .= "`advisor_email` = '$advisor_email', ";
		$updateNeeded = true;
	}
}

// If a change was made, prepare the update string and update the database with new personal information
if ($updateNeeded) {
	$updateString = substr($updateString, 0, -2)." WHERE `student_id`=".$_SESSION['student_id'];
	$result = $db->query($updateString);
}

if (($errno1 != true) and ($errno2 != true) and ($errno3 != true) and ($errno4 != true) and ($errno5 != true) and ($errno6 != true) and ($errno7 != true) and ($errno8 != true)) {
	// All data is successful and we can set profile_complete to a t.
	$db->query("UPDATE `students` SET `profile_complete`='t' WHERE `student_id`=".$_SESSION['student_id']);
	echo "true";
} else {

	// Errors to send back
	$response = "";

	// If the following error numbers exist then they are to be added to the URL to be displayed on register.php
	if ($errno1 == true) {
		$response .= "err1,";
	}
	if ($errno2 == true) {
		$response .= "err2,";
	}
	if ($errno3 == true) {
		$response .= "err3,";
	}
	if ($errno4 == true) {
		$response .= "err4,";
	}
	if ($errno5 == true) {
		$response .= "err5,";
	}
	if ($errno6 == true) {
		$response .= "err6,";
	}
	if ($errno7 == true) {
		$response .= "err7,";
	}
	if ($errno8 == true) {
		$response .= "err8,";
	}

	$response = substr($response, 0, -1);

	// Send back the appropriate errors
	echo $response;
}

?>
