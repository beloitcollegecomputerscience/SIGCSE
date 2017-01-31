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

// The global include file ?? this neccessary
//require_once('include.php');

function sendPlainTextMail($to, $subject, $message) {
    // In case any of our lines are larger than 70 characters, we should use wordwrap()
    $message = wordwrap($message, 70);

    //TODO: remove PHP version.
    $headers = "From: ".SYSTEM_EMAIL_NAME." <".SYSTEM_EMAIL_ADDRESS.">" . "\r\n" .
            "Reply-To: ".SYSTEM_EMAIL_NAME." <".SYSTEM_EMAIL_ADDRESS.">" . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

    // Send
    mail($to, $subject, $message, $headers, '-f'.SYSTEM_EMAIL_ADDRESS);
}

function sendHTMLEmail($to, $subject, $message) {

    // To send HTML mail, the Content-type header must be set
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    // Additional headers
    $headers .= "From: ".SYSTEM_EMAIL_NAME." <".SYSTEM_EMAIL_ADDRESS.">" . "\r\n" .
            "Reply-To: ".SYSTEM_EMAIL_NAME." <".SYSTEM_EMAIL_ADDRESS.">" . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

    // Send
    mail($to, $subject, $message, $headers, "-f".SYSTEM_EMAIL_ADDRESS);
}

function sendPasswordRecoveryEmail($email, $newPass) {

    $message = "Hello,<br /><br />";
    $message .= "You requested to reset your password.  The password has been changed to: <br />";
    $message .= $newPass . "<br />";
    $message .= "You may now login with this password and change it.";

    sendHTMLEmail($email, "Requested Information From SIGCSE Student Volunteer Site", $message);

}

//TODO: require confirmation on registration (send key, link?)
function sendRegistrationEmail($email) {

    $message = "Hello,<br /><br />";
    $message .= "This email was used in the SIGCSE 2013 Student Volunteer Registration.  If this is incorrect please reply back. <br />";
    $message .= "You may now login to the site <a href='".SYSTEM_ADDRESS."'>here</a>.<br />";

    sendHTMLEmail($email, "Registered Account for SIGCSE Student Volunteer Site", $message);

}

?>
