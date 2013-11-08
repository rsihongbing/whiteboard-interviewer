<?php
require_once 'simpletest/autorun.php';
require_once '../Utils/QueryHelper.php';

class TestQueryHelper extends UnitTestCase {
	
	function testGetSessionInfoFuture() {
		$var = new QueryHelper();
		$output;
		$retVal = $var->getSessionInfo('a46qwr803na24', $output);
		$this->assertEqual(1, $retVal);
		$this->assertEqual("Danny Ch", $output['interviewer_name']);
		$this->assertEqual("Test Interview", $output['title']);
	}
	
	function testGetSessionInfoDNE() {
		$var = new QueryHelper();
		$output = null;
		$retVal = $var->getSessionInfo("select *", $out);
		$this->assertEqual(0, $retVal);
		$this->assertNull($output);
	}
}

?>
