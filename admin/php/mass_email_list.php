<!-- Licensed under the BSD. See License.txt for full text.  -->

<?php
require_once('../../global/include.php');

if($_POST["action"]== "select"){

$selected_query= $_POST["selected_query"];
$query1='select query, content from mass_email_query where query_id='.$selected_query.';';
$query_result1 = $db->query($query1);
$row1 = $query_result1->fetch_assoc();
$query2=$row1['query'];
$content=$row1['content'];

$query_result2 = $db->query($query2);
$affected_rows = mysqli_num_rows($query_result2);
?>

 <?php for ($i = 0; $i < $affected_rows; $i++) {
 $row = $query_result2->fetch_assoc();

$recipient_first_name=$row['first_name'];
$recipient_last_name=$row['last_name'];
$recipient_student_id=$row['student_id'];
$recipient_student_email=$row['email'];
$response[$recipient_student_id] = $recipient_first_name."/".$recipient_last_name."/".$recipient_student_email;


 }
 $response["content"]=$content;
 echo json_encode($response);}

if($_POST["action"]== 'send'){
 $q="";

$id_list= substr($_POST['id_list'], 1);
$ids = split(",",$id_list);
$message = $_POST['message'];
foreach ($ids as $id) {
$id=(int)$id;
$query = "SELECT email,first_name from students WHERE student_id=$id";
$result = $db->query($query);
$row = $result->fetch_assoc();
$email = $row['email'];
$message=str_replace ( "%firstname%" , $row['first_name'] , $message);
sendHTMLEmail($email, "Message From SIGCSE Student Volunteer Site", $message);
}
;


 }


 if($_POST["action"]== 'update'){

  $new_template= $_POST["new_template"];
  $selected_query= $_POST["selected_query"];

  $query = "UPDATE mass_email_query SET content='".$new_template."' WHERE query_id=".$selected_query.";";
  $result3 = $db->query($query);






 }



?>






