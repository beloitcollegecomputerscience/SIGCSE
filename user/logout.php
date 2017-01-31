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
 logoutprocess.php
-----------------
Used to log out users.
*/

// Access to global variables
require_once('../global/include.php');

//session_destroy();
unset($_SESSION['student_id']);
header('Location: '.SYSTEM_WEB_BASE_ADDRESS.'user/profile.php');
?>
