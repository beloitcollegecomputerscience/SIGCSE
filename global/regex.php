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
