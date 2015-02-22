<?php

namespace App\Locale\Lang\En;

use \Phoenix\Locale\IModuleTranslator;
use \App\Locale\Def\FrameworkDefinition as FD;

/**
 * Framework translator.
 *
 * @version 1.1
 * @author MPI
 *        
 */
class FrameworkTranslator implements IModuleTranslator {
    
    /**
     * Maps def::constants to strings.
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