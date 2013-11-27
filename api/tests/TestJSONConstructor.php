<?php
require_once 'simpletest/autorun.php';
require_once '../Utils/JSONConstructor.php';
require_once '../Utils/QueryHelper.php';

class TestJSONConstructor extends UnitTestCase {
	function testGetSessionInfoJSON() {
		$var = new JSONConstructor();
		$json = json_decode($var->getSessionInfo("a46qwr803na24"), true);
		$this->assertEqual(1, $json["code"]);
		$this->assertEqual("Success", $json["message"]);
		$this->assertEqual("Test Interview", $json["title"]);
		$this->assertEqual("To test the database lollol", $json["description"]);
		$this->assertEqual(1, $json["interviewer_id"]);
		$this->assertEqual("gj37hadnkds", $json["interviewer_password"]);
		$this->assertEqual(3, $json["interviewee_id"]);
		$this->assertEqual("asd2135jrtk", $json["interviewee_password"]);
	}
	
	function testGetSessionInfoDNE() {
		$var = new JSONConstructor();
		$json = json_decode($var->getSessionInfo("bla bla bla bla"), true);
		$this->assertEqual(0, $json["code"]);
		$this->assertEqual("The given URL does not exist", $json["message"]);
	}
	

	// Excluded from the unit test due to the unit test framework bug.
	function CreateDropSession() {
		$erEmail = "ynamara@uw.edu";
		$eeEmail = "dannych@uw.edu";
		$time = date("Y-m-d H:i:s", strtotime("+1 day"));
		$vr = new JSONConstructor();
		$js = json_decode($vr->createSession($erEmail, $eeEmail, $time));
		$this->assertEqual(1, $js["code"]);
		$this->assertEqual("Success", $js["message"]);
		
		$qH = new QueryHelper();
		$qH->drop_session($js["url"]);
	}
}

?>