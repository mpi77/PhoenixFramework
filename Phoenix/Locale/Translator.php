<?php

namespace Phoenix\Locale;

/**
 * Root translator object.
 *
 * @version 1.12
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
     * This method needs to be implemented in App\Locale\CustomTranslator.
     *
     * @abstract
     *
     * @param integer $key            
     * @return string
     */
    public abstract function get($key);

    /**
     * Get current instance language info.
     * This method is instance variant of static::langInfo() for current language.
     * This method needs to be implemented in App\AppTranslator.
     *
     * @abstract
     *
     * @return array (with keys Translator::INFO_*)
     */
    public abstract function getLangInfo();

    /**
     * Get static language info.
     * This method needs to be implemented in App\Locale\CustomTranslator.
     *
     * @abstract
     *
     * @return array (with keys Translator::INFO_*)
     */
    public abstract static function langInfo();

    /**
     * Get all available languages in App.
     * This method needs to be implemented in App\AppTranslator.
     *
     * @abstract
     *
     * @return array (2D array; each sub-array has keys Translator::INFO_*)
     */
    public abstract static function getAvailableLanguages();

    /**
     * Get default Translator fully namespaced class name.
     * This Translator is defaultly used when user do not select any Translator.
     * This method needs to be implemented in App\AppTranslator.
     *
     * @abstract
     *
     * @return string
     */
    public abstract static function getDefaultTranslator();
}
?>
