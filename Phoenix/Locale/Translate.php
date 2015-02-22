<?php

namespace Phoenix\Locale;

use \Phoenix\Utils;
use \Phoenix\Locale\IApplicationTranslator;
use \App\AppTranslator;

/**
 * Translate is wrapper for ModuleTranslators.
 *
 * @version 1.8
 * @author MPI
 *        
 */
class Translate {

    private function __construct() {
    }

    /**
     * Get string or string pattern from ModuleTranslator.
     *
     * @param string $translator_module            
     * @param integer $key
     *            constant defined in \App\Locale\Def\ModuleDefinition
     * @param string $language        
     *     
     * @return string
     */
    public static function get($translator_module, $key, $language = null) {
        if (empty($language)) {
            $language = AppTranslator::getDefaultLanguage()[IApplicationTranslator::LANG_PREFIX];
        }
        $t = "\App\Locale\Lang\\" . $language . "\\" . $translator_module . "Translator";
        return $t::get($key);
    }

    /**
     * Print htmlspecialchars(string) from ModuleTranslator.
     *
     * @param integer $key
     *            constant defined in AppTranslator
     */
    public static function es($translator_module, $key, $language = null) {
        echo htmlspecialchars(self::get($translator_module, $key, $language));
    }

    /**
     * Print string from actual Translator.
     *
     * @param integer $key
     *            constant defined in AppTranslator
     */
    public static function e($translator_module, $key, $language = null) {
        echo self::get($translator_module, $key, $language);
    }
}
?>