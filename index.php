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

<!DOCTYPE html>
<html lang="en">

<?php

// Access to global variables
require_once('global/include.php');

// Queries the database to see if login lock is on
$query = "SELECT locked FROM system_locks WHERE name = 'can_login'";
$result = $db->query($query);
$row = $result->fetch_assoc();

if ($row['locked'] != 't') {
    header('Location: '.SYSTEM_WEB_BASE_ADDRESS.'user/index.php');
}

// Include the head for every page
require_once(SYSTEM_WEBHOME_DIR.'user/php/head.php');

?>

<body>

    <div style="margin-top: 50px;" class="container">

        <div class="jumbotron col-lg-6 col-lg-offset-3">
            <p class="text-center">
                <i class="fa fa-exclamation fa-5x"></i>
            </p>
            <h2>SIGCSE Volunteer Registration</h2>
            <p class="lead">We'll be back shortly. Website is undergoing
                maintence.</p>
        </div>

    </div>

</body>
</html>
