<?php

namespace Phoenix\Locale;

/**
 * Module translator interface.
 *
 * @version 1.2
 * @author MPI
 */
interface IModuleTranslator {
    const DEFAULT_VALUE = "";

    /**
     * Get translated message for given key.
     *
     * @param integer $key            
     * @return string
     */
    public static function get($key);
}
?>