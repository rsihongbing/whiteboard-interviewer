<?php
 
/**
 * Will be used by together with MailSender. Since we want to invite users to the correct URL,
 * relative to where the session is generated.
 * 
 * @author ynamara
 */
class URLMapping {
	/** 
	 * Path to the interview room relative to the project directory. This is where we invite
	 * interviewer/ee to go.
	 */
	private static $PathToInterviewRoom = "room.php";
	
	
	/** Ensure non-instantiability */
	private function __construct() {
		throw new Exception("URLMapping is a static class");
	}
	

	/**
	 * @return string
	 * 	either http or https, depending on the current location.
	 */
	public static function getProtocol() {
		return preg_match('/https/i', $_SERVER["SERVER_PROTOCOL"]) ? "https" : "http";
	}
	
	/**
	 * @return string
	 * 	example: "cubist.cs.washington.edu"
	 */
	public static function getHostName() {
		return $_SERVER["HTTP_HOST"];
	}
	
	/**
	 * @return string
	 * 	relative path of the current file.
	 *	example: /~ynamara/api/Utils/URLMapping.php
	 */
	public static function getPath() {
		return $_SERVER["REQUEST_URI"];
	}
	
	/**
	 * The meat of URLMapping.
	 * 
	 * Example:
	 * http://cubist.cs.washington.edu/~ynamara/
	 * 
	 * or
	 * 
	 * http://cubist.cs.washington.edu/projects/13au/cse403/cse403g/dev/
	 * 
	 * depending on where our codes are currently running.
	 * 
	 * @return string
	 * 	absolute base URL that you can trust, depending on where this code is running.
	 */
	public static function getRootDomain() {
		$path = static::getPath();
		$rootDomain = static::getProtocol() . "://" . static::getHostName();
		if (preg_match('/\/cse403g\/dev/', $path)) {
			// We're currently running on dev.
			return $rootDomain . "/projects/13au/cse403/cse403g/dev/";
		} else if (preg_match('/\/cse403g/', $path)) {
			// The so-called 'production' branch.
			return $rootDomain . "/projects/13au/cse403/cse403g/";
		} else if (preg_match('/~ynamara/', $path)) {
			return $rootDomain . "/~ynamara/";
		} else if (preg_match('/~dannych/', $path)) {
			return $rootDomain . "/~dannych/";
		} else if (preg_match('/~ctjong/', $path)) {
			return $rootDomain . "/~ctjong/";
		} else if (preg_match('/~tuanvo/', $path)) {
			return $rootDomain . "/~tuanvo/";
		} else if (preg_match('/~bing04/', $path)) {
			return $rootDomain . "/~bing04/";
		}
	}
	
	/**
	 * Generates interview URL with its query parameters, relative to the enviroment.
	 * 
	 * @param string $url
	 * 	url to the interview session
	 * @param string $pid
	 * 	user's password
	 */
	public static function generateInterviewURL($url, $pid) {
		$baseURL = static::getRootDomain() . static::$PathToInterviewRoom;
		$query = array(
				"url" => $url,
				"pid" => $pid
		);
		return $baseURL . "?" . http_build_query($query);
	}
}
?>

