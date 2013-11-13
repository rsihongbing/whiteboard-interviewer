<?php
require_once 'simpletest/autorun.php';
require_once '../Utils/DBConnectionHelper.php';

/**
 * @author ynamara
 */
class TestDBConnectionHelper extends UnitTestCase {
	function setUp() {
		DBConnectionHelper::initialize();
	}
	
	function testPullSingleRecord() {
		$query = "select * from interviews limit 1";
		$rows = DBConnectionHelper::executeQuery($query)->fetchAll();
		$this->assertEqual(1, count($rows));
	}
	
	function testGoodQuoteString() {
		$query = "select * from interviews where url = " . DBConnectionHelper::quoteString("a46qwr803na24");
		$rows = DBConnectionHelper::executeQuery($query)->fetchAll();
		$this->assertEqual(1, count($rows));
	}
	
	function testStringQuote() {
		$string = 'Nice';
		$unquotedString = "result=$string";
		$this->assertEqual("result=Nice", $unquotedString);
		$quotedString = "result=" . DBConnectionHelper::quoteString($string);
		$this->assertEqual("result='Nice'", $quotedString);
	}
	
	function testNullQuote() {
		$this->assertEqual("''", DBConnectionHelper::quoteString(null));
	}
}

?>