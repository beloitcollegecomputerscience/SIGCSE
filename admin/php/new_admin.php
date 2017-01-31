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

$admin_email = $_POST['admin_email'];
$admin_password = $_POST['admin_password'];

$admin_email = mysqli_real_escape_string($db->getDB(), $admin_email);
$admin_password = mysqli_real_escape_string($db->getDB(), $admin_password);

$hashed_password = sha1($_POST['admin_password']);

// Grab rows where database email == input email
$query = "SELECT count(*) as num_using FROM admin WHERE email = '$admin_email'";
$result = $db->query($query);
$row = $result->fetch_assoc();

// Number of users with that email
$num_using = $row['num_using'];

if (checkEmail($admin_email) && (strlen($admin_password) > 2) && ($num_using == 0)) {

    $query = "INSERT INTO admin (`email`, `password`) VALUES ('$admin_email', '$hashed_password')";
    $result = $db->query($query);
    echo "true";

} else {
    echo "false";
}


?>
