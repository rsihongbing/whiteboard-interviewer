<?php
require_once 'Utils/JSONConstructor.php';
header("Content-type: application/json");

$jsonFactory = new JSONConstructor();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["interviews_id"])) {
	echo $jsonFactory->getSessionInfo($_GET["interviews_id"]);
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["interview_title"]) &&
	isset($_POST["interview_date"]) && isset($_POST["interview_password"]) && 
	isset($_POST["interviewer_id"]) && isset($_POST["interviewee_id"])) {
	echo $jsonFactory->createSession($_POST["interview_title"], $_POST["interview_date"],
			$_POST["interview_password"], $_POST["interviewer_id"], $_POST["interviewee_id"]);
} else {
	header("HTTP/1.1 400 Invalid Request");
	die("An HTTP error 400 (invalid request) occurred.");
}

?>