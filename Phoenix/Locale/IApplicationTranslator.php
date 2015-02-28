<?php

namespace Phoenix\Locale;

/**
 * Application translator interface.
 *
 * @version 1.3
 * @author MPI
 */
interface IApplicationTranslator {
    const LANG_NAME = 1;
    const LANG_PREFIX = 2;

    /**
     * Get all available languages in App.
     *
     * @return array
     */
    public static function getAvailableLanguages();

    /**
     * Get default language.
     * This language is defaultly used when user do not select any language.
     *
     * @return array
     */
    public static function getDefaultLanguage();
}
?>