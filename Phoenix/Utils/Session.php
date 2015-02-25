<?php

namespace Phoenix\Utils;

use \Phoenix\Core\Config;
use \Phoenix\Utils\System;
// use \Phoenix\Utils\Security;

/**
 * Session utils.
 *
 * @version 1.1
 * @author MPI
 *        
 */
class Session {
    const KEY_USER_UID = 101;
    const KEY_USER_GID = 102;
    const KEY_USER_AUTH = 103;
    const KEY_USER_TYPE = 104;
    const KEY_USER_LANG = 105;
    const KEY_USER_EMAIL = 106;
    const KEY_USER_FIRST_NAME = 107;
    const KEY_USER_LAST_NAME = 108;
    const KEY_USER_LAST_LOGIN = 109;
    const KEY_CFG_PAGE_SIZE = 201;
    private static $registrationEnabled = true;

    private function __constructor() {
    }

    /**
     * Initialize session with defined structure.
     *
     * @todo set default value KEY_CFG_PAGE_SIZE
     * @todo run Security functions
     */
    public static function init() {
        $site_fqdn = Config::get(Config::KEY_SITE_FQDN);
        
        /* set user fefaults */
        if (!array_key_exists(self::KEY_USER_UID, $_SESSION[$site_fqdn]) || !array_key_exists(self::KEY_USER_GID, $_SESSION[$site_fqdn]) || !array_key_exists(self::KEY_USER_AUTH, $_SESSION[$site_fqdn]) || !array_key_exists(self::KEY_USER_TYPE, $_SESSION[$site_fqdn]) || !array_key_exists(self::KEY_USER_LANG, $_SESSION[$site_fqdn])) {
            self::loadUserDefaults();
            // Security::initAuthToken();
        }
        
        /* set cfg defaults */
        if (!array_key_exists(self::KEY_CFG_PAGE_SIZE, $_SESSION[$site_fqdn])) {
            self::set(self::KEY_CFG_PAGE_SIZE, 1);
        }
        
        /* run session attack detection */
        if (self::get(self::KEY_USER_AUTH) === true) {
            // Security::checkSessionInactivity();
            // Security::checkSessionFixation();
        }
    }

    /**
     * Get value in Session for given key.
     *
     * @param integer|string $key
     *            predefined constant Session::KEY_ (integer key); can be self defined string or integer constant (convention is integer grater than 1000)
     * @return NULL|mixed
     */
    public static function get($key) {
        if (!is_int($key) && !is_string($key)) {
            return null;
        }
        $site_fqdn = Config::get(Config::KEY_SITE_FQDN);
        return (array_key_exists($key, $_SESSION[$site_fqdn])) ? $_SESSION[$site_fqdn][$key] : null;
    }

    /**
     * Set Session value for given key.
     *
     * @param integer|string $key
     *            predefined constant Session::KEY_ (integer key); can be self defined string or integer constant (convention is integer grater than 1000)
     * @param mixed $value            
     * @return boolean
     */
    public static function set($key, $value) {
        if (!is_int($key) && !is_string($key)) {
            return false;
        }
        if (self::$registrationEnabled === true) {
            $_SESSION[Config::get(Config::KEY_SITE_FQDN)][$key] = $value;
            return true;
        }
        return false;
    }

    /**
     * Disable registration (modifications) of values in Session.
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
     * Start new session.
     */
    public static function start() {
        session_start();
        self::init();
    }

    /**
     * Close current session.
     */
    public static function close() {
        session_unset();
        session_destroy();
    }

    /**
     * Load default values for user keys.
     */
    private static function loadUserDefaults() {
        self::set(self::KEY_USER_UID, null);
        self::set(self::KEY_USER_GID, null);
        self::set(self::KEY_USER_AUTH, false);
        self::set(self::KEY_USER_TYPE, null);
        self::set(self::KEY_USER_LANG, null);
        self::set(self::KEY_USER_EMAIL, null);
        self::set(self::KEY_USER_FIRST_NAME, null);
        self::set(self::KEY_USER_LAST_NAME, null);
        self::set(self::KEY_USER_LAST_LOGIN, null);
    }
}
?>