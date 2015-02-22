<?php

namespace App\Locale\Def;

use \Phoenix\Locale\IModuleDefinition;

/**
 * Exception definition.
 *
 * @version 1.0
 * @author MPI
 *        
 */
class ExceptionDefinition implements IModuleDefinition {
    
    /* failure exceptions */
    const F_UNKNOWN = 100;
    const F_MISSING_CONFIG_DB = 101;
    const F_UNABLE_CONNECT_DB = 102;
    const F_UNABLE_SET_DB_CHARSET = 103;
    const F_UNABLE_SAVE_WARNING = 104;
    
    /* warning exceptions */
    const W_UNKNOWN = 200;
    const W_CLASS_NOT_FOUND = 201;
    const W_ACTION_IS_NOT_CALLABLE = 202;
    const W_INVALID_PARAMETERS = 203;
    const W_PERMISSION_DENIED = 204;
    const W_INVALID_TOKEN = 205;
    const W_DB_INVALID_SQL_SELECT = 240;
    const W_DB_INVALID_SQL_ACTION = 241;
    const W_DB_UNABLE_VERIFY_RESULT = 242;
    const W_DB_UNABLE_BEGIN_TRANSACTION = 243;
    const W_DB_UNABLE_COMMIT_TRANSACTION = 244;
    const W_DB_UNABLE_ROLLBACK_TRANSACTION = 245;
    const W_ROUTER_INVALID_ROUTE = 250;
    const W_ROUTER_INVALID_ROUTE_ACTION = 251;
    const W_RESPONSE_INVALID_FORMAT = 260;
    const W_RESPONSE_UNSUPPORTED_FORMAT = 261;
    
    /* notice exceptions */
    const N_UNKNOWN = 500;
}
?>