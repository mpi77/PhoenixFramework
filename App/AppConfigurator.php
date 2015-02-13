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
 * @version 1.1
 * @author MPI
 *        
 */
class AppConfigurator extends Configurator {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Run all required operations in AppConfigurator to setup App.
     */
    public final function run() {
        $this->registerConfiguration();
        $this->registerRoutes();
        $this->registerNoticeExceptions();
        $this->registerWarningExceptions();
        $this->registerFailureExceptions();
    }

    /**
     * Register Routes into Router object.
     */
    protected final function registerRoutes() {
    }

    /**
     * Register App Configuration into Config object.
     */
    protected final function registerConfiguration() {
        Config::set(Config::KEY_SITE_FQDN, "http://localhost/phoenix/www");
        Config::set(Config::KEY_SITE_BASE, "/phoenix/");
        Config::setDatabasePool(Config::get(Config::KEY_DB_PRIMARY_POOL), "mysql", "localhost", "3306", "phoenix", "phoenix", "phoenix", "utf8");
        Config::disableRegistration();
    }

    /**
     * Register NoticeExceptions defined in App into NoticeException object.
     */
    protected final function registerNoticeExceptions() {
        NoticeException::setArray(array (
                        FX::N_UNKNOWN => 1 
        ));
        NoticeException::disableRegistration();
    }

    /**
     * Register WarningExceptions defined in App into WarningException object.
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
        WarningException::disableRegistration();
    }

    /**
     * Register FailureExceptions defined in App into FailureException object.
     */
    protected final function registerFailureExceptions() {
        FailureException::setArray(array (
                        FX::F_UNKNOWN => 1,
                        FX::F_MISSING_CONFIG_DB => 2,
                        FX::F_UNABLE_CONNECT_DB => 3,
                        FX::F_UNABLE_SAVE_WARNING => 4,
                        FX::F_UNABLE_SET_DB_CHARSET => 5 
        ));
        FailureException::disableRegistration();
    }
}
?>