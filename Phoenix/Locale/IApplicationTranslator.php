<?php

namespace Phoenix\Locale;

/**
 * Application translator interface.
 *
 * @version 1.1
 * @author MPI
 */
interface IApplicationTranslator {

    /**
     * Get all available languages in App.
     *
     * @return array
     */
    public static function getAvailableLanguages();

    /**
     * Get default language fully namespaced class name.
     * This language is defaultly used when user do not select any language.
     *
     * @return string
     */
    public static function getDefaultLanguage();
}
?>
