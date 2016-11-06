<?php 

// Access to global variables
require_once('../../global/include.php');

$student_id = $_POST['student_id'];
$message = $_POST['message'];

$query = "SELECT email from students WHERE student_id=$student_id";
$result = $db->query($query);
$row = $result->fetch_assoc();
$email = $row['email'];

sendHTMLEmail($email, "Personal Message From SIGCSE Student Volunteer Site", $message);

?>