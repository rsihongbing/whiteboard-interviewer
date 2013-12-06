<?php
/**
 * Responsible for creating / finding information regarding an interview session.
 * 
 * Currently supports two verb:
 * 
 * 1. GET[url] => Retrieves all of the interview session information from the given url.
 * Look at JSONConstructor.php to see how it's implemented. By definition, GET would not
 * modify anything from the database.
 * 
 * 2. POST[interviewer_email, interviewee_email, date_scheduled] => Creates a new interview
 * session between interviewer_email and interviewee_email. A couple of things to notice:
 * 
 * @author ynamara
 */


require_once 'Utils/JSONConstructor.php';
header("Content-type: application/json");

$jsonFactory = new JSONConstructor();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["url"])) {
	echo $jsonFactory->getSessionInfo($_GET["url"]);
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["interviewer_email"]) &&
	isset($_POST["interviewee_email"]) && isset($_POST["date_scheduled"])) {
	
	// Optional parameters
	$title = isset($_POST["title"]) ? $_POST["title"] : null;
	$description = isset($_POST["description"]) ? $_POST["description"] : null;
	
	echo $jsonFactory->quick_createSession($_POST["interviewer_email"], $_POST["interviewee_email"],
			$_POST["date_scheduled"], $title, $description);
} else {
	// Caller does not follow specification. 
	header("HTTP/1.1 400 Invalid Request");
	die("An HTTP error 400 (invalid request) occurred.");
}

?>