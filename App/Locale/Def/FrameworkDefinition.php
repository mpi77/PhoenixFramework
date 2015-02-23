<?php

namespace App\Locale\Def;

use \Phoenix\Locale\IModuleDefinition;

/**
 * Framework definition.
 *
 * @version 1.1
 * @author MPI
 *        
 */
class FrameworkDefinition implements IModuleDefinition {

    /**
     * Get module name.
     *
     * @return string
     */
    public static function getModuleName() {
        return "Framework";
    }
}
?>