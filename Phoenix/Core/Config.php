<?php

namespace Phoenix\Core;

/**
 * Config stores and servers required configuration values.
 *
 * @version 1.18
 * @author MPI
 *        
 */
class Config {
    /* general constants */
    const SET = 1;
    const CLEAR = 0;
    
    /* config keys */
    const KEY_DIR_ROOT = 10;
    const KEY_DIR_APP = 11;
    const KEY_DIR_PHOENIX = 12;
    const KEY_DIR_TEMP = 13;
    const KEY_DIR_LOG = 14;
    const KEY_DIR_VENDOR = 15;
    const KEY_DIR_CACHE = 16;
    const KEY_DIR_WWW = 17;
    const KEY_DIR_APP_TEMPLATES = 18;
    const KEY_SITE_FQDN = 20;
    const KEY_SITE_BASE = 21;
    const KEY_SHUTDOWN_PAGE = 22;
    const KEY_ENVIRONMENT = 23;
    const KEY_LOG_SIZE = 24;
    const KEY_TIME_ZONE = 25;
    const KEY_FORCE_HTTPS = 26;
    const KEY_SESSION_INACTIVITY_ENABLED = 30;
    const KEY_SESSION_INACTIVITY_TIMEOUT = 31;
    const KEY_SESSION_INACTIVITY_REDIRECT_PATH = 32;
    const KEY_SESSION_FIXATION_DETECTION_ENABLED = 33;
    const KEY_SESSION_FIXATION_REDIRECT_PATH = 34;
    const KEY_DB_PRIMARY_POOL = 50;
    const KEY_DB_SECONDARY_POOL = 51;
    const KEY_DB_THIRD_POOL = 52;
    const KEY_APP_EXCEPTION_MODULE_NAME = 53;
    
    /* default config values for config keys */
    const DEFAULT_DIR_ROOT = __DIR__;
    const DEFAULT_DIR_APP = "/App";
    const DEFAULT_DIR_PHOENIX = "/Phoenix";
    const DEFAULT_DIR_TEMP = "/temp";
    const DEFAULT_DIR_LOG = "/log";
    const DEFAULT_DIR_VENDOR = "/vendor";
    const DEFAULT_DIR_CACHE = "/cache";
    const DEFAULT_DIR_WWW = "/www";
    const DEFAULT_DIR_APP_TEMPLATES = "/Templates";
    const DEFAULT_SITE_FQDN = "http://localhost/phoenix/";
    const DEFAULT_SITE_BASE = "/phoenix/";
    const DEFAULT_SHUTDOWN_PAGE = "/500";
    const DEFAULT_ENVIRONMENT = 0;
    const DEFAULT_LOG_SIZE = 4194304;
    const DEFAULT_TIME_ZONE = "Europe/Prague";
    const DEFAULT_FORCE_HTTPS = false;
    const DEFAULT_SESSION_INACTIVITY_ENABLED = true;
    const DEFAULT_SESSION_INACTIVITY_TIMEOUT = 1800;
    const DEFAULT_SESSION_INACTIVITY_REDIRECT_PATH = "/user/inactivity/";
    const DEFAULT_SESSION_FIXATION_DETECTION_ENABLED = true;
    const DEFAULT_SESSION_FIXATION_REDIRECT_PATH = "/user/fixation/";
    const DEFAULT_DB_PRIMARY_POOL = 1;
    const DEFAULT_DB_SECONDARY_POOL = 2;
    const DEFAULT_DB_THIRD_POOL = 3;
    const DEFAULT_APP_EXCEPTION_MODULE_NAME = "Exception";
    
    /* db keys */
    const DB_DRIVER = 1;
    const DB_SERVER = 2;
    const DB_PORT = 3;
    const DB_LOGIN = 4;
    const DB_PASSWORD = 5;
    const DB_SCHEMA = 6;
    const DB_CHARSET = 7;
    
    /* email keys */
    const EMAIL_SERVER = 1;
    const EMAIL_PORT = 2;
    const EMAIL_LOGIN = 3;
    const EMAIL_PASSWORD = 4;
    const EMAIL_SMTP_AUTH = 5;
    const EMAIL_SMTP_SECURE = 6;
    const EMAIL_FROM_NAME = 7;
    private static $config = array ();
    private static $db = array ();
    private static $email = array ();
    private static $registrationEnabled = true;

    private function __construct() {
    }

    /**
     * Get config value for given key.
     *
     * @param integer $key
     *            predefined constant Config::KEY_ (integer key); can be self defined integer constant (convention is integer grater than 1000)
     * @return mixed|null
     */
    public static function get($key) {
        if (empty(self::$config)) {
            self::setConfigDefaults();
        }
        return (is_int($key) && array_key_exists($key, self::$config)) ? self::$config[$key] : null;
    }

    /**
     * Set config value for given key.
     *
     * @param integer $key
     *            predefined constant Config::KEY_ (integer key); can be self defined integer constant (convention is integer grater than 1000)
     * @param mixed $value            
     * @return boolean
     */
    public static function set($key, $value) {
        if (!is_int($key)) {
            return false;
        }
        if (self::$registrationEnabled === true) {
            if (empty(self::$config)) {
                self::setConfigDefaults();
            }
            self::$config[$key] = $value;
            return true;
        }
        return false;
    }

    /**
     * Get absolute path for specified folder.
     *
     * @param integer $key
     *            valid keys are Config::KEY_DIR_*
     * @return string|null
     */
    public static function getAbsoluteFolderPath($key) {
        if (!is_int($key)) {
            return null;
        }
        if (empty(self::$config)) {
            self::setConfigDefaults();
        }
        switch ($key) {
            case self::KEY_DIR_ROOT :
                return self::$config[$key];
                break;
            case self::KEY_DIR_APP :
            case self::KEY_DIR_CACHE :
            case self::KEY_DIR_LOG :
            case self::KEY_DIR_PHOENIX :
            case self::KEY_DIR_TEMP :
            case self::KEY_DIR_VENDOR :
            case self::KEY_DIR_WWW :
                return self::$config[self::KEY_DIR_ROOT] . self::$config[$key];
                break;
            case self::KEY_DIR_APP_TEMPLATES :
                return self::$config[self::KEY_DIR_ROOT] . self::$config[self::KEY_DIR_APP] . self::$config[$key];
                break;
            default :
                return null;
        }
    }

    /**
     * Get Database config set for given key.
     *
     * @param integer $key            
     * @return null|array (with indexes Config::DB_)
     */
    public static function getDatabasePool($key) {
        if (!is_int($key) || empty(self::$db)) {
            return null;
        }
        return (is_int($key) && array_key_exists($key, self::$db)) ? self::$db[$key] : null;
    }

    /**
     * Set data of Database pool.
     *
     * @param integer $key
     *            can be used predefined constants Config::KEY_DB_ in use Config::get(Config::KEY_DB_);
     * @param string $driver
     *            available PDO drivers on your system (mysql, ...)
     * @param string $server            
     * @param string $port            
     * @param string $login            
     * @param string $password            
     * @param string $schema            
     * @param string $charset            
     * @return boolean
     */
    public static function setDatabasePool($key, $driver, $server, $port, $login, $password, $schema, $charset) {
        if (!is_int($key)) {
            return false;
        }
        if (self::$registrationEnabled === true) {
            if (empty(self::$db)) {
                self::$db = array ();
            }
            self::$db[$key] = array (
                            self::DB_DRIVER => $driver,
                            self::DB_SERVER => $server,
                            self::DB_PORT => $port,
                            self::DB_LOGIN => $login,
                            self::DB_PASSWORD => $password,
                            self::DB_SCHEMA => $schema,
                            self::DB_CHARSET => $charset 
            );
            return true;
        }
        return false;
    }

    /**
     * Get Email config set for given key.
     *
     * @param integer $key            
     * @return null|array (with indexes Config::EMAIL_)
     */
    public static function getEmailPool($key) {
        if (!is_int($key) || empty(self::$email)) {
            return null;
        }
        return (is_int($key) && array_key_exists($key, self::$email)) ? self::$email[$key] : null;
    }

    /**
     * Set data of Email pool.
     *
     * @param integer $key            
     * @param string $server            
     * @param string $port            
     * @param string $login            
     * @param string $password            
     * @param boolean $smtp_auth            
     * @param string $smtp_secure
     *            valid options (tls, ssl)
     * @param string $from_name            
     * @return boolean
     */
    public static function setEmailPool($key, $server, $port, $login, $password, $smtp_auth, $smtp_secure, $from_name) {
        if (!is_int($key)) {
            return false;
        }
        if (self::$registrationEnabled === true) {
            if (empty(self::$email)) {
                self::$email = array ();
            }
            self::$email[$key] = array (
                            self::EMAIL_SERVER => $server,
                            self::EMAIL_PORT => $port,
                            self::EMAIL_LOGIN => $login,
                            self::EMAIL_PASSWORD => $password,
                            self::EMAIL_SMTP_AUTH => $smtp_auth,
                            self::EMAIL_SMTP_SECURE => ($smtp_secure == "tls" || $smtp_secure == "ssl") ? $smtp_secure : "",
                            self::EMAIL_FROM_NAME => $from_name 
            );
            return true;
        }
        return false;
    }

    /**
     * Disable registration (modifications) of values in Config.
     * 
     * @return void
     */
    public static function disableRegistration() {
        self::$registrationEnabled = false;
    }

    /**
     * Get bool of registration enabled.
     *
     * @return boolean
     */
    public static function isRegistrationEnabled() {
        return self::$registrationEnabled;
    }

    /**
     * Set defaults to Config.
     * 
     * @return void
     */
    private static function setConfigDefaults() {
        $dir_root = substr(self::DEFAULT_DIR_ROOT, 0, strrpos(self::DEFAULT_DIR_ROOT, "/")); // remove /Core
        $dir_root = substr($dir_root, 0, strrpos($dir_root, "/")); // remove /Phoenix
                                                                   // $dir_root = self::DEFAULT_DIR_ROOT . "/../..";
        self::$config = array (
                        self::KEY_DIR_ROOT => $dir_root,
                        self::KEY_DIR_APP => self::DEFAULT_DIR_APP,
                        self::KEY_DIR_PHOENIX => self::DEFAULT_DIR_PHOENIX,
                        self::KEY_DIR_TEMP => self::DEFAULT_DIR_TEMP,
                        self::KEY_DIR_LOG => self::DEFAULT_DIR_LOG,
                        self::KEY_DIR_VENDOR => self::DEFAULT_DIR_VENDOR,
                        self::KEY_DIR_CACHE => self::DEFAULT_DIR_CACHE,
                        self::KEY_DIR_WWW => self::DEFAULT_DIR_WWW,
                        self::KEY_DIR_APP_TEMPLATES => self::DEFAULT_DIR_APP_TEMPLATES,
                        self::KEY_SITE_FQDN => self::DEFAULT_SITE_FQDN,
                        self::KEY_SITE_BASE => self::DEFAULT_SITE_BASE,
                        self::KEY_SHUTDOWN_PAGE => self::DEFAULT_SHUTDOWN_PAGE,
                        self::KEY_ENVIRONMENT => self::DEFAULT_ENVIRONMENT,
                        self::KEY_LOG_SIZE => self::DEFAULT_LOG_SIZE,
                        self::KEY_TIME_ZONE => self::DEFAULT_TIME_ZONE,
                        self::KEY_FORCE_HTTPS => self::DEFAULT_FORCE_HTTPS,
                        self::KEY_SESSION_INACTIVITY_ENABLED => self::DEFAULT_SESSION_INACTIVITY_ENABLED,
                        self::KEY_SESSION_INACTIVITY_TIMEOUT => self::DEFAULT_SESSION_INACTIVITY_TIMEOUT,
                        self::KEY_SESSION_INACTIVITY_REDIRECT_PATH => self::DEFAULT_SESSION_INACTIVITY_REDIRECT_PATH,
                        self::KEY_SESSION_FIXATION_DETECTION_ENABLED => self::DEFAULT_SESSION_FIXATION_DETECTION_ENABLED,
                        self::KEY_SESSION_FIXATION_REDIRECT_PATH => self::DEFAULT_SESSION_FIXATION_REDIRECT_PATH,
                        self::KEY_DB_PRIMARY_POOL => self::DEFAULT_DB_PRIMARY_POOL,
                        self::KEY_DB_SECONDARY_POOL => self::DEFAULT_DB_SECONDARY_POOL,
                        self::KEY_DB_THIRD_POOL => self::DEFAULT_DB_THIRD_POOL,
                        self::KEY_APP_EXCEPTION_MODULE_NAME => self::DEFAULT_APP_EXCEPTION_MODULE_NAME 
        );
    }
}
?>