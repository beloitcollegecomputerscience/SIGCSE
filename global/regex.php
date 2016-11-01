<?php
/*
 regex.php
---------
Used to check expressions. Check functions below are for:
- Email
- Password
- Name
- School's name
*/

function checkEmail($email){
	if (preg_match("/^([A-Za-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/",$email)){
		return true;
	}
	else{
		return false;
	}
}

function checkPass($pass){
	if (strlen($pass) >= 6) {
		return true;
	} else {
		return false;
	}
}

// TODO: international?  Less restrictions?
function checkName($name){
	if (preg_match("/^[A-Za-z0-9_ -]{2,75}$/",$name)){
		return true;
	}
	else{
		return false;
	}
}

// TODO: international?  Less restrictions?
function checkSchool($name){
	if (preg_match("/^[\sA-Za-z0-9_-]{2,75}$/",$name)){
		return true;
	}
	else{
		return false;
	}
}

?>
