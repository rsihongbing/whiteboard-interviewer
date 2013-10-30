<?php
require_once 'simpletest/autorun.php';
require_once '../Utils/QueryHelper.php';

class TestQueryHelper extends UnitTestCase {
	
	function testGetSessionInfoFuture() {
		$var = new QueryHelper();
		$output;
		$retVal = $var->getSessionInfo(1, $output);
		$this->assertEqual(1, $retVal);
		$this->assertEqual("Yosan Namara", $output["name"]);
		$this->assertEqual("test interview 1", $output["title"]);
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
