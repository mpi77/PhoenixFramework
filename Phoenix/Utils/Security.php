<?php

/**
 * Security
 * 
 * @version 1.2
 * @author MPI
 * */
class Security {

    private function __construct() {
    }

    private function __destruct() {
    }

    /**
     * Check session inactivity timeout.
     * This method should be called after succesfull login.
     */
    public static function checkSessionInactivity() {
        if (Config::SESSION_INACTIVITY_ENABLED !== true) {
            return;
        }
        
        if (!isset($_SESSION[Config::SERVER_FQDN]["last_activity"])) {
            $_SESSION[Config::SERVER_FQDN]["last_activity"] = time();
        } else {
            if (time() - $_SESSION[Config::SERVER_FQDN]["last_activity"] > Config::SESSION_INACTIVITY_TIMEOUT) {
                session_unset();
                session_destroy();
                System::redirect(Config::SITE_PATH . Config::SESSION_INACTIVITY_REDIRECT_PATH);
            } else {
                $_SESSION[Config::SERVER_FQDN]["last_activity"] = time();
            }
        }
    }

    /**
     * Session fixation detection.
     * This method should be called after succesfull login.
     */
    public static function checkSessionFixation() {
        if (Config::SESSION_FIXATION_DETECTION_ENABLED !== true) {
            return;
        }
        
        if (!isset($_SESSION[Config::SERVER_FQDN]["remote_addr"]) || !isset($_SESSION[Config::SERVER_FQDN]["http_user_agent"])) {
            $_SESSION[Config::SERVER_FQDN]["remote_addr"] = $_SERVER["REMOTE_ADDR"];
            $_SESSION[Config::SERVER_FQDN]["http_user_agent"] = $_SERVER["HTTP_USER_AGENT"];
        } else {
            if ($_SESSION[Config::SERVER_FQDN]["remote_addr"] !== $_SERVER["REMOTE_ADDR"] || $_SESSION[Config::SERVER_FQDN]["http_user_agent"] !== $_SERVER["HTTP_USER_AGENT"]) {
                session_unset();
                session_destroy();
                System::redirect(Config::SITE_PATH . Config::SESSION_FIXATION_REDIRECT_PATH);
            }
        }
    }

    /**
     * Initialize auth_token in session.
     */
    public static function initAuthToken() {
        $_SESSION[Config::SERVER_FQDN]["user"]["auth_token"] = System::generateRandomCode(32);
        $_SESSION[Config::SERVER_FQDN]["user"]["auth_cnt"] = 1;
    }

    /**
     * Update aut_token and auth_counter.
     */
    public static function updateAuthToken() {
        if ($_SESSION[Config::SERVER_FQDN]["user"]["auth_cnt"] >= 1) {
            self::initAuthToken();
        } else {
            ++$_SESSION[Config::SERVER_FQDN]["user"]["auth_cnt"];
        }
    }

    /**
     * Detection of csrf attack.
     *
     * @param string $auth_token            
     * @return boolean
     */
    public static function isCsrfAttack($auth_token) {
        return (isset($_SESSION[Config::SERVER_FQDN]["user"]["auth_token"]) && $auth_token != $_SESSION[Config::SERVER_FQDN]["user"]["auth_token"]);
    }

    /**
     * Print auth_token hidden input.
     */
    public static function printAuthInput() {
        echo sprintf("<input type=\"hidden\" name=\"auth_token\" value=\"%s\">", htmlspecialchars($_SESSION[Config::SERVER_FQDN]["user"]["auth_token"]));
    }
}
?>