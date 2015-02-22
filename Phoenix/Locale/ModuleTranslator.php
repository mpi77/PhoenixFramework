<?php

namespace Phoenix\Locale;

/**
 * Root module translator object.
 *
 * @version 1.0
 * @author MPI
 */
abstract class ModuleTranslator {
    const DEFAULT_VALUE = "";

    /**
     * Module translator constructor.
     */
    public function __construct() {
    }

    /**
     * Get translated message for given key.
     *
     * @abstract
     *
     * @param integer $key            
     * @return string
     */
    public abstract function get($key);
}
?>
