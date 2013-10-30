<?php

require_once 'DBConnectionHelper.php';

/**
 * This function will create an interview session (with hopefuly new user with valid email)
 *
 * @require 
 *      valid interview info   : $interview_date, $interview_password
 *		valid interviewer info : $interviewer_fname, $interviewer_lname, $interviewer_email
 *		valid interviewee info : $interviewee_fname, $interviewee_lname, $interviewee_email
 */
function create_session1 (	$interview_title, $interview_date, $interview_password,
							$interviewer_fname, $interviewer_lname, $interviewer_email, $interviewer_gender, $interviewer_phone, $interviewer_affiliation,
							$interviewee_fname, $interviewee_lname, $interviewee_email, $interviewee_gender, $interviewee_phone, $interviewee_affiliation) 
{
	DBConnectionHelper::initialize();
	
	$interview_id = add_interview($interview_title, $interview_date, $interview_password);
	$interviewer_id = add_user($interviewer_fname, $interviewer_lname, $interviewer_email, $interviewer_gender, $interviewer_phone, $interviewer_affiliation);
	$interviewee_id = add_user($interviewee_fname, $interviewee_lname, $interviewee_email, $interviewee_gender, $interviewee_phone, $interviewee_affiliation);
	
	// create relation to the interview and the participants
	$query = "INSERT INTO `dannych_cse403`.`participants`(`interview_id`,`interviewer_id`,`interviewee_id`) VALUES($interview_id, $interviewer_id, $interviewee_id)";
	
	DBConnectionHelper::executeQuery($query);

	return $interview_id;
}

/**
 * This function will create an interview session (with hopefuly new user with valid email)
 *
 * @require 
 *      valid interview info   : $interview_date, $interview_password
 * 		valid interviewer/ee_id
 */
function create_session2( $interview_title, $interview_date, $interview_password, 
						  $interviewer_id, $interviewee_id ) 
{
	try {
		DBConnectionHelper::initialize();
		$interview_id = add_interview($interview_title, $interview_date, $interview_password);
		
		// create relation to the interview and the participants
		$query = "INSERT INTO `dannych_cse403`.`participants`(`interview_id`,`interviewer_id`,`interviewee_id`) VALUES($interview_id, $interviewer_id, $interviewee_id)";
		
		DBConnectionHelper::executeQuery($query);

		return $interview_id;
	} catch (PDOException $ex) {
        echo $ex->getMessage();
    }
}

/**
 * Add an interview
 * note: you (might) don't want to create an interview without assigning the participants
 */
function add_interview($title, $date_scheduled, $password) {
	DBConnectionHelper::initialize();
	$title = DBConnectionHelper::quoteString($title);
	$date_scheduled = DBConnectionHelper::quoteString($date_scheduled);
	$password = DBConnectionHelper::quoteString($password);

	$query = "INSERT INTO `dannych_cse403`.`interviews` (`title`,`date_scheduled`,`password`) VALUES($title,$date_scheduled,$password)"; 
	DBConnectionHelper::executeQuery($query);
	
	// how do uniquely identify an interview?
	// we want user to freely choose the title
	// - just use the one time password
	$query_interview_id = "select id from interviews where title = $title and password = $password";
	$interview_id = DBConnectionHelper::executeQuery($query_interview_id);
	
	return $interview_id->fetchAll()[0]['id'];
}


/* This function will add a new user uniquely identified by his email
 *
 * @require
 *		fname,lname,email is required to send a proper email
 *
 * @throw 
 * 		may throw error from DBConnectionHelper::executeQuery
 *
 * @return
 * 		id number for given user
 */ 
function add_user($fname, $lname, $email, $gender, $phone, $affiliation) 
{
	try {

		DBConnectionHelper::initialize();
		$fname = DBConnectionHelper::quoteString($fname);
		$lname = DBConnectionHelper::quoteString($lname);
		$email = DBConnectionHelper::quoteString($email);
		$gender = DBConnectionHelper::quoteString($gender);
		$phone = DBConnectionHelper::quoteString($phone);
		$affiliation = DBConnectionHelper::quoteString($affiliation);


		$query = "INSERT INTO `dannych_cse403`.`users` (`fname`, `lname`, `gender`, `email`, `phone`, `affiliation`) 
				 VALUES ($fname, $lname, $gender, $email, $phone, $affiliation)";	
		
		if ( email_isNotRegistered($email) ) {
			// not registered
			// insert the new user to database
			DBConnectionHelper::executeQuery($query);
		} else {
			// given email exists
			// - mistyped, send to somebody else ? solution : create email verification to accept the interview. 
			// 		Yes or No, and interview will be automaticly deleted without any response from either particpant at scheduled time
			
			// - really exists ? ok
		}
		
		// email is unique for every user
		$query_user_id = "select id from users where email = $email";
		$user_id = DBConnectionHelper::executeQuery($query_user_id)->fetchAll();
		return $user_id[0]['id'];

	} catch (PDOException $ex) {
        echo $ex->getMessage();
    }
}





///////////////////////
// UTILITY
///////////////////////

/**
 * Check whether given email is already registered
 *
 * @return
 * 		true if registered otherwise false
 */
function email_isNotRegistered($email)
{
	DBConnectionHelper::initialize();
	$query_check = "SELECT COUNT(*) as num from users where email = $email";
	$result = DBConnectionHelper::executeQuery($query_check);
	
	// 0 rows means no matching email
	return $result->fetchAll()[0]['num'] == 0 ;  
}

/**
 * Check whether genereated one-time password is already taken
 *
 * return true if password is already taken by another interview, false otherwise
 */
function password_isNotRegistered($password) 
{
	DBConnectionHelper::initialize();
	$query_check = "SELECT COUNT(*) as num from interviews where password = $password";
	$result = DBConnectionHelper::executeQuery($query_check);
	
	return $result->fetchAll()[0]['num'] == 0;
}

////////////
// TODO: below not yet tested
////////////

/*
 * Using delete in users and interviews tables may disrupt the auto_increment
 * 
 * for test purpose only or you know what you're doing
 */
function delete_session_id($interview_id) {
	$query = "DELETE from interviews where id = $interview_id";
	run($query);

	$query = "DELETE from participants where interview_id = $interview_id"
	run($query);
}
function delete_user_id($id) {
	$query = "DELETE FROM users where id = $id";
	run($query);
}


/**
 * Find all interviews that scheduled at $date
 *
 * note: might be useful when notifying participants (one day or less) before the interview
 */
function interviews_atDate($date) {
	$query = "SELECT id, title, password from interviews where date_scheduled = $date";
	return run($query);
}

/**
 * Find the interviewer info from given interview id
 * 
 * @return
 *		1 row of interviewer's info of given interview id as an array
 */
function interviewer($interview_id) {
	$query = "SELECT u.* from users u join interviews i on i.interviewer_id = u.id where i.interview_id = $interview_id";
	return run($query);
}

/**
 * Find the interviewee info from given interview id
 * 
 * @return
 *		1 row of interviewee's info of given interview id as an array
 */
function interviewee($interview_id) {
	$query = "SELECT u.* from users u join interviews i on i.interviewee_id = u.id where i.interview_id = $interview_id";
	return run($query);
}

/**
 * Find the password from given interview id
 */
function password($interview_id) {
	$query = "SELECT password from interviews where id = $interview_id ";
	return run($query);
}

/**
 * Run given query at our database
 */
function run($query) {
	DBConnectionHelper::initialize();
	return DBConnectionHelper::executeQuery($query);
}
 
?>