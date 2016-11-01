<?php
require_once('../../global/include.php');

if($_POST["action"]== "select"){

$selected_query_number= $_POST["selected_query_number"];
$response=array();
$queries = array(

"1"
		=> "SELECT * FROM students where profile_complete = 'f';",

		"2"
				=> "SELECT * FROM students where times_complete = 'f' and profile_complete = 't';",


				"3"
		=> "SELECT * FROM students where times_complete = 't' and profile_complete = 't';",




);

				foreach ($queries as $query_number => $query){
					if($query_number== $selected_query_number){
						$selected_query=$query;
						break;
					}



				}


$query_result = $db->query($selected_query);
$affected_rows = mysqli_num_rows($query_result);
?>

 <?php for ($i = 0; $i < $affected_rows; $i++) {
	$row = $query_result->fetch_assoc();

$recipient_first_name=$row['first_name'];
$recipient_last_name=$row['last_name'];
$recipient_student_id=$row['student_id'];
$recipient_student_email=$row['email'];
$response[$recipient_student_id] = $recipient_first_name."/".$recipient_last_name."/".$recipient_student_email;


 }
 echo json_encode($response);}

if($_POST["action"]== 'send'){
 $q="";

$id_list= substr($_POST['id_list'], 1);
$ids = split(",",$id_list);
$message = $_POST['message'];
foreach ($ids as $id) {
$id=(int)$id;
$query = "SELECT email from students WHERE student_id=$id";
$result = $db->query($query);
$row = $result->fetch_assoc();
$email = $row['email'];
sendHTMLEmail($email, "Message From SIGCSE Student Volunteer Site", $message);
}
;


 }

?>






