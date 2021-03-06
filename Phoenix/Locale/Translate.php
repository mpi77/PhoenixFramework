<?php

namespace Phoenix\Locale;

use \Phoenix\Locale\IApplicationTranslator;
use \App\AppTranslator;

/**
 * Translate is wrapper for ModuleTranslators.
 *
 * @version 1.12
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
     *            call \App\Locale\Def\*Module*Definition::getModuleName()
     * @param integer $key
     *            constant defined in \App\Locale\Def\*Module*Definition
     * @param string $language
     *            [optional] language prefix defined as IApplicationTranslator::LANG_PREFIX index in AppTranslator::$languages[i]; if is null then default language is selected
     *            
     * @return string
     */
    public static function get($translator_module, $key, $language = null) {
        if (empty($translator_module)) {
            return IModuleTranslator::DEFAULT_VALUE;
        }
        if (empty($language)) {
            $language = AppTranslator::getDefaultLanguage()[IApplicationTranslator::LANG_PREFIX];
            if (empty($language)) {
                return IModuleTranslator::DEFAULT_VALUE;
            }
        }
        $t = "\App\Locale\Lang\\" . $language . "\\" . $translator_module . "Translator";
        return (class_exists($t)) ? $t::get($key) : IModuleTranslator::DEFAULT_VALUE;
    }

    /**
     * Print htmlspecialchars(string, ENT_HTML5, UTF-8) from ModuleTranslator.
     *
     * @param string $translator_module
     *            call \App\Locale\Def\*Module*Definition::getModuleName()
     * @param integer $key
     *            constant defined in \App\Locale\Def\*Module*Definition
     * @param string $language
     *            [optional] language prefix defined as IApplicationTranslator::LANG_PREFIX index in AppTranslator::$languages[i]; if is null then default language is selected
     * @return void
     */
    public static function es($translator_module, $key, $language = null) {
        echo htmlspecialchars(self::get($translator_module, $key, $language), ENT_HTML5, "UTF-8");
    }

    /**
     * Print string from ModuleTranslator.
     *
     * @param string $translator_module
     *            call \App\Locale\Def\*Module*Definition::getModuleName()
     * @param integer $key
     *            constant defined in \App\Locale\Def\*Module*Definition
     * @param string $language
     *            [optional] language prefix defined as IApplicationTranslator::LANG_PREFIX index in AppTranslator::$languages[i]; if is null then default language is selected
     * @return void
     */
    public static function e($translator_module, $key, $language = null) {
        echo self::get($translator_module, $key, $language);
    }
}
?>