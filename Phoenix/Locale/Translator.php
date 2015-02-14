<?php

namespace Phoenix\Locale;

/**
 * Root translator object.
 *
 * @version 1.9
 * @author MPI
 */
abstract class Translator {
    const DEFAULT_VALUE = "";
    const INFO_LANGUAGE_NAME = 1;
    const INFO_CLASS_NAME = 2;

    public function __construct() {
    }

    public abstract function get($key);

    public abstract static function langInfo();

    public abstract static function getAvailableLanguages();

    public abstract static function getCurrentLanguage();
}
?>
