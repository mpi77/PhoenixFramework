<?php

namespace Phoenix\Locale;

use \Phoenix\Utils;
use \App\AppTranslator;

/**
 * Translate is Translator singleton wrapper.
 *
 * @version 1.7
 * @author MPI
 *        
 */
class Translate {
    private static $translator = null;

    private function __construct() {
    }

    /**
     * Get string or string pattern from actual Translator.
     *
     * @param integer $key
     *            constant defined in AppTranslator
     * @return string
     */
    public static function get($key) {
        if (empty(self::$translator)) {
            self::initTranslator();
        }
        return self::$translator->get($key);
    }

    /**
     * Print htmlspecialchars(string) from actual Translator.
     *
     * @param integer $key
     *            constant defined in AppTranslator
     */
    public static function es($key) {
        if (empty(self::$translator)) {
            self::initTranslator();
        }
        echo htmlspecialchars(self::$translator->get($key));
    }

    /**
     * Print string from actual Translator.
     *
     * @param integer $key
     *            constant defined in AppTranslator
     */
    public static function e($key) {
        if (empty(self::$translator)) {
            self::initTranslator();
        }
        echo self::$translator->get($key);
    }

    /**
     * Reinitialize translator to new language.
     *
     * @param string $class_name
     *            may be fully namespaced class name or only end class name (yourClassName) in namespace \App\Locale\yourClassName
     */
    public static function changeLang($class_name) {
        self::initTranslator($class_name);
    }

    /**
     * Create new translator object.
     *
     * @todo validation of $class_name on fns or class
     * @todo load from session user lang
     *      
     * @param string $class_name
     *            may be fully namespaced class name or only end class name (yourClassName) in namespace \App\Locale\yourClassName
     */
    private static function initTranslator($class_name = null) {
        if (empty($class_name)) {
            // first load from session
            $class_name = AppTranslator::getDefaultTranslator();
        }
        self::$translator = new $class_name();
    }
}
?>