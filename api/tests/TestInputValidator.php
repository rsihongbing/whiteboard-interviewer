<?php
require_once 'simpletest/autorun.php';
require_once '../Utils/InputValidator.php';

class TestInputValdator extends UnitTestCase {
	
	function testEmailValid() {
		$this->assertTrue(InputValidator::isEmailValid("yosan@email.com"));
		$this->assertTrue(InputValidator::isEmailValid("yosan.nam2ara@email.net"));
		$this->assertTrue(InputValidator::isEmailValid("yosan_na1mara@email.edu"));
		$this->assertTrue(InputValidator::isEmailValid("yosan123namara@email.com"));
		$this->assertTrue(InputValidator::isEmailValid("123@email.com"));
	}
	
	function testEmailInvalid() {
		$this->assertFalse(InputValidator::isEmailValid(".@.com"));
		$this->assertFalse(InputValidator::isEmailValid(" @ .com"));
		$this->assertFalse(InputValidator::isEmailValid("@.com"));
		$this->assertFalse(InputValidator::isEmailValid("__@__"));
		$this->assertFalse(InputValidator::isEmailValid("yeah@yeah"));
		$this->assertFalse(InputValidator::isEmailValid(null));
	}
	
	function testFuture() {
		$this->assertTrue(InputValidator::isFuture(date("Y-m-d H:i:s", strtotime("+1 day"))));
	}
	
	function testNotFuture() {
		$this->assertFalse(InputValidator::isFuture(date("Y-m-d H:i:s", strtotime("-1 day"))));
		$this->assertFalse(InputValidator::isFuture(date("Y-m-d H:i:s", strtotime("+0 day"))));
	}
	
	function testDateInvalid() {
		$this->assertFalse(InputValidator::isDateValid("hello"));
		$this->assertFalse(InputValidator::isDateValid("01/01/2020"));
		$this->assertFalse(InputValidator::isDateValid("1234/12/12"));
		$this->assertFalse(InputValidator::isFuture(date("Y-m-d H:i:s", strtotime("-1 day"))));
		$this->assertFalse(InputValidator::isFuture(date("Y-m-d H:i:s", strtotime("+0 day"))));
	}
	
	function testDateValid() {
		$this->assertTrue(InputValidator::isDateValid(date("Y-m-d H:i:s", strtotime("+1 day"))));
		$var = date("Y-m-d H:i:s", strtotime("+1 day"));
		$this->assertTrue($var);
	}
}

?>