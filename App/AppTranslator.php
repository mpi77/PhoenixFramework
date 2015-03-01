<?php

namespace App;

use \Phoenix\Locale\IApplicationTranslator;

/**
 * App translator.
 *
 * @version 1.7
 * @author MPI
 */
class AppTranslator implements IApplicationTranslator {
    const DEFAULT_LANGUAGE_INDEX = 0;
    private static $languages = array (
                    0 => array (
                                    IApplicationTranslator::LANG_NAME => "čeština",
                                    IApplicationTranslator::LANG_PREFIX => "Cz" 
                    ),
                    1 => array (
                                    IApplicationTranslator::LANG_NAME => "english",
                                    IApplicationTranslator::LANG_PREFIX => "En" 
                    ) 
    );

    /**
     * AppTranslator constructor.
     */
    private function __construct() {
    }

    /**
     * Get all available languages in App.
     *
     * @return array (2D array; each sub-array has keys IApplicationTranslator::LANG_*)
     */
    public static final function getAvailableLanguages() {
        return self::$languages;
    }

    /**
     * Get default language.
     * This language is defaultly used when user do not select any language.
     *
     * @return array (1D array has keys IApplicationTranslator::LANG_*)
     */
    public static final function getDefaultLanguage() {
        return self::$languages[self::DEFAULT_LANGUAGE_INDEX];
    }
}
?>