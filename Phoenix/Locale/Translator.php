<?php

namespace Phoenix\Locale;

/**
 * Root translator object.
 *
 * @version 1.10
 * @author MPI
 */
abstract class Translator {
    const DEFAULT_VALUE = "";
    const INFO_LANGUAGE_NAME = 1;
    const INFO_CLASS_NAME = 2;

    /**
     * Translator constructor.
     */
    public function __construct() {
    }

    /**
     * Get translated message for given key.
     *
     * @abstract
     *
     * @param integer $key            
     */
    public abstract function get($key);

    /**
     * Get language info.
     *
     * @abstract
     *
     */
    public abstract static function langInfo();

    /**
     * Get all available languages in App.
     *
     * @abstract
     *
     */
    public abstract static function getAvailableLanguages();

    /**
     * Get current language.
     *
     * @abstract
     *
     */
    public abstract static function getCurrentLanguage();
}
?>
