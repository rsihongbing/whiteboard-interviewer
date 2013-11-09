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
 * - interviewer_email and interviewee_email must exist in the database.
 * - interviewer_email and interviewee_email cannot be the same.
 * - date_scheduled must be in Y-m-d H:i:s format.
 * 
 * Ensure to satisfy the above requirement, otherwise the behavior is undefined.
 * You have been warned.
 * 
 * 
 * TODO:
 * 1. Ensure that email addresses are valid, and less than 30 chars.
 * 2. Ensure the date is in the right format, and must be a future date.
 * 3. We need a way to standardize the date, in case there are timezone differences.
 * 4. Ensure that interview_title is less than 35 chars.
 * 5. Find a way to enforce permission on this API.
 * 
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
	
	echo $jsonFactory->createSession($_POST["interviewer_email"], $_POST["interviewee_email"],
			$_POST["date_scheduled"], $title, $description);
} else {
	// Caller does not follow specification. 
	header("HTTP/1.1 400 Invalid Request");
	die("An HTTP error 400 (invalid request) occurred.");
}

?>