<?php
require_once 'simpletest/autorun.php';
require_once '../Utils/JSONConstructor.php';

class TestJSONConstructor extends UnitTestCase {
	
	function testGetSessionInfoJSON() {
		$var = new JSONConstructor();
		$json = json_decode($var->getSessionInfo("a46qwr803na24"), true);
		$this->assertEqual(1, $json["code"]);
		$this->assertEqual("Success", $json["message"]);
		$this->assertEqual("Test Interview", $json["title"]);
		$this->assertEqual("Danny Ch", $json["interviewer_name"]);
	}
	
	function testGetSessionInfoDNE() {
		$var = new JSONConstructor();
		$json = json_decode($var->getSessionInfo("bla bla bla bla"), true);
		$this->assertEqual(0, $json["code"]);
		$this->assertEqual("The given interviews_url does not exist", $json["message"]);
	}
}

?>