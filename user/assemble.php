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
 assemble.php
-------------
Designed to assemble the documents for student volunteer directions
*/
// Access to global variables
require_once('../global/include.php');

// Function to create an instruction.
require_once(SYSTEM_WEBHOME_DIR.'user/php/assemble.php');

// If the user is not logged in then redirect them to login.php
if (!$isLoggedIn) {
    header('Location:'. SYSTEM_WEB_BASE_ADDRESS . 'user/index.php');
}

// Grab posted info
//TODO: Display error if incomplete information is given
$student_id = $_GET['student_id'];
$activity_id = $_GET['activity_id'];
//??testing
// $student_id = 1;
// $activity_id = 365;
if ($isAdmin){
    $instruction = assembleInstruction($db, $activity_id, $student_id, $isAdmin);
    echo $instruction. "</br>";
}
else{
//     require_once(SYSTEM_WEBHOME_DIR.'images/header.php');
//     displayNav($loggedIn, 'profile');
    $instruction = assembleInstruction($db, $activity_id, $student_id, $isAdmin);
    echo $instruction . "</br>";
}
?>
