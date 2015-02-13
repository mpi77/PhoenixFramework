<?php

namespace Phoenix\Core;

/**
 * Root configurator object.
 *
 * @version 1.0
 * @author MPI
 *        
 */
abstract class Configurator {

    /**
     * Configurator constructor.
     */
    public function __construct() {
    }
    
    /**
     * Run all required operations in Configurator to setup App.
     */
    public abstract function run();
    
    /**
     * Register App Configuration into Config object.
     */
    protected abstract function registerConfiguration();
    
    /**
     * Register Routes into Router object.
     */
    protected abstract function registerRoutes();

    /**
     * Register NoticeExceptions defined in App into NoticeException object.
     */
    protected abstract function registerNoticeExceptions();

    /**
     * Register WarningExceptions defined in App into WarningException object.
     */
    protected abstract function registerWarningExceptions();

    /**
     * Register FailureExceptions defined in App into FailureException object.
     */
    protected abstract function registerFailureExceptions();
    
}
?>
