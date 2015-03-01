<?php

namespace Phoenix\Core;

/**
 * Root configurator object.
 *
 * @version 1.3
 * @author MPI
 *        
 */
abstract class Configurator {

    /**
     * Configurator constructor.
     *
     * @return void
     */
    public function __construct() {
    }

    /**
     * Run all required operations in Configurator to setup App.
     * 
     * @return void
     */
    public function run() {
        $this->registerConfiguration();
        $this->registerRoutes();
        $this->registerNoticeExceptions();
        $this->registerWarningExceptions();
        $this->registerFailureExceptions();
        $this->disableRegistrations();
    }

    /**
     * Disable registration in all required objects (Config, Router,
     * Notice+Warning+Failure Exceptions).
     * Will be executed after all
     * register methods in this class.
     * 
     * @return void
     */
    protected abstract function disableRegistrations();

    /**
     * Register App Configuration into Config object.
     * 
     * @return void
     */
    protected abstract function registerConfiguration();

    /**
     * Register Routes into Router object.
     * 
     * @return void
     */
    protected abstract function registerRoutes();

    /**
     * Register NoticeExceptions defined in App into NoticeException object.
     * 
     * @return void
     */
    protected abstract function registerNoticeExceptions();

    /**
     * Register WarningExceptions defined in App into WarningException object.
     * 
     * @return void
     */
    protected abstract function registerWarningExceptions();

    /**
     * Register FailureExceptions defined in App into FailureException object.
     * 
     * @return void
     */
    protected abstract function registerFailureExceptions();
}
?>