<?php

namespace App;

use \Phoenix\Core\Configurator;
use \Phoenix\Core\Config;
use \Phoenix\Exceptions\NoticeException;
use \Phoenix\Exceptions\WarningException;
use \Phoenix\Exceptions\FailureException;
use \Phoenix\Exceptions\FrameworkExceptions as FX;
use \App\AppTranslator as AT;

/**
 * Application configurator.
 *
 * @version 1.3
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
                        FX::N_UNKNOWN => AT::N_UNKNOWN 
        ));
    }

    /**
     * Register WarningExceptions defined in App (in this file) into WarningException object.
     */
    protected final function registerWarningExceptions() {
        WarningException::setArray(array (
                        FX::W_UNKNOWN => AT::W_UNKNOWN,
                        FX::W_CLASS_NOT_FOUND => AT::W_CLASS_NOT_FOUND,
                        FX::W_ACTION_IS_NOT_CALLABLE => AT::W_ACTION_IS_NOT_CALLABLE,
                        FX::W_INVALID_PARAMETERS => AT::W_INVALID_PARAMETERS,
                        FX::W_PERMISSION_DENIED => AT::W_PERMISSION_DENIED,
                        FX::W_INVALID_TOKEN => AT::W_INVALID_TOKEN,
                        FX::W_DB_INVALID_SQL_SELECT => AT::W_DB_INVALID_SQL_SELECT,
                        FX::W_DB_INVALID_SQL_ACTION => AT::W_DB_INVALID_SQL_ACTION,
                        FX::W_DB_UNABLE_VERIFY_RESULT => AT::W_DB_UNABLE_VERIFY_RESULT,
                        FX::W_DB_UNABLE_BEGIN_TRANSACTION => AT::W_DB_UNABLE_BEGIN_TRANSACTION,
                        FX::W_DB_UNABLE_COMMIT_TRANSACTION => AT::W_DB_UNABLE_COMMIT_TRANSACTION,
                        FX::W_DB_UNABLE_ROLLBACK_TRANSACTION => AT::W_DB_UNABLE_ROLLBACK_TRANSACTION,
                        FX::W_ROUTER_INVALID_ROUTE => AT::W_ROUTER_INVALID_ROUTE,
                        FX::W_ROUTER_INVALID_ROUTE_ACTION => AT::W_ROUTER_INVALID_ROUTE_ACTION,
                        FX::W_RESPONSE_INVALID_FORMAT => AT::W_RESPONSE_INVALID_FORMAT,
                        FX::W_RESPONSE_UNSUPPORTED_FORMAT => AT::W_RESPONSE_UNSUPPORTED_FORMAT 
        ));
    }

    /**
     * Register FailureExceptions defined in App (in this file) into FailureException object.
     */
    protected final function registerFailureExceptions() {
        FailureException::setArray(array (
                        FX::F_UNKNOWN => AT::F_UNKNOWN,
                        FX::F_MISSING_CONFIG_DB => AT::F_MISSING_CONFIG_DB,
                        FX::F_UNABLE_CONNECT_DB => AT::F_UNABLE_CONNECT_DB,
                        FX::F_UNABLE_SAVE_WARNING => AT::F_UNABLE_SAVE_WARNING,
                        FX::F_UNABLE_SET_DB_CHARSET => AT::F_UNABLE_SET_DB_CHARSET 
        ));
    }
}
?>