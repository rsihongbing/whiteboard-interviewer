<?php
require_once 'QueryHelper.php';
require_once 'PasswordGenerator.php';

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
			$url = PasswordGenerator::generatePassword();
			$erPwd = PasswordGenerator::generatePassword();
			$eePwd = PasswordGenerator::generatePassword();
			
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
				return json_encode($result);
			} catch (Exception $ex) {
				if ($ex->getCode() == 1 || $ex->getCode() == 5) {
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
}
?>