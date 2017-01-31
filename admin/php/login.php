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
