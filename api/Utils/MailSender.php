<?php
require_once 'Template.php';

/**
 * A Static class that abstracts email sending process.
 * @author ynamara
 */
class MailSender {
	/** Will be displayed in the FROM part of the email. Must be @ourDomain. */
	private static $FROM = "Whiteboard Interviewer <DoNotReply@cs.washington.edu>";
	/** Replies will be send to me for now, since we don't have our own email server. */
	private static $REPLY_TO = "ynamara@cs.washington.edu";

	/** Ensure non-instantiability */
	private function __construct() {
		throw new Exception("MailSender is a static class");
	}

	/**
	 * Sends the interview sessions' URL to the users.
	 * @param string $mailTo
	 * 	must be a valid email address
	 * @param string $interviewDate
	 * 	must be a valid date
	 * @param string $interviewURL
	 * 	must be a valid URL
	 * @return boolean
	 * 	true upon success, false otherwise.
	 */
	public static function notifyInterview($mailTo, $interviewDate, $interviewURL) {
		// Convert SQL date to a more user-friendly format.
		$interviewDay = date("l, F d, Y", strtotime($interviewDate));
		$interviewTime = date("g:i:s a", strtotime($interviewDate));

		// Inject the desired values to our template. Note that order matters.
		$message = Template::getNotifyInterview();
		
		
		$replacePatterns = array();
		$replacePatterns[0] = '/\{date\}/' ;
		$replacePatterns[1] = '/\{url\}/' ;

		$replacementValue = array();
		$replacementValue[0] = $interviewDay . " at " . $interviewTime;
		$replacementValue[1] = $interviewURL;

		$message = preg_replace($replacePatterns, $replacementValue, $message);
		
		return static::sendEmail($mailTo, "Whiteboard Interviewer: Your Interview Schedule", $message);
	}

	/**
	 * Sends email.
	 *
	 * @param string $to
	 * 	email destination. Multiple destination can be separated with a comma.
	 * @param string $subject
	 * 	subject of the email
	 * @param string $message
	 * 	message to be sent
	 * @param boolean $isHTML
	 * 	whether or not $message is written in HTML
	 * @return boolean
	 * 	true upon success, false otherwise.
	 */
	public static function sendEmail($to, $subject, $message, $isHTML = false) {
		$headers = "FROM: " . static::$FROM . "\r\n";
		$headers .= "Reply-To: " . static::$REPLY_TO . "\r\n";
		if ($isHTML) {
			$headers .= "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		}
		return mail($to, $subject, wordwrap($message, 70), $headers);
	}
}
?>

