<!-- Copyright (C) 2017  Beloit College

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program (License.txt).  If not, see <http://www.gnu.org/licenses/>. -->

<?php
/*
 registerprocess.php
-------------
Used to validate registration.
- Returns to register with errors in the URL
- Does the same form validation JS does with the same regex's
- Creates session variables for correct information to be loaded on register.php

Redirection
- Sends back to register.php with errors if bad input
- Sends to login.php if registration was successful

*/

// Access to global variables
require_once('../../global/include.php');

// Queries the database to see if registration lock is on
$query = "SELECT locked FROM system_locks WHERE name = 'create_id'";
$result = $db->query($query);
$row = $result->fetch_assoc();

// If registration lock is on, send back to registration page
if ($row['locked'] == 't'&& !$isAdmin) {
    //header('Location: '.SYSTEM_WEB_BASE_ADDRESS.'registration.php');
    echo "locked";
} else {

    // Make quick references to all form data
    $first_name = mysqli_real_escape_string($db->getDB(), $_POST["first_name"]);
    $last_name = mysqli_real_escape_string($db->getDB(), $_POST["last_name"]);
    $email = mysqli_real_escape_string($db->getDB(), $_POST["email"]);
    // Hash the passwords for database storage
    // Keep non-hashed passwords to check against the regex
    $password = $_POST['password'];
    $hashed_password = sha1($_POST['password']);
    $confirm_password = $_POST['confirm_password'];
    // TODO: check that hashed password has not bad SQL? - feasible?
    $hashed_confirm_password = sha1($_POST['confirm_password']);

    // Grab rows where database email == input email
    $query = "SELECT count(*) as num_using FROM students WHERE email = '$email'";
    $result = $db->query($query);
    $row = $result->fetch_assoc();

    // Number of users with that email
    $num_using = $row['num_using'];

    // Specific error flags used to create sessions variables for correct data to send back to register
    $email_error = false;
    $first_name_error = false;
    $last_name_error = false;
    $password_error = false;

    // Error flags used to send error messages back to register.php
    $errno1 = false;
    $errno2 = false;
    $errno3 = false;
    $errno4 = false;
    $errno5 = false;
    $errno6 = false;

    // Check first_name against the regex
    if (checkName($first_name) == false) {
        $first_name_error = true;
        $errno1 = true;
    }

    // Check last_name against the regex
    if (checkName($last_name) == false) {
        $last_name_error = true;
        $errno2 = true;
    }

    // Check email against the regex
    if (checkEmail($email) == false) {
        $email_error = true;
        $errno3 = true;
        // Check if email is already in use
    } else if ($num_using != 0) {
        $email_error = true;
        $errno4 = true;
    }

    // Check both password against the regex
    if (checkPass($password) == false) {
        $password_error = true;
        $errno6 = true;
        // Check both passwords for equality
    } else if ($hashed_password != $hashed_confirm_password) {
        $password_error = true;
        $errno5 = true;
    }

    // If all specific error flags are false then the form data is correct and we can register the user
    if (($password_error == false) and ($email_error == false) and ($first_name_error == false) and ($last_name_error == false)) { // Registration was successful
        // Add the users data into the students table
        $query = "INSERT INTO students(first_name, last_name, email, password) VALUES ('$first_name','$last_name', '$email', '$hashed_password')";
        $db->query($query);

        // Store student_id as a session variable
        $_SESSION['student_id'] = $db->getLastID();

        // Send user an email
        //sendRegistrationEmail($email);

        echo "true";

    } else { // Registration was unsuccessful

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

        $response = substr($response, 0, -1);

        // Send back the appropriate errors
        echo $response;
    }
}
?>
