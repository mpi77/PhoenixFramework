<?php

namespace App;

use \Phoenix\Locale\IApplicationTranslator;
use \Phoenix\Utils\System;

/**
 * App translator.
 *
 * @version 1.5
 * @author MPI
 */
class AppTranslator implements IApplicationTranslator {

    /**
     * AppTranslator constructor.
     */
    private function __construct() {
    }

    /**
     * Get all available languages in App.
     *
     * @todo
     *
     * @return array 
     */
    public static final function getAvailableLanguages() {
        return null;
    }
    
    /**
     * Get default language fully namespaced class name.
     * This language is defaultly used when user do not select any language.
     *
     * @todo
     *
     * @return string
     */
    public static final function getDefaultLanguage(){
        return "En";
    }
}
?>