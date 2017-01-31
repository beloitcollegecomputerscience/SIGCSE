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
