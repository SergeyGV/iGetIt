<?php

// Log-in function. Requires username and password. Returns 1 if student, 0 if instructor, all other are errors.
function check_input ($username, $password) {
	
	$dbconn = connect_db();
    if(!$dbconn){
        return -2;
    }

	
	$query=pg_prepare($dbconn, "lookup", "SELECT * FROM appuser WHERE username = $1 and password = $2;");
	$query=pg_execute($dbconn, "lookup", array($username, $password));

	if ($row = pg_fetch_array($query)) {
		if ($row[type] == "student") {
			return 1;
		}
		return 0;
    }

	return -1;

}

// Adds profile to the database. Requires everything in the profile page.
function add_profile ($username, $password, $firstname, $lastname, $email, $type, $question, $answer) {

	$dbconn = connect_db();
    if(!$dbconn){
        return -2;
    }

    $query=pg_prepare($dbconn, "lookup", "SELECT * FROM appuser WHERE username = $1;");
    $query=pg_execute($dbconn, "lookup", array($username));

	if ($row = pg_fetch_array($query)) {
        return -1;
    }

	$insert=pg_prepare($dbconn, "insert", "INSERT INTO appuser VALUES($1, $2, $3, $4, $5, $6, $7, $8);");
	$insert=pg_execute($dbconn, "insert", array($username, $password, $firstname, $lastname, $email, $type, $question, $answer));
	return 0;

}

// Adds a course to the course db. Requires a course name and a course code.
function add_course ($name, $code) {

	$dbconn = connect_db();
    if(!$dbconn){
        return -3;
    }

	if (empty($name) || empty($code)) {
		return -2;
	}

	$query=pg_prepare($dbconn, "insert", "INSERT INTO course_list VALUES($1, $2, 0, 0);");
    $query=pg_execute($dbconn, "insert", array($name, $code));

	if ($query) {
		return 0;
	}

	return -1;


}

// Retrieves and prints all of the courses in the db. No args needed. Call within a form.
function get_courses () {

	$dbconn = connect_db();
    if(!$dbconn){
        return -1;
    }

	$query=pg_query($dbconn, "SELECT coursename FROM course_list;");

	while ($row = pg_fetch_array($query)) {
		echo("<option>$row[0]</option>");
	}

	return 0;

}

// Insert a course name and a corresponding code. A return value of 0 indicates it is the correct code.
function validate_course_code ($name, $code) {

	$dbconn = connect_db();
    if(!$dbconn){
        return -2;
    }
	$query=pg_prepare($dbconn, "lookup", "SELECT * FROM course_list WHERE coursename = $1 and coursecode = $2;");
    $query=pg_execute($dbconn, "lookup", array($name, $code));

	if ($row = pg_fetch_array($query)) {
        return 0;
    }

	return -1;

}

// Have a student vote. Provide the course name, the students username, and their vote(0 = getit, 1 = dontgetit)
function submit_vote ($c_name, $u_name, $vote) {


	$dbconn = connect_db();
    if(!$dbconn){
        return -2;
    }

	$record=pg_prepare($dbconn, "doc", "INSERT INTO activity VALUES($1, $2);");
	$record=pg_execute($dbconn, "doc", array($c_name, $u_name));

	if ($record) {
		if ($vote == 0) {
			$tally=pg_prepare($dbconn, "upd", "UPDATE course_list SET getit = getit + 1 WHERE coursename = $1;");
		} else {
			$tally=pg_prepare($dbconn, "upd", "UPDATE course_list SET dontgetit = dontgetit + 1 WHERE coursename = $1;");
		}
		$tally=pg_execute($dbconn, "upd", array($c_name));
		return 0;
	}
	return -1;

}

// Report to the instructor the current votes. Provide a course name and which type of vote(0 = getit, 1 = dontgetit)
function tally_votes ($c_name, $vote) {

	$dbconn = connect_db();
    if(!$dbconn){
        return -1;
    }

	// Don't ask. Some voodo magic prevents this code from looking better. Attempt to do so breaks it.
	if ($vote == 0) {
		$query=pg_prepare($dbconn, "getit", "SELECT getit FROM course_list WHERE coursename = $1;");
		$query=pg_execute($dbconn, "getit", array($c_name));
    	$row = pg_fetch_array($query);
    	return $row[0];

	}
	$query=pg_prepare($dbconn, "dontgetit", "SELECT dontgetit FROM course_list WHERE coursename = $1;");
	$query=pg_execute($dbconn, "dontgetit", array($c_name));
    $row = pg_fetch_array($query);
    return $row[0];

}

// Reset the Tally for the course, and wipe the voters record. Provide course name.
function clear_votes ($c_name) {

	$dbconn = connect_db();
    if(!$dbconn){
        return -1;
    }

	$clearvotes=pg_prepare($dbconn, "clearing", "UPDATE course_list SET getit = 0, dontgetit = 0 WHERE coursename = $1;");
	$clearvotes=pg_execute($dbconn, "clearing", array($c_name));
	$clearactivity=pg_prepare($dbconn, "deleting", "DELETE FROM activity WHERE coursename = $1;");
	$clearactivity=pg_execute($dbconn, "deleting", array($c_name));

	return 0;

}

// Update the profile. Provide EVERYTHING.
function update_profile ($username, $password, $firstname, $lastname, $email, $question, $answer) {

	$dbconn = connect_db();
    if(!$dbconn){
        return -2;
    }

    $updater=pg_prepare($dbconn, "profup", "UPDATE appuser SET password = $1, firstname = $2, lastname = $3, email = $4, sec_q = $5, sec_a = $6 WHERE username = $7;");
	$updater=pg_execute($dbconn, "profup", array($password, $firstname, $lastname, $email, $question, $answer, $username));
    return 0;

}

// Retrieve security question onto the screen, send password as return. Requires username.
function security_check($username, $num) {

    $dbconn = connect_db();
    if(!$dbconn){
        return -2;
    }

    $query=pg_prepare($dbconn, "lookup", "SELECT sec_q, sec_a, password FROM appuser WHERE username = $1;");
    $query=pg_execute($dbconn, "lookup", array($username));

	if ($row = pg_fetch_array($query)) {
        return $row[$num];
    }
    return -1;
    
}

// General connection function
function connect_db() {
    return pg_connect("host=mcsdb.utm.utoronto.ca port=5432 dbname=" . getUsername() . "_309 user=" . getUsername(). " password=" . getPassword());
}

