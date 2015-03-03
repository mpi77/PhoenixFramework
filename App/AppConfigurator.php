<?php

namespace App;

use \Phoenix\Core\Configurator;
use \Phoenix\Core\Config;
use \Phoenix\Exceptions\NoticeException;
use \Phoenix\Exceptions\WarningException;
use \Phoenix\Exceptions\FailureException;
use \Phoenix\Exceptions\FrameworkExceptions as FX;
use \Phoenix\Routers\RouterFactory;
use \App\Locale\Def\ExceptionDefinition as ED;

/**
 * Application configurator.
 *
 * @version 1.11
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
     * @return void
     */
    public final function disableRegistrations() {
        Config::disableRegistration();
        NoticeException::disableRegistration();
        WarningException::disableRegistration();
        FailureException::disableRegistration();
    }

    /**
     * Register App Configuration into Config object.
     *
     * @return void
     */
    protected final function registerConfiguration() {
        Config::set(Config::KEY_SITE_FQDN, "http://localhost/phoenix/www");
        Config::set(Config::KEY_SITE_BASE, "/phoenix/");
        Config::set(Config::KEY_FORCE_HTTPS, false);
        Config::set(Config::KEY_APP_EXCEPTION_MODULE_NAME, ED::getModuleName());
        Config::set(Config::KEY_APP_USE_ROUTER, RouterFactory::SIMPLE_ROUTER);
        Config::setDatabasePool(Config::get(Config::KEY_DB_PRIMARY_POOL), "mysql", "localhost", "3306", "phoenix", "phoenix", "phoenix", "utf8");
    }

    /**
     * Register Routes into Router object.
     *
     * @todo
     *
     * @return void
     */
    protected final function registerRoutes() {
    }

    /**
     * Register NoticeExceptions defined in App (in this file) into NoticeException object.
     */
    protected final function registerNoticeExceptions() {
        NoticeException::setArray(array (
                        FX::N_UNKNOWN => ED::N_UNKNOWN 
        ));
    }

    /**
     * Register WarningExceptions defined in App (in this file) into WarningException object.
     *
     * @return void
     */
    protected final function registerWarningExceptions() {
        WarningException::setArray(array (
                        FX::W_UNKNOWN => ED::W_UNKNOWN,
                        FX::W_CLASS_NOT_FOUND => ED::W_CLASS_NOT_FOUND,
                        FX::W_ACTION_IS_NOT_CALLABLE => ED::W_ACTION_IS_NOT_CALLABLE,
                        FX::W_INVALID_PARAMETERS => ED::W_INVALID_PARAMETERS,
                        FX::W_PERMISSION_DENIED => ED::W_PERMISSION_DENIED,
                        FX::W_INVALID_TOKEN => ED::W_INVALID_TOKEN,
                        FX::W_DB_INVALID_SQL_SELECT => ED::W_DB_INVALID_SQL_SELECT,
                        FX::W_DB_INVALID_SQL_ACTION => ED::W_DB_INVALID_SQL_ACTION,
                        FX::W_DB_UNABLE_VERIFY_RESULT => ED::W_DB_UNABLE_VERIFY_RESULT,
                        FX::W_DB_UNABLE_BEGIN_TRANSACTION => ED::W_DB_UNABLE_BEGIN_TRANSACTION,
                        FX::W_DB_UNABLE_COMMIT_TRANSACTION => ED::W_DB_UNABLE_COMMIT_TRANSACTION,
                        FX::W_DB_UNABLE_ROLLBACK_TRANSACTION => ED::W_DB_UNABLE_ROLLBACK_TRANSACTION,
                        FX::W_ROUTER_INVALID_ROUTE => ED::W_ROUTER_INVALID_ROUTE,
                        FX::W_ROUTER_INVALID_ROUTE_ACTION => ED::W_ROUTER_INVALID_ROUTE_ACTION,
                        FX::W_RESPONSE_INVALID_FORMAT => ED::W_RESPONSE_INVALID_FORMAT 
        ));
    }

    /**
     * Register FailureExceptions defined in App (in this file) into FailureException object.
     *
     * @return void
     */
    protected final function registerFailureExceptions() {
        FailureException::setArray(array (
                        FX::F_UNKNOWN => ED::F_UNKNOWN,
                        FX::F_MISSING_CONFIG_DB => ED::F_MISSING_CONFIG_DB,
                        FX::F_UNABLE_CONNECT_DB => ED::F_UNABLE_CONNECT_DB,
                        FX::F_UNABLE_SAVE_WARNING => ED::F_UNABLE_SAVE_WARNING,
                        FX::F_UNABLE_SET_DB_CHARSET => ED::F_UNABLE_SET_DB_CHARSET,
                        FX::F_RESPONSE_HEADERS_SENT => ED::F_RESPONSE_HEADERS_SENT,
                        FX::F_RESPONSE_INVALID_HTTP_CODE => ED::F_RESPONSE_INVALID_HTTP_CODE,
                        FX::F_URL_PARSE_ERROR => ED::F_URL_PARSE_ERROR,
                        FX::F_ROUTE_MISSING_ARGS => ED::F_ROUTE_MISSING_ARGS 
        ));
    }
}
?>