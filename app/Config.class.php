<?php
/**
 * Config stores and servers required configuration values.
 *
 * @version 1.0
 * @author MPI
 * */
class Config{
	const SITE_PATH = "http://localhost/phoenix/";
	const SITE_BASE = "/phoenix/";
	const SHUTDOWN_PAGE = "500"; // code of error page
	const LOG_DIR = "log";
	const LOG_SIZE = 4194304; // 4 MB
	const TIME_ZONE = "Europe/Prague";
	const SERVER_FQDN = "x";
	const SERVER_INTERNAL_IP = "x";
	const SERVER_PORT = "x";
	const SERVER_PROTOCOL = "x";
	
	const SET = 1;
	const CLEAR = 2;
	
	private static $db_params = array(
			"server" => "localhost",
			"port" => "3306",
			"login" => "phoenix",
			"password" => "phoenix",
			"schema" => "phoenix"
	);
	private static $email = array(
			"server" => "x",
			"username" => "x",
			"password" => "x",
			"port" => "25",
			"smtp_auth" => true,
			"from_name" => "x",
			"smtp_secure" => null
	);

	private function __construct(){
	}

	/**
	 * Get configuration parameters to db.
	 *
	 * @return string array
	 */
	public static function getDbParams(){
		return self::$db_params;
	}

	/**
	 * Get configuration parameters to email server.
	 *
	 * @return string array
	 */
	public static function getEmailParams(){
		return self::$email;
	}
}
?>
