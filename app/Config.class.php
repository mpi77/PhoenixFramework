<?php
/**
 * Config stores and servers required configuration values.
 *
 * @version 1.7
 * @author MPI
 * */
class Config {
    const APP_ENVIRONMENT = System::ENV_DEVELOPMENT;
    const SITE_PATH = "http://localhost/phoenix/";
    const SITE_BASE = "/phoenix/";
    const SHUTDOWN_PAGE = "500"; // code for an error page
    const LOG_DIR = "log";
    const LOG_SIZE = 4194304; // 4 MB
    const TIME_ZONE = "Europe/Prague";
    const SERVER_FQDN = "x";
    const SERVER_INTERNAL_IP = "x";
    const SERVER_PORT = "x";
    const SERVER_PROTOCOL = "x";
    const SESSION_INACTIVITY_ENABLED = true;
    const SESSION_INACTIVITY_TIMEOUT = 1800;
    const SESSION_INACTIVITY_REDIRECT_PATH = "user/inactivity/";
    const SESSION_FIXATION_DETECTION_ENABLED = true;
    const SESSION_FIXATION_REDIRECT_PATH = "user/fixation/";
    const SET = 1;
    const CLEAR = 0;
    const DB_DEFAULT_POOL = 1;
    private static $dbParams = array (
                    self::DB_DEFAULT_POOL => array (
                                    "server" => "localhost",
                                    "port" => "3306",
                                    "login" => "phoenix",
                                    "password" => "phoenix",
                                    "schema" => "phoenix",
                                    "charset" => "utf8",
                                    "driver" => "mysql" 
                    ) 
    );
    private static $email = array (
                    "server" => "x",
                    "username" => "x",
                    "password" => "x",
                    "port" => "25",
                    "smtp_auth" => true,
                    "from_name" => "x",
                    "smtp_secure" => null 
    );

    private function __construct() {
    }

    /**
     * Get configuration parameters for connection to db.
     *
     * @param integer $connectionId            
     * @return string array
     */
    public static function getDatabaseConnectionParams($connectionId) {
        return self::$dbParams[$connectionId];
    }

    /**
     * Get configuration parameters to email server.
     *
     * @return string array
     */
    public static function getEmailParams() {
        return self::$email;
    }
}
?>
