<?php

namespace Phoenix\Exceptions;

use \Exception;
use \Phoenix\Core\Config;
use \Phoenix\Locale\Translate;

/**
 * BaseException for Phoenix framework.
 *
 * It is predecessor of all Exception
 * used in framework.
 *
 * @version 1.1
 * @author MPI
 */
abstract class BaseException extends Exception {
    
    /* SECTION: DUE TO USE LATE STATIC BINDING COPY THIS SECTION TO ALL CHILDREN OF THIS CLASS */
    protected static $registration_enabled = true;
    protected static $data = array ();
    /* ENDofSECTION */
    
    /**
     * FrameworkException constructor.
     *
     * @param integer $code
     *            [optional] default is 0
     * @param string $message
     *            [optional] default is null
     * @return void
     */
    public function __construct($code = 0, $message = null) {
        if (!is_int($code) || !array_key_exists($code, static::$data)) {
            $code = 0;
        }
        parent::__construct($message, $code);
    }

    /**
     * Get translation key for given exception key.
     *
     * @param integer $exception_code
     *            it is $code from Exception
     * @return integer|null
     */
    public static final function get($exception_code) {
        return (is_int($exception_code) && array_key_exists($exception_code, static::$data)) ? static::$data[$exception_code] : null;
    }

    /**
     * Get all registered pairs of translations (exception keys to translation keys).
     *
     * @return array
     */
    public static final function getAll() {
        return static::$data;
    }

    /**
     * Get translated message of exception.
     * 
     * @param integer $exception_key
     *            it is $code from Exception
     * @return string
     */
    public static final function getTranslatedMessage($exception_code) {
        return Translate::get(Config::get(Config::KEY_APP_EXCEPTION_MODULE_NAME), self::get($exception_code));
    }

    /**
     * Set translation key for given exception key.
     *
     * @param integer $exception_code
     *            it is $code from Exception
     * @param integer $translator_key            
     * @return boolean
     */
    public static final function set($exception_code, $translator_key) {
        if (!is_int($exception_code) || !is_int($translator_key)) {
            return false;
        }
        if (static::$registration_enabled === true) {
            if (empty(static::$data)) {
                static::$data = array ();
            }
            static::$data[$exception_code] = $translator_key;
            return true;
        }
        return false;
    }

    /**
     * Set array of pairs translation key for given exception key.
     *
     * @param array $array
     *            must have integer keys and values
     * @return boolean
     */
    public static final function setArray($array) {
        $k = array_unique(array_map("is_int", array_keys($array))) === array (
                        true 
        );
        $v = array_unique(array_map("is_int", array_values($array))) === array (
                        true 
        );
        if ($k === false || $v === false) {
            return false;
        }
        if (static::$registration_enabled === true) {
            static::$data = $array;
            return true;
        }
        return false;
    }

    /**
     * Disable registration (modifications) of values in *Exception.
     * 
     * @return void
     */
    public static final function disableRegistration() {
        static::$registration_enabled = false;
    }

    /**
     * Get bool of registration enabled.
     *
     * @return boolean
     */
    public static final function isRegistrationEnabled() {
        return static::$registration_enabled;
    }
}
?>