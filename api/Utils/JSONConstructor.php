<?php
require_once 'QueryHelper.php';

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
	 * Retrives session information for the given id in JSON format.
	 * 
	 * @param string $url
	 * 	the interview's url
	 * @return string
	 * 	session information in JSON. See specification on GitHub.
	 */
	public function getSessionInfo($url)  {
		$output;
		$retVal = $this->queryHelper->getSessionInfo($url, $output);
		$result = array("code" => $retVal);
		
		switch ($retVal) {
			case -1:
				$result["message"] = $output;
				break;
			case 0:
				$result["message"] = "The given interviews_url does not exist";
				break;
			default:
				$result["message"] = "Success";
				foreach ($output as $key => $value) {
					$result[$key] = $value;
				}
		}
		return json_encode($result);
	}
	
	/**
	 * Creates a new interview session.
	 * 
	 * @param string $interview_title
	 * 	the title of the interview
	 * @param string $interview_date
	 * 	must be in Y-m-d H:i:s format
	 * @param string $interview_password
	 * 	password for the interview session
	 * @param string $interviewer_id
	 * 	interviewer's id
	 * @param string $interviewee_id
	 * 	interviewee's id
	 * @return string
	 * 	JSON object that contains interview_id upon success
	 */
	public function createSession($interview_title, $interview_date, $interview_password, 
			$interviewer_id, $interviewee_id) {
		// TODO: Not sure what's gonna happen if QueryHelper::create_session fails....
		$id = $this->queryHelper->create_session($interview_title, $interview_date, $interview_password, $interviewer_id, $interviewee_id);
		
		$result = array("code" => 1,
			"message" => "Success",
			"interview_id" => $id						
		);
		return json_encode($result);
	}
}
?>