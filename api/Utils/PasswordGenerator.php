<?php
/**
 * A Static class to generate password.
 * @author ynamara
 */
class PasswordGenerator {
	/** All of the chars in the generated password will be a subset of this. */
	private static $RANGE = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
	
	/** Ensures non-instantiability. */
	private function __construct() {
		throw new Exception("PasswordGenerator is a static class");
	}
	
	/**
	 * Generates random alphanumeric password with the specified length.
	 * @param number $pwdLen
	 * 	the desired length of the generated password. The behavior is undefined when $pwdLen < 0.
	 * @return string
	 * 	random alphanumeric string with the specified length.
	 */
	public static function generatePassword($pwdLen = 50) {
		$result = array();
		$len = strlen(static::$RANGE) - 1;
		for ($i = 0; $i < $pwdLen; $i++) {
			$n = rand(0, $len);
			$result[] = static::$RANGE[$n];
		}
		return implode($result);
	}
}
?>