<?php
require_once 'DBConnectionHelper.php';

class QueryHelper {
	
	public function __construct() 
	{
		DBConnectionHelper::initialize();
	}
	
	/**
	 * 
	 * @param String $query
	 * @return PDOStatement
	 */
	private function execute($query) 
	{
		if ( ! is_null($query) ) {
			return DBConnectionHelper::executeQuery($query);
		}
	}
	
	/**
	 * 
	 * @param unknown $text
	 * @return string
	 */
	private function quote($text) 
	{
		return DBConnectionHelper::quoteString($text);
	}
	
	
	/**
	 * Retrieves the session information for the given $interviews_id.
	 * 
	 * @param string $interviews_id
	 * 	the interview id
	 * @param mixed $out
	 * 	output parameter, type varies depending on return value.
	 * @return number
	 * 	-1 if exception occurs. $out will be set to the exception's message
	 * 	0 if session for the given id is not found
	 * 	1 if session is found and valid, the returned row will be set to $out
	 * 	2 if session is found but expired, the returned row will be set to $out
	 */
	public function getSessionInfo($interviews_id, &$out) {
		$interviews_id = $this->quote($interviews_id);
		$query = 
		"select i.title, u.name, u.gender, u.email, u.phone, u.affiliation, s.date_prepared, v.password, p.interviewer_id, p.interviewee_id
from interviews i, participants p, users u, schedules s, validations v
where i.id = $interviews_id and p.interview_id = i.id and v.interview_id = i.id
and u.id = p.interviewee_id and s.interview_id = p.interviewer_id;";
		try {
			$rows = $this->execute($query)->fetchAll(PDO::FETCH_ASSOC);
			$rowsLen = count($rows);
			
			switch ($rowsLen) {
				case 0:
					// $interviews_id does not exists
					return 0;
				case 1:
					$out = $rows[0];
					$today = date("Y-m-d H:i:s");
					$interviewDate = $rows[0]["date_prepared"];
					return ($interviewDate < $today) ? 2: 1;
				default:
					// Weird things happen here...
					throw new Exception("Assertion failed, check database schema's integrity");
				
			}
		} catch (Exception $ex) {
			$out = $ex->getMessage();
			return -1;
		}
	}
	
	/**
	 * 
	 * @param unknown $interview_title
	 * @param unknown $interview_date
	 * @param unknown $interview_password
	 * @param unknown $interviewer_id
	 * @param unknown $interviewee_id
	 * @return unknown
	 */
	public function create_session( $interview_title, $interview_date, $interview_password, $interviewer_id, $interviewee_id )
	{
		$interview_id = $this->add_interview($interview_title, $interview_date, $interview_password);
		
		// create relation to the interview and the participants
		$query = "INSERT INTO `dannych_cse403`.`participants`(`interview_id`,`interviewer_id`,`interviewee_id`) VALUES($interview_id, $interviewer_id, $interviewee_id)";
		$this->execute($query);
		
		
		return $interview_id;
	}
	
	/**
	 * 
	 * @param unknown $fname
	 * @param unknown $lname
	 * @param unknown $email
	 * @param unknown $gender
	 * @param unknown $phone
	 * @param unknown $affiliation
	 */
	public function add_user($fname, $lname, $email, $gender, $phone, $affiliation)
	{
		$fname = $this->quote($fname);
		$lname = $this->quote($lname);
		$email = $this->quote($email);
		$gender= $this->quote($gender);
		$phone = $this->quote($phone);
		$affiliation = $this->quote($affiliation);
	
		$query = "INSERT INTO `dannych_cse403`.`users` (`fname`, `lname`, `gender`, `email`, `phone`, `affiliation`) VALUES ($fname, $lname, $gender, $email, $phone, $affiliation)";
	
		if ( $this->email_isNotRegistered($email) ) {
			// not registered
			// insert the new user to database
			$this->execute($query);
		} else {
			// given email exists
			// - mistyped, send to somebody else ? solution : create email verification to accept the interview.
			// 		Yes or No, and interview will be automaticly deleted without any response from either particpant at scheduled time
	
			// - really exists ? ok skip
		}
	
		// email is unique for every user
		$query = "select id from users where email = $email";
		$user_id = $this->execute($query);
		return $user_id->fetchAll()[0]['id'];
	}
	
	/**
	 * 
	 * @param unknown $title
	 * @param unknown $date_scheduled
	 * @param unknown $password
	 */
	private function add_interview($title, $date_scheduled, $password) 
	{
		$title = $this->quote($title);
		$date_scheduled = $this->quote($date_scheduled);
		$password = $this->quote($password);
	
		$query = "INSERT INTO `dannych_cse403`.`interviews` (`title`,`date_scheduled`,`password`) VALUES($title,$date_scheduled,$password)";
		$this->execute($query);
	
		// how do we uniquely identify an interview?
		// we want user to freely choose the title
		// - just use the one time password
		$query = "select id from interviews where title = $title and password = $password";
		$interview_id = $this->execute($query);
	
		return $interview_id->fetchAll()[0]['id'];
	}

	/**
	 * 
	 * @param unknown $email
	 * @return boolean
	 */
	private function email_isNotRegistered($email)
	{
		$query = "SELECT COUNT(*) as num from users where email = $email";
		$result = $this->execute($query);
	
		// 0 rows means no matching email
		return $result->fetchAll()[0]['num'] == 0 ;
	}

	/**
	 * 
	 * @param unknown $password
	 * @return boolean
	 */
	private function password_isNotRegistered($password)
	{
		$query = "SELECT COUNT(*) as num from interviews where password = $password";
		$result = $this->execute($query);
	
		return $result->fetchAll()[0]['num'] == 0;
	}
} 
?>