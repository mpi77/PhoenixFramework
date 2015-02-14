<?php

namespace App;

use \Phoenix\Core\Configurator;
use \Phoenix\Core\Config;
use \Phoenix\Exceptions\NoticeException;
use \Phoenix\Exceptions\WarningException;
use \Phoenix\Exceptions\FailureException;
use \Phoenix\Exceptions\FrameworkExceptions as FX;

/**
 * Application configurator.
 *
 * @version 1.2
 * @author MPI
 *        
 */
class AppConfigurator extends Configurator {
    
    /* at this place can be user defined constants for exceptions */
    
    /**
     * App constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Disable registration in all required objects (Config, Router,
     * Notice+Warning+Failure Exceptions).
     * Will be executed after all register methods in this class.
     *
     * @todo disable router
     */
    public final function disableRegistrations() {
        Config::disableRegistration();
        NoticeException::disableRegistration();
        WarningException::disableRegistration();
        FailureException::disableRegistration();
    }

    /**
     * Register App Configuration into Config object.
     */
    protected final function registerConfiguration() {
        Config::set(Config::KEY_SITE_FQDN, "http://localhost/phoenix/www");
        Config::set(Config::KEY_SITE_BASE, "/phoenix/");
        Config::setDatabasePool(Config::get(Config::KEY_DB_PRIMARY_POOL), "mysql", "localhost", "3306", "phoenix", "phoenix", "phoenix", "utf8");
    }

    /**
     * Register Routes into Router object.
     */
    protected final function registerRoutes() {
    }

    /**
     * Register NoticeExceptions defined in App (in this file) into NoticeException object.
     */
    protected final function registerNoticeExceptions() {
        NoticeException::setArray(array (
                        FX::N_UNKNOWN => 1 
        ));
    }

    /**
     * Register WarningExceptions defined in App (in this file) into WarningException object.
     */
    protected final function registerWarningExceptions() {
        WarningException::setArray(array (
                        FX::W_UNKNOWN => 1,
                        FX::W_CLASS_NOT_FOUND => 1,
                        FX::W_ACTION_IS_NOT_CALLABLE => 1,
                        FX::W_INVALID_PARAMETERS => 1,
                        FX::W_PERMISSION_DENIED => 1,
                        FX::W_INVALID_TOKEN => 1,
                        FX::W_DB_INVALID_SQL_SELECT => 1,
                        FX::W_DB_INVALID_SQL_ACTION => 1,
                        FX::W_DB_UNABLE_VERIFY_RESULT => 1,
                        FX::W_DB_UNABLE_BEGIN_TRANSACTION => 1,
                        FX::W_DB_UNABLE_COMMIT_TRANSACTION => 1,
                        FX::W_DB_UNABLE_ROLLBACK_TRANSACTION => 1,
                        FX::W_ROUTER_INVALID_ROUTE => 1,
                        FX::W_ROUTER_INVALID_ROUTE_ACTION => 1,
                        FX::W_RESPONSE_INVALID_FORMAT => 1,
                        FX::W_RESPONSE_UNSUPPORTED_FORMAT => 1 
        ));
    }

    /**
     * Register FailureExceptions defined in App (in this file) into FailureException object.
     */
    protected final function registerFailureExceptions() {
        FailureException::setArray(array (
                        FX::F_UNKNOWN => 1,
                        FX::F_MISSING_CONFIG_DB => 2,
                        FX::F_UNABLE_CONNECT_DB => 3,
                        FX::F_UNABLE_SAVE_WARNING => 4,
                        FX::F_UNABLE_SET_DB_CHARSET => 5 
        ));
    }
}
?>