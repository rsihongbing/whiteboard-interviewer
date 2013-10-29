<?php
require_once 'simpletest/autorun.php';
require_once '../Utils/DBConnectionHelper.php';
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
		$query = "select * from interviews where id = " . DBConnectionHelper::quoteString("1");
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
}

?>