<?php
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
