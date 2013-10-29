<?php
require_once 'simpletest/autorun.php';
require_once '../Utils/PasswordGenerator.php';
class TestPasswordGenerator extends UnitTestCase {
	function testPasswordDefaultLength() {
		for ($i = 0; $i < 100; $i++) {
			$pwd = PasswordGenerator::generatePassword();
			$this->assertEqual(30, strlen($pwd));
		}
		
	}
	
	function testUniqueness() {
		$pwd1 = PasswordGenerator::generatePassword();
		$pwd2 = PasswordGenerator::generatePassword();
		$this->assertNotEqual($pwd1, $pwd2);
	}
}
?>