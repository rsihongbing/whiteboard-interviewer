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
	public function execute($query) 
	{
		if ( ! is_null($query) ) {
			return DBConnectionHelper::executeQuery($query);
		}
	}
	
	/**
	 * 
	 * @param String $text
	 * @return 
	 * 	string that has been quoted
	 *  such that quote(foo) returns "foo" but quote(NULL) = NULL
	 */
	public function quote($text) 
	{
		 
		return is_null($text) ? 'NULL' : DBConnectionHelper::quoteString($text);
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
	public function getSessionInfo($url, &$out) {
		$interviews_id = $this->quote($interviews_id);
		$query = 
		"select i.title, u.name, u.gender, u.email, u.phone, u.affiliation, s.date_prepared, v.password, p.interviewer_id, p.interviewee_id
		from interviews i, participants p, users u, schedules s, validations v
		where i.id = $interviews_id and p.interview_id = i.id and v.interview_id = i.id
		and u.id = p.interviewee_id and s.interview_id = i.id;";
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
	 * @param varchar(50) $url
	 * @return multitype:
	 * 		all columns from interview that correspondent to the given url
	 */
	public function get_session($url) {
		
		// TODO: check url
		
		$url = $this->quote($url);
		$query = "SELECT * from interviews where url = $url";
		return $this->execute($query)->fetchAll()[0];
	}
	
	/**
	 * 
	 * @param varchar(50) $url
	 * @param varchar(35) $interview_title
	 * @param String $interview_description
	 * @param varchar(30) $interviewer_email
	 * @param varchar(50) $interviewer_password
	 * @param varchar(30) $interviewee_email
	 * @param varchar(50) $interviewee_password
	 * @param String $interview_date
	 * @return boolean
	 * 		whether session creation is a success or a failure
	 */
	public function create_session($url, $interview_title, $interview_description, $interviewer_email, $interviewer_password, $interviewee_email, $interviewee_password, $interview_date )
	{	
		$url = $this->quote($url);
		$interview_title = $this->quote($interview_title);
		$interview_description = $this->quote($interview_description);
		$interviewee_password = $this->quote($interviewee_password);
		$interviewer_password = $this->quote($interviewer_password);
		$interview_date = $this->quote($interview_date);
		
		// TODO: check url, interviewer & interviewee pwd, interviewee_id/pwd != interviewer_id/pwd
		
		$interviewee_id = $this->find_user_by_email($interviewee_email)['id'];
		$interviewer_id = $this->find_user_by_email($interviewer_email)['id'];
		
		// create the tuple
		$query = "INSERT INTO `dannych_cse403c`.`interviews`
				  (`url`,`title`,`description`,`interviewer_id`,`interviewer_password`,`interviewee_id`,`interviewee_password`,`date_scheduled`) 
				  VALUES($url, $interview_title, $interview_description, $interviewer_id, $interviewer_password, $interviewee_id, $interviewee_password, $interview_date)";
		$this->execute($query);
		
		return true;
	}
	
	
	/**
	 *
	 * @param varchar(50) $pwd
	 * @return boolean
	 * 		false if exists same url in the table
	 *      true otherwise
	 */
	public function check_url($url)
	{
		$query = "SELECT url from interviews";
		$results = $this->execute($query)->fetchAll();
		
		foreach ($results as $result)
		{
			if( $result['url'] == $url )
				return false;			
		}
		return true;
	}
	
	/**
	 * 
	 * @param varchar(50) $pwd
	 * @return boolean 
	 * 		false if exists same password in the table
	 *      true otherwise
	 */
	public function check_password($pwd)
	{
		$query = "SELECT interviewer_password as password from interviews UNION SELECT interviewee_password as password from interviews";
		$results = $this->execute($query)->fetchAll();
		
		foreach ($results as $result)
		{
			if( $result['password'] == $pwd )
				return false;
		}
		return true;
	}
	
	// TODO: create check email?
	
	/**
	 * 
	 * @param varchar(25) $name
	 * @param varchar(30) $email
	 * @param varchar(1) $gender
	 * @param varchar(15) $phone
	 * 
	 * @effect 
	 * 		add user to the database if same person has not exist in the database which is identified by the email
	 * 
	 * @return
	 * 		true if success, false same email exists
	 */
	public function add_user($name = NULL , $email, $gender = NULL, $phone = NULL)
	{
		$name =  $this->quote($name);
		$email = $this->quote($email);
		$gender= $this->quote($gender);
		$phone = $this->quote($phone);
	
		$query = "INSERT INTO `dannych_cse403c`.`users` (`name`, `gender`, `email`, `phone`) VALUES ($name, $gender, $email, $phone)";
	
		if ( $this->email_isNotRegistered($email) ) {
			// not registered
			// insert the new user to database
			$this->execute($query);
		} else {
			// given email exists
			// - mistyped, send to somebody else ? solution : create email verification to accept the interview.
			// 		Yes or No, and interview will be automaticly deleted without any response from either particpant at scheduled time
	
			// - really exists ? ok skip
			return false;
		}
		
		return true;
	}
	
	
	/**
	 * 
	 * @param varchar(30) $email
	 * @return multitype:
	 * 		user information that has the given email
	 */
	public function find_user_by_email($email) 
	{
		$email = $this->quote($email);
		
		// TODO: email not found
		
		// email is unique so that it will only return one tuple			
		$query = "SELECT * FROM users where email = $email";
		$result = $this->execute($query)->fetchAll()[0];
			
		return $result;
	}
	
	/**
	 * 
	 * @param int $user_id
	 * 
	 * @effect
	 * 		delete user with the corresponding id from the database
	 */
	public function drop_user($user_id)
	{
		// TODO: check user_id
		
		$query = "DELETE FROM `dannych_cse403c`.`users` where id = $user_id";
		$this->execute($query);
	}
	
	/**
	 * 
	 * @param varchar(50) $url
	 * 
	 * @effect
	 * 		delete an interview session which identified with the given url
	 */
	public function drop_session($url)
	{		
		// TODO: check url
		
		$url = $this->quote($url);
		$query = "DELETE FROM `dannych_cse403c`.`interviews` where url = $url";
		$this->execute($query);
	}

	/**
	 * 
	 * @param varchar(30) $email
	 * @return boolean
	 */
	private function email_isNotRegistered($email)
	{
		//TODO: check email
		
		$email = $this->quote($email);
		$query = "SELECT COUNT(*) as num from users where email = $email";
		$result = $this->execute($query);
	
		// 0 rows means no matching email
		return $result->fetchAll()[0]['num'] == 0 ;
	}
	
	/**
	 * notes: documentation said that this will not resulted into race condition
	 * 
	 * @return integer that is an auto generated id from the last query before this
	 */
	private function get_lastInsertedId() {
		$query = "SELECT LAST_INSERT_ID() as id";
		return $this->execute($query)->fetchAll()[0]['id'];
	}
} 
?>