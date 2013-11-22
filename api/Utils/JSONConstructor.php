<?php
require_once 'QueryHelper.php';
require_once 'PasswordGenerator.php';
require_once 'MailSender.php';
require_once 'URLMapping.php';

/**
 * Constructs JSON object that our REST API returns.
 * @author ynamara
 */
class JSONConstructor {
	private $queryHelper;
	
	public function __construct() {
		$this->queryHelper = new QueryHelper();
	}
	
	/**
	 * Retrieves the session information of $url.
	 * @param string $url
	 * @return string
	 * 	JSON string. See GitHub for documentation.
	 */
	public function getSessionInfo($url)  {
		$result = array();
		$ret = $this->queryHelper->get_session($url);
		if (is_null($ret)) {
			$result["code"] = "0";
			$result["message"] = "The given URL does not exist"; 
		} else {
			$result["code"] = "1";
			$result["message"] = "Success"; 
			foreach ($ret as $key => $value) {
				$result[$key] = $value;
			}
		}
		return json_encode($result);
	}

	/**
	 * Creates an interview session between the given interviewer and interviewee. 
	 *
	 * @param string $interviewer_email
	 * 	the email of the interviewer
	 * @param string $interviewee_email
	 * 	the email of the interviewee
	 * @param string $date_schedule
	 * 	must be in Y-m-d H:i:s format
	 * @param string $title
	 * 	interview's title
	 * @param string $description
	 * 	interview's description
	 * @return
	 * 	JSON string. See GitHub for documentation.
	 */
	public function createSession($interviewer_email, $interviewee_email, $date_scheduled,
			$title = null, $description = null) {
		// We need to generate random url, interviewe(r|e) password that hasn't been generated
		// before.
		
		while (true) {
			$url = $this->generateUrl();
			$erPwd = $this->generatePassword();
			$eePwd = $this->generatePassword();
			
			try {
				$this->queryHelper->create_session($url, $interviewer_email, $interviewee_email,
						$erPwd, $eePwd, $date_scheduled, $title,  $description);
				// Success, return result
				$result = array(
						"code" => "1",
						"message" => "Success",
						"url" => $url,
						"interviewer_password" => $erPwd,
						"interviewee_password" => $eePwd
				);
				
				// We're also sending emails to both interviewer and interviewee
				static::notifyRecipients($interviewer_email, $erPwd, $interviewee_email, $eePwd,
						$url, $date_scheduled);
				
				return json_encode($result);
			} catch (Exception $ex) {
				if ($ex->getCode() == 1 || $ex->getCode() == 5 || $ex->getCode() == 6) {
					// Either interviewer's and interviewee's email is the same, or email hasn't
					// been registered in the database yet. Reject.
					$result = array(
							"code" => "0",
							"message" => "Create session failure",
							"failure_reason" => $ex->getMessage(),
							"failure_code" => $ex->getCode()
					);
					return json_encode($result);
				}
				// Keep trying.
			}
		}
	}
	
	/**
	 * This will send email with the session URL to both interviewer and interviewee once a the
	 * session has been successfully generated.s
	 * 
	 * @param string $erEmail
	 * 	interviewer's email
	 * @param string $erPwd
	 * 	interviewer's password
	 * @param string $eeEmail
	 * 	interviewee's email
	 * @param string $eePwd
	 * 	interviewee's password
	 * @param string $url
	 * 	URL that is generated for both interviewer and interviewee
	 * @param string $date_scheduled
	 * 	date when the interview is scheduled
	 */
	private static function notifyRecipients($erEmail, $erPwd, $eeEmail, $eePwd, $url, $date) {
		// Sends email to interviewer.
		$erURL = URLMapping::generateInterviewURL($url, $erPwd);
		while (!MailSender::notifyInterview($erEmail, $date, $erURL));
		
		// Sends email to interviewee.
		$eeURL = URLMapping::generateInterviewURL($url, $eePwd);
		while (!MailSender::notifyInterview($eeEmail, $date, $eeURL));
	}
	
	/**
	 * Creates an interview session between the given interviewer and interviewee email 
	 * without either both were registered. 
	 * 
	 * @require
	 * 	$interviewer_email, $interviewee_email, $date_schedule are well formatted
	 *
	 * @param string $interviewer_email
	 * 	the email of the interviewer
	 * @param string $interviewee_email
	 * 	the email of the interviewee
	 * @param string $date_schedule
	 * 	must be in Y-m-d H:i:s format
	 * @param string $title
	 * 	interview's title
	 * @param string $description
	 * 	interview's description
	 * @return
	 * 	JSON string. See GitHub for documentation.
	 */
	public function quick_createSession($interviewer_email, $interviewee_email, $date_scheduled,
			$title = null, $description = null) {
		
		if($this->queryHelper->check_email($interviewer_email) == 0) {
			$this->queryHelper->add_user($interviewer_email);
		}
		
		
		if($this->queryHelper->check_email($interviewee_email) == 0) {
			$this->queryHelper->add_user($interviewee_email);
		}
		
		return $this->createSession($interviewer_email, $interviewee_email, $date_scheduled, $title, $description);
	}
	
	/**
	 * Generate random url but unique
	 * 
	 * @return string
	 * 	url that unique in the database
	 */
	private function generateUrl() {
		$url;
		do{
			$url = PasswordGenerator::generatePassword();
		} while ( $this->queryHelper->check_url($url) );
		
		return $url;
	}
	
	/**
	 * Generate random password but unique
	 * 
	 * @return string
	 * 	password that unique in the database
	 */
	private function generatePassword() {
		$pwd;
		do{
			$pwd = PasswordGenerator::generatePassword();
		} while ( $this->queryHelper->check_password($pwd) );
		
		return $pwd;
	}
}
?>