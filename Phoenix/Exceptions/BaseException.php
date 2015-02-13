<?php

namespace Phoenix\Exceptions;

use \Exception;

/**
 * BaseException for Phoenix framework.
 *
 * It is predecessor of all Exception
 * used in framework.
 *
 * @version 1.0
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
     * @param string $message            
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
     * @param integer $exception_key
     *            it is $code from Exception
     * @return integer|null
     */
    public static function get($exception_key) {
        return (is_int($exception_key) && array_key_exists($exception_key, static::$data)) ? static::$data[$exception_key] : null;
    }

    /**
     * Get all registered pairs of translations (exception keys to translation keys).
     *
     * @return array
     */
    public static function getAll() {
        return static::$data;
    }

    /**
     * Get translated message of exception.
     *
     * @todo : Translate message
     * @param integer $exception_key
     *            it is $code from Exception
     * @return string
     */
    public static function getTranslatedMessage($exception_key) {
        // return Translate::get(static::$data[$exception_key]);
        return "Translated " . $exception_key . " -> " . self::get($exception_key);
    }

    /**
     * Set translation key for given exception key.
     *
     * @param integer $exception_key
     *            it is $code from Exception
     * @param integer $translator_key            
     * @return boolean
     */
    public static function set($exception_key, $translator_key) {
        if (!is_int($exception_key) || !is_int($translator_key)) {
            return false;
        }
        if (static::$registration_enabled === true) {
            if (empty(static::$data)) {
                static::$data = array ();
            }
            static::$data[$exception_key] = $translator_key;
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
    public static function setArray($array) {
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
     */
    public static function disableRegistration() {
        static::$registration_enabled = false;
    }

    /**
     * Get bool of registration enabled.
     *
     * @return boolean
     */
    public static function isRegistrationEnabled() {
        return static::$registration_enabled;
    }
}
?>