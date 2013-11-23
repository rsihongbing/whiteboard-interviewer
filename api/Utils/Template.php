<?php
/**
 * This holds templates. For example, for email templates.
 * 
 * Originally, I was planning to use file_get_contents to read the file that we want whenever we
 * need it. However, there's a problem with AJAX request that makes file_get_contents to return
 * an empty string. Note that this is not an issue if we access the page directly in PHP.
 * 
 * This is a bad design. Fix it if you can.
 * 
 * @author ynamara
 */
class Template {

	public static function getNotifyInterview() {
		$msg = <<< EOF
Hello,

Thank you for using Whiteboard Interviewer.
You have been scheduled for an interview on {date}.
Below is your link to the interview room that we made just for you:
{url}

Sincerely,
Whiteboard Interviewer teams.
EOF;
		return $msg;		
	}
}
?>
