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
 loginprocess.php
-------------
Used to validate login.
- Returns to login.php with errors in the URL
- Does the same form validation JS does with the same regex's
- Creates session variables for correct information to be loaded on login.php

Redirection
- Sends back to login.php with errors if bad input
- Sends to profile.php if login was successful

Notes
- Could use GET so profile.php displays a "Login Successful" message only upon a successful login.
- Could convert error messages sent back to register.php to use POST instead of GET to hide URL activity
*/

// Access to global variables
require_once('../../global/include.php');

// 1 second delay to prevent attack
sleep(1);

// Specific error flags used to create sessions variables for correct data to send back to register
$email_error = false;
$password_error = false;

// Error flags used to send error messages back to register.php
$errno1 = false;
$errno2 = false;
$errno3 = false;
$errno4 = false;

// Queries the database to see if login lock is on
$query = "SELECT locked FROM system_locks WHERE name = 'can_login'";
$result = $db->query($query);
$row = $result->fetch_assoc();

// If login lock is on, send back to login page with an error
if ($row['locked'] == 't') {
    echo "locked";
} else {

    // Make quick references to all form data
    $email = mysqli_real_escape_string($db->getDB(), strtolower($_POST['email']));
    // Hash the passwords for database checking
    // Keep non-hashed password to check against the regex
    $password = $_POST['password'];
    $hashed_password = sha1($_POST['password']);

    // Grab rows where database email == input email
    $query = "SELECT student_id, password FROM students WHERE students.email = '$email'";
    $result = $db->query($query);
    // Number of users with that email
    $num_rows = mysqli_num_rows($result);

    // Retrieve users password from database
    $row = $result->fetch_assoc();
    $real_password = $row['password'];
    $student_id = $row['student_id'];

    // Check email against the regex
    if (checkEmail($email) == false) {
        $email_error = true;
        $errno1 = true;
        // Check if email is even in use
    } else if ($num_rows == 0) {
        $email_error = true;
        $errno2 = true;
    }

    // Check password against the regex
    // TODO: why check here? - Don't understand this TODO
    if (checkPass($password) == false) {
        $password_error = true;
        $errno3 = true;

    // Check both passwords for equality
    } else if ($hashed_password != $real_password) {
        $password_error = true;
        $errno4 = true;
    }

    // If all specific error flags are true then the form data is correct and we can login the user
    if (($password_error == false) and ($email_error == false)) { // Login was successful

        // Store student_id as a session variable
        $_SESSION['student_id'] = $student_id;

        echo "true";

    } else { // Login was unsuccessful

        // Errors to send back
        $response = "";

        // If the following error numbers exist then they are to be added to the URL to be displayed on login.php
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

        $response = substr($response, 0, -1);

        // Send back the appropriate errors
        echo $response;

    }
}

?>
