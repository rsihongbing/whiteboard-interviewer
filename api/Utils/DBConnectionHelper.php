<?php
/**
 * A Singleton, Static helper class to access our database.
 * @author ynamara
 */
class DBConnectionHelper {
	/** The name of the DB. */
	private static $DB_NAME = "dannych_cse403c";
	/** The username of the DB. */
	private static $DB_USERNAME = "dannych";
	/** The password of the DB. */
	private static $DB_PASSWORD = "U6dPvb2m";
	/** The instance of this DB. The meat of singleton. */
	private static $selfInstance = null;
	/** The DB connection instance. */
	private $dbInstance = null;

	/** Constructor is private for singleton. */
	private function __construct() {
		$this->dbInstance =
			new PDO("mysql:dbname=".DBConnectionHelper::$DB_NAME, 
					DBConnectionHelper::$DB_USERNAME,
					DBConnectionHelper::$DB_PASSWORD);
		$this->dbInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	/**
	 * Initializes the instance of DBConnectionHelper This function must be called before
	 * DBConnectionHelper is used.
	 */
	public static function initialize() {
		if (DBConnectionHelper::$selfInstance == null) {
			DBConnectionHelper::$selfInstance = new DBConnectionHelper();
		}
	}

	/**
	 * Executes the given query against the DB.
	 * @param string $query
	 * 	Query to be executed. Caller is responsible for quoting sensitive information in the 
	 * 	argument to prevent SQL injection.
	 * @throws PDOException
	 * 	If we fail to query from the database. 
	 * @return PDOStatement
	 * 	The result of successful query.
	 */
	public static function executeQuery($query) {
		try {
			return DBConnectionHelper::$selfInstance->dbInstance->query($query);
		} catch (PDOException $e)  {
			throw $e;
		}
	}
	
	/**
	 * Escapes dangerous characters that are present in the argument. Call this function before
	 * passing user input to executeQuery() in order to prevent SQL injection.
	 * @param string $unsafeString 
	 * 	String to be escaped. Typically from user input.
	 * @return string
	 * 	$unsafeString, escaped.
	 */
	public static function quoteString($unsafeString) {
		return DBConnectionHelper::$selfInstance->dbInstance->quote($unsafeString);
	}
}

?>