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
	 * 
	 * @param varchar(50) $url
	 * @return 
	 *  NULL if given url is not exist,
	 * 	multitype: all columns from interview that correspondent to the given url
	 */
	public function get_session($url) {		
		$url = $this->quote($url);
		$query = "SELECT * from interviews where url = $url";
		$results = $this->execute($query)->fetchAll(PDO::FETCH_ASSOC);
		return (count($results) == 1) ? $results[0] : null;
	}
	
	/**
	 * 
	 * @param varchar(50) $url
	 * @param varchar(30) $interviewer_email
	 * @param varchar(50) $interviewer_password
	 * @param varchar(30) $interviewee_email
	 * @param varchar(50) $interviewee_password
	 * @param varchar(35) $interview_title
	 * @param String $interview_description
	 * @param String $interview_date
	 * 
	 * @throws Exception
	 */
	public function create_session($url, $interviewer_email, $interviewee_email, 
			$interviewer_password, $interviewee_password, $interview_date,
			$interview_title = NULL, $interview_description = NULL)
	{	
		try {
			$url = $this->quote($url);
			$interview_title = $this->quote($interview_title);
			$interview_description = $this->quote($interview_description);
			$interviewer_email = $this->quote($interviewer_email);
			$interviewee_email = $this->quote($interviewee_email);
			$interviewee_password = $this->quote($interviewee_password);
			$interviewer_password = $this->quote($interviewer_password);
			$interview_date = $this->quote($interview_date);
			
			// validate the given parameter
			$this->validate_info($url,$interviewer_email, $interviewer_password, $interviewee_email, $interviewee_password);
			
			// XXX: Crash if email does not exist
			$interviewee_id = $this->find_user_by_email($interviewee_email)['id'];
			$interviewer_id = $this->find_user_by_email($interviewer_email)['id'];
			
			// create the tuple
			$query = "INSERT INTO `dannych_cse403c`.`interviews`
					  (`url`,`title`,`description`,`interviewer_id`,`interviewer_password`,`interviewee_id`,`interviewee_password`,`date_scheduled`) 
					  VALUES($url, $interview_title, $interview_description, $interviewer_id, $interviewer_password, $interviewee_id, $interviewee_password, $interview_date)";
			$this->execute($query);
			
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	/**
	 * 
	 * @param varchar(50) $url
	 * @param varchar(30) $interviewer_email
	 * @param varchar(50) $interviewer_password
	 * @param varchar(30) $interviewee_email
	 * @param varchar(50) $interviewee_password
	 * 
	 * @throws Exception
	 */
	private function validate_info($url,$interviewer_email, $interviewer_password, $interviewee_email, $interviewee_password) {
		if ($this->check_url($url) )
			throw new Exception("Same URL exists in the database", 0);
		
		if ($interviewee_email == $interviewer_email)
			throw new Exception("Interviewer's email and interviewee email cannot be the same", 1);
		
		if ($interviewee_password == $interviewer_password)
			throw new Exception("Interviewer's password and interviewee's password cannot be the same", 2);
		
		// XXX: Why not?
		if ($this->check_password($interviewee_password))
			throw new Exception("Interviewee's password already exists", 3);
		if ($this->check_password($interviewer_password)) 
			throw new Exception("Interviewer's password already exists", 4);
	}
	
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
	public function add_user($name, $email, $gender = NULL, $phone = NULL)
	{
		try {
			$name =  $this->quote($name);
			$email = $this->quote($email);
			$gender= $this->quote($gender);
			$phone = $this->quote($phone);
			
			$query = "INSERT INTO `dannych_cse403c`.`users` (`name`, `gender`, `email`, `phone`) VALUES ($name, $gender, $email, $phone)";
			
			if ( $this->check_email($email) ) {
				return false;
			}
			
			$this->execute($query);
		} catch (Exception $e) {

			return false;
		}
		
		return true;
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
		// no need to check url
		// mySQL will do this job and not throw exception if it is not in the table
	
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
		// no need to check url
		// mySQL will do this job and not throw exception if it is not in the table
	
		$url = $this->quote($url);
		$query = "DELETE FROM `dannych_cse403c`.`interviews` where url = $url";
		$this->execute($query);
	}
	
	/**
	 * 
	 * @param varchar(50) $url
	 * @return number;
	 * 	0 means same url does not exist,
	 *  1 means same url exists,
	 *  otherwise database integrity failure 
	 */
	public function check_url($url)
	{
		$url = $this->quote($url);
		$query = "SELECT * from interviews where url = $url";
		$results = $this->execute($query)->fetchAll();
		
		return count($results);
	}
	
	/**
	 * 
	 * @param varchar(50) $pwd
	 * 	password to be checked in the database
	 * 
	 * @return number;
	 * 	0 means same password does not exist,
	 *  1 means same password exists,
	 *  otherwise database integrity failure 
	 */
	public function check_password($pwd)
	{
		$pwd = $this->quote($pwd);
		$query = "SELECT a.* FROM (SELECT interviewer_password as password from interviews UNION SELECT interviewee_password as password from interviews) a where a.password = $pwd";
		$results = $this->execute($query)->fetchAll();
		
		return count($results);
	}
	
	/**
	 * 
	 * @param varchar(30) $email
	 * 	user' email that to be check in the database
	 * 
	 * @return number;
	 * 	0 means given email does not exist,
	 *  1 means given email exists,
	 *  otherwise database integrity failure
	 */
	public function check_email($email)
	{
		$email = $this->quote($email);
		$query = "SELECT * from users where email = $email";
		$results = $this->execute($query)->fetchAll();
	
		return count($results);
	}
	
	/**
	 * 
	 * @param varchar(30) $email
	 * @return 
	 * 	NULL if give email is not exist	
	 * 	multitype: user information that has the given email
	 */
	public function find_user_by_email($email) 
	{
		$email = $this->quote($email);
		
		// email is unique so that it will only return one tuple			
		$query = "SELECT * FROM users where email = $email";
		$results = $this->execute($query)->fetchAll();
		
		switch (count($results)) {
			case 0:
				return NULL;
			case 1:
				return $results[0];
			default:
				// strange database
				return NULL;
		}
	}
} 
?>