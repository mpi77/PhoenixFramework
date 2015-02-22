<?php

namespace App\Locale\En;

use \Phoenix\Locale\IModuleTranslator;

/**
 * Framework translator.
 *
 * @version 1.0
 * @author MPI
 *        
 */
class FrameworkTranslator implements IModuleTranslator {
    
    /**
     * Maps self::constants to strings.
     *
     * @var array
     */
    private static $data = array ();

    /**
     * FrameworkTranslator constructor.
     */
    private function __construct() {
    }

    /**
     * Get translated message for given key.
     *
     * @param integer $key            
     * @return string
     */
    public static function get($key) {
        return (is_int($key) && key_exists($key, self::$data)) ? self::$data[$key] : IModuleTranslator::DEFAULT_VALUE;
    }
}
?>