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
