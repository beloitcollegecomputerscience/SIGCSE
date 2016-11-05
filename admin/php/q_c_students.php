
<?php
/*
this is the form that the admin is going to fill out to add the activity.
admin is directed to this page after clicking on the add activity button on the activity page.
*/

// Access to global variables
require_once('../../global/include.php');

$response1=array();
$response2=array();

		
			
					if (isset($_POST["range_start_time"]) && isset($_POST["range_end_time"])&&$_POST["action"]=='1') {
						
					
						
						$range_start_time=preg_replace("/[^0-9]/", "", $_POST["range_start_time"]);
						$range_end_time=preg_replace("/[^0-9]/", "", $_POST["range_end_time"]);
// 						$query="select a.activity_id from activity a, time_slots t where a.slot_id=t.slot_id and t.start_time>$range_start_time and t.start_time<$range_end_time;";
// 						$response=array();
// 						$query_result = $db->query($query);
// 						$affected_rows = mysqli_num_rows($query_result);
// 						for ($i = 0; $i < $affected_rows; $i++) {
// 							$row = $query_result->fetch_assoc();
						
// 							$activity_id=$row['activity_id'];
// 							array_push($response,$activity_id);
// 						}
// 						for($i=0;$i<sizeof($response);$i++){
// 							$this_id=$response[$i];
// 							echo "act".$this_id;
								$studentResult = $db->query("SELECT a.activity_id, a.activity_name ,ts.start_time,ts.end_time,ss.hours_granted, s.student_id ,s.checked_in ,s.first_name ,s.last_name, ss.attended FROM student_shifts ss, students s, activity a,time_slots ts  WHERE a.slot_id=ts.slot_id and ts.start_time>$range_start_time and ts.start_time<$range_end_time and a.slot_id = ts.slot_id AND ss.student_id = s.student_id AND ss.activity_id = a.activity_id;");
								$affected_rows = mysqli_num_rows($studentResult);
								for ($k = 0; $k < $affected_rows; $k++) {
									$student = $studentResult->fetch_assoc();
									
									array_push($response1,$student);
							
										}
					//}
										
					echo json_encode($response1);
					
						}
						if($_POST["action"]=='2'){
							$current_activity=$_POST["current_activity"];
							$query = "SELECT time_format(timediff(TS.end_time, TS.start_time), '%l%:%i') as hours_granted
													FROM time_slots TS, activity A
													WHERE A.slot_id = TS.slot_id
													AND A.activity_id = '". $current_activity ."';";
								
							$result2 = $db->query($query);
							$student2 = $result2->fetch_assoc();
								
							// calculate hours/mins granted
							$times = explode(':', $student2['hours_granted']);
							array_push($response2,$times[0]);
							array_push($response2,$times[1]);
							
							echo json_encode($response2);
									
						}
						
						
						
						
								
					?>
					
					
					



























