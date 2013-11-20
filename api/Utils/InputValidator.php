<?php
class InputValidator {
	/** Ensure non-instantiability */
	private function __construct() {
		throw new Exception("InputValidator is a static class");
	}
	
	/**
	 * Validates email address.
	 *
	 * @param string $email
	 * @return boolean
	 * 	true iff the given email address is valid
	 */
	public static function isEmailValid($email) {
		return !!filter_var($email, FILTER_VALIDATE_EMAIL);
	}
	
	/**
	 * Ensures that the given date is in the Y-m-d H:i:s format, and it's a future date.
	 *
	 * @param string $date
	 * @return boolean
	 * 	true iff the given date is in the right format, and it's a future date.
	 */
	public static function isDateValid($date) {
		$expectedFormat = "Y-m-d H:i:s";
		$d = DateTime::createFromFormat($expectedFormat, $date);
		return $d && $d->format($expectedFormat) == $date && static::isFuture($date);
	}
	
	/**
	 * Ensures that the given date is a future date.
	 *
	 * @param string $date
	 * @return boolean
	 * 	true iff the given date happens to be in the future.
	 */
	public static function isFuture($date) {
		return (strtotime($date) > time());
	}
}

?>