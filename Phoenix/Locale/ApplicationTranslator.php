<?php

namespace Phoenix\Locale;

/**
 * Root application translator object.
 *
 * @version 1.0
 * @author MPI
 */
abstract class ApplicationTranslator {

    /**
     * Application translator constructor.
     */
    private function __construct() {
    }
    
    /**
     * Get all available languages in App.
     *
     * @abstract
     *
     * @return array
     */
    public abstract static function getAvailableLanguages();

    /**
     * Get default language fully namespaced class name.
     * This language is defaultly used when user do not select any language.
     *
     * @abstract
     *
     * @return string
     */
    public abstract static function getDefaultLanguage();
}
?>
