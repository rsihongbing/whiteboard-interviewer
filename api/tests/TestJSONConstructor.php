<?php
require_once 'simpletest/autorun.php';
require_once '../Utils/JSONConstructor.php';

class TestJSONConstructor extends UnitTestCase {
	
	function testGetSessionInfoJSON() {
		$var = new JSONConstructor();
		$json = json_decode($var->getSessionInfo(1), true);
		$this->assertEqual(1, $json["code"]);
		$this->assertEqual("Success", $json["message"]);
		$this->assertEqual("test interview 1", $json["title"]);
		$this->assertEqual("Yosan Namara", $json["name"]);
	}
	
	function testGetSessionInfoDNE() {
		$var = new JSONConstructor();
		$json = json_decode($var->getSessionInfo("bla bla bla bla"), true);
		$this->assertEqual(0, $json["code"]);
		$this->assertEqual("The given interviews_id does not exist", $json["message"]);
	}
}

?>