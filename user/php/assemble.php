<?php
// Access to global variables
// TODO require_once('../../global/include.php');

/*
 * Will return the instruction_id associated with an activity. Returns -99 if fails.
 * Parameter:
 * activity_id that you want the instruction for.
 */
function getInstructionID($db, $activity_id) {
	
	// Queries the database for instruction_id
	$query = "SELECT instruction_id
	FROM activity_instructions
	WHERE activity_id = '$activity_id';";
	$result = $db->query ( $query );
	$affected_rows = mysqli_num_rows ( $result );
	if ($affected_rows != 1) {
		return - 99;
	} else {
		// Get instruction_id
		$row = $result->fetch_assoc ();
		$instruction_id = $row ['instruction_id'];
		return $instruction_id;
	}
}

/*
 * Will return the instruction (string) associated with an instruction_id.
 * Parameters:
 * activity_id for desired instruction.
 */
function getInstruction($db, $instruction_id) {
	// Returned instructions when something goes seriously wrong.
	$failed_attempt = "<strong>The attempt to get the instruction failed.  This is an internal error that the user cannot fix.  You can report this to us for fixing.</strong>";
	
	// Queries the database for the instructions for the given activity
	$query = "SELECT instruction FROM instructions
	WHERE instruction_id = '$instruction_id';";
	$result = $db->query ( $query );
	$affected_rows = mysqli_num_rows ( $result );
	if ($affected_rows != 1) {
		// Really should not happen if document format ok.
		// return $failed_attempt . "<p>There are not instuctions for this activity.</p>";
		// Instead of error return empty instruction since there are activities now without associated instructions.
		return "<h3>No special instructions for this activity.</h2>";
	} else {
		// If there are instructions for the activity, get them
		$row = $result->fetch_assoc ();
		$instruction = $row ['instruction'];
		return $instruction;
	}
}

/*
 * Will return an HTML string to represent the instruction for the given activity and student
 * where standard edit strings are replaced with needed DB info.
 * Parameters:
 * $instruction is the raw instruction to process.
 * student_id to create instructions for.
 * isAdmin is true if the instructions are for an admin and false (for student) otherwise.
 */
function processInstruction($db, $instruction, $activity_id, $student_id, $isAdmin) {
	
	// default if info to substitute is unknown.
	$unknown_output = "[unknown]";
	// default if won't give info since not admin.
	$student_output = "[To be provided]";
	// Returned instructions when something goes seriously wrong.
	$failed_attempt = "<strong>The attempt to get the instruction failed.  This is an internal error that the user cannot fix.  You can report this to us for fixing.</strong>";
	
	// This says that if this is not a real student (doing general assembly), the don't get info from DB.
	// This is the case if activity and student are -99.
	if ($activity_id != - 99 || $student_id != - 99) {
		// Query the database for information needed in the instruction. Just get everything since simpler - even if not needed.
		$query = "SELECT A.activity_name, date_format(TS.start_time, '%l%:%i %p') as start_time, date_format(TS.end_time, '%l%:%i %p') as end_time,
	date_format(date(TS.start_time), '%a %M %e') as day, R.room_location, O.first_name, O.last_name
	FROM activity A, time_slots TS, rooms R, organizer O, organizer_activity OA
	WHERE A.slot_id = TS.slot_id
	AND A.room_id = R.room_id
	AND A.activity_id = OA.activity_id
	AND OA.organizer_id = O.organizer_id
	AND A.activity_id = '$activity_id';";
		$result = $db->query ( $query );
		$affected_rows = mysqli_num_rows ( $result );
		
		if ($affected_rows != 1) {
			echo $activity_id;
		} else {
			// Store results
			$row = $result->fetch_assoc ();
			
			$start_time = $row ['start_time'];
			$end_time = $row ['end_time'];
			$day = $row ['day'];
			$activity_name = $row ['activity_name'];
			$organizer_first_name = $row ['first_name'];
			$organizer_last_name = $row ['last_name'];
			$activity_room = $row ['room_location'];
		}
		
		// Query the database for student information.
		$query = "SELECT first_name, last_name
	FROM students
	where student_id = '$student_id';";
		$result = $db->query ( $query );
		$affected_rows = mysqli_num_rows ( $result );
		
		if ($affected_rows != 1) {
			return $failed_attempt;
		} else {
			// Store results
			$row = $result->fetch_assoc ();
			
			$student_first_name = $row ['first_name'];
			$student_last_name = $row ['last_name'];
		}
	}
	
	// Query the database for extra info needed.
	$query = "SELECT sv_room, sv_email, sv_cell_numbers, emergency_cell_numbers, http_online_program
			FROM extra_info
			WHERE extra_info_id = -1;";
	$result = $db->query ( $query );
	$affected_rows = mysqli_num_rows ( $result );
	
	if ($affected_rows != 1) {
		$sv_room = "Student Volunteer Headquarters";
		$sv_email = "Student Volunteer email unavailable";
		$sv_cell_numbers = "Student Volunteer coordinator cell phone numbers unavailable";
		$emergency_cell_numbers = "Backup cell phone numbers unavailable";
		$http_online_program = "Location of SIGCSE online program unavailable";
	} else {
		// Store results
		$row = $result->fetch_assoc ();
		$sv_room = $row ['sv_room'];
		$sv_email = $row ['sv_email'];
		$sv_cell_numbers = $row ['sv_cell_numbers'];
		$emergency_cell_numbers = $row ['emergency_cell_numbers'];
		$http_online_program = $row ['http_online_program'];
	}
	
	// Find where [[[ and ]]] are. Should test for failure with === false.
	$separator = " ";
	// Find start of first command.
	$subStart = strpos ( $instruction, '[[[' );
	while ( $subStart !== false ) {
		// If found start of command then look for end after this point.
		$subEnd = strpos ( $instruction, ']]]', $subStart + 3 );
		if ($subEnd == false) {
			// Really should not happen if document format ok.
			return $failed_attempt;
		}
		// Find string between these.
		$replace = substr ( $instruction, $subStart + 3, $subEnd - ($subStart + 3) );
		// Find two words that make up replacement string.
		$items = explode ( $separator, $replace );
		// check for error?
		$command = $items [0];
		$dbPlace = $items [1];
		
		// Figure out what is being asked for an create desired substitution string
		if (strcmp ( $dbPlace, "time_slots.start_time" ) == 0) {
			$replacement = $day . " at " . $start_time;
		} else if (strcmp ( $dbPlace, 'time_slots.end_time' ) == 0) {
			$replacement = $day . " at " . $end_time;
		} else if (strcmp ( $dbPlace, 'activity.activity_name' ) == 0) {
			$replacement = $activity_name;
		} else if (strcmp ( $dbPlace, 'rooms.room_location' ) == 0) {
			$replacement = $activity_room;
		} else if (strcmp ( $dbPlace, 'organizer.first_name' ) == 0) {
			$replacement = $organizer_first_name;
		} else if (strcmp ( $dbPlace, 'organizer.last_name' ) == 0) {
			$replacement = $organizer_last_name;
		} else if (strcmp ( $dbPlace, 'students.first_name' ) == 0) {
			$replacement = $student_first_name;
		} else if (strcmp ( $dbPlace, 'students.last_name' ) == 0) {
			$replacement = $student_last_name;
		} else if (strcmp ( $dbPlace, 'extra_info.sv_room' ) == 0) {
			// Everyone can see SV home
			$replacement = $sv_room;
		} else if (strcmp ( $dbPlace, 'extra_info.sv_email' ) == 0) {
			// Everyone can see SV email
			$replacement = $sv_email;
		} else if (strcmp ( $dbPlace, 'extra_info.sv_cell_numbers' ) == 0) {
			$replacement = $sv_cell_numbers;
		} else if (strcmp ( $dbPlace, 'extra_info.emergency_cell_numbers' ) == 0) {
			$replacement = $emergency_cell_numbers;
		} else if (strcmp ( $dbPlace, 'extra_info.http_online_program' ) == 0) {
			// Everyone can see SIGCSE program location online
			$replacement = $http_online_program;
		} else {
			$replacement = $unknown_output;
		}
		// Only admins can see if command is DBADMIN
		if (strcmp ( $command, "DBADMIN" ) == 0 && ! $isAdmin) {
			// Leave alone if it was not an understood command.
			if (strcmp ( $replacement, $unknown_output ) != 0) {
				$replacement = $student_output;
			}
		}
		
		// Replace with DB info
		$instruction = substr_replace ( $instruction, $replacement, $subStart, $subEnd - $subStart + 3 );
		// Find next command that starts with [[[.
		$subStart = strpos ( $instruction, '[[[' );
	}
	return $instruction;
}

/*
 * Will return an HTML string to represent the complete instructions (beginning, special and end) for
 * the given activity and student.
 * Parameters:
 * activity_id for desired instruction.
 * student_id to create instructions for.
 * isAdmin is true if the instructions are for an admin and false (for student) otherwise.
 */
function assembleInstruction($db, $activity_id, $student_id, $isAdmin) {
	// Returned instructions when something goes seriously wrong.
	$failed_attempt = "<strong>The attempt to get the instruction failed.  This is an internal error that the user cannot fix.  You can report this to us for fixing.</strong>";
	
	// Probe DB to see where needed instructions are.
	
	// Queries the database for location of speical instructions that go at beginning and end of all instructions
	$query = "SELECT instruction_id_top, instruction_id_bottom
			FROM extra_info
			WHERE extra_info_id = -1;";
	$result = $db->query ( $query );
	$affected_rows = mysqli_num_rows ( $result );
	if ($affected_rows != 1) {
		return $failed_attempt;
	} else {
		// If there are instructions for the activity, get them
		$row = $result->fetch_assoc ();
		$instruction_id_top = $row ['instruction_id_top'];
		$instruction_id_bottom = $row ['instruction_id_bottom'];
	}
	
	// Get info that goes at top of all instructions.
	$topInstructions = processInstruction ( $db, getInstruction ( $db, $instruction_id_top ), $activity_id, $student_id, $isAdmin );
	// Get info that goes at bottom of all instructions.
	$bottomInstructions = processInstruction ( $db, getInstruction ( $db, $instruction_id_bottom ), $activity_id, $student_id, $isAdmin );
	// Get specific instructions info for middle.
	$instruction = processInstruction ( $db, getInstruction ( $db, getInstructionID ( $db, $activity_id ) ), $activity_id, $student_id, $isAdmin );
	
	return $topInstructions . $instruction . $bottomInstructions;
}

?>