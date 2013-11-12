<?php
require_once 'simpletest/autorun.php';
require_once '../Utils/QueryHelper.php';

class TestQueryHelper extends UnitTestCase {
	function testGetSessionDNE() {
		$qH = new QueryHelper();
		$res = $qH->get_session("select * hmmmm yeah");
		$this->assertNull($res);
	}
	
	function testGetSession() {
		$qH = new QueryHelper();
		$res = $qH->get_session("a46qwr803na24");
		$this->assertEqual("Test Interview", $res["title"]);
		$this->assertEqual("To test the database lollol", $res["description"]);
		$this->assertEqual(1, $res["interviewer_id"]);
		$this->assertEqual("gj37hadnkds", $res["interviewer_password"]);
		$this->assertEqual(3, $res["interviewee_id"]);
		$this->assertEqual("asd2135jrtk", $res["interviewee_password"]);
	}
}

?>
