<?php

namespace Phoenix\Locale;

use \Phoenix\Utils;
use \Phoenix\Locale\IApplicationTranslator;
use \App\AppTranslator;

/**
 * Translate is wrapper for ModuleTranslators.
 *
 * @version 1.9
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
     *            call \App\Locale\Def\ModuleDefinition::getModuleName()
     * @param integer $key
     *            constant defined in \App\Locale\Def\ModuleDefinition
     * @param string $language
     *            language prefix defined as IApplicationTranslator::LANG_PREFIX index in AppTranslator::$languages[i]; if is null then default language is selected
     *            
     * @return string
     */
    public static function get($translator_module, $key, $language = null) {
        if (empty($translator_module)) {
            return IModuleTranslator::DEFAULT_VALUE;
        }
        if (empty($language)) {
            $language = AppTranslator::getDefaultLanguage()[IApplicationTranslator::LANG_PREFIX];
        }
        $t = "\App\Locale\Lang\\" . $language . "\\" . $translator_module . "Translator";
        return (class_exists($t)) ? $t::get($key) : IModuleTranslator::DEFAULT_VALUE;
    }

    /**
     * Print htmlspecialchars(string) from ModuleTranslator.
     *
     * @param string $translator_module
     *            call \App\Locale\Def\ModuleDefinition::getModuleName()
     * @param integer $key
     *            constant defined in \App\Locale\Def\ModuleDefinition
     * @param string $language
     *            language prefix defined as IApplicationTranslator::LANG_PREFIX index in AppTranslator::$languages[i]; if is null then default language is selected
     */
    public static function es($translator_module, $key, $language = null) {
        echo htmlspecialchars(self::get($translator_module, $key, $language));
    }

    /**
     * Print string from actual Translator.
     *
     * @param string $translator_module
     *            call \App\Locale\Def\ModuleDefinition::getModuleName()
     * @param integer $key
     *            constant defined in \App\Locale\Def\ModuleDefinition
     * @param string $language
     *            language prefix defined as IApplicationTranslator::LANG_PREFIX index in AppTranslator::$languages[i]; if is null then default language is selected
     */
    public static function e($translator_module, $key, $language = null) {
        echo self::get($translator_module, $key, $language);
    }
}
?>