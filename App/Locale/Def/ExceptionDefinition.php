<?php

namespace App\Locale\Def;

use \Phoenix\Locale\IModuleDefinition;

/**
 * Exception definition.
 *
 * @version 1.6
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
    const F_RESPONSE_HEADERS_SENT = 105;
    const F_RESPONSE_INVALID_HTTP_CODE = 106;
    const F_URL_PARSE_ERROR = 107;
    const F_ROUTE_MISSING_ARGS = 108;
    const F_CLASS_NOT_FOUND = 109;
    
    /* warning exceptions */
    const W_UNKNOWN = 200;
    const W_ACTION_IS_NOT_CALLABLE = 201;
    const W_INVALID_PARAMETERS = 202;
    const W_PERMISSION_DENIED = 203;
    const W_INVALID_TOKEN = 204;
    const W_DB_INVALID_SQL_SELECT = 240;
    const W_DB_INVALID_SQL_ACTION = 241;
    const W_DB_UNABLE_VERIFY_RESULT = 242;
    const W_DB_UNABLE_BEGIN_TRANSACTION = 243;
    const W_DB_UNABLE_COMMIT_TRANSACTION = 244;
    const W_DB_UNABLE_ROLLBACK_TRANSACTION = 245;
    const W_ROUTER_INVALID_ROUTE = 250;
    const W_ROUTER_INVALID_ROUTE_ACTION = 251;
    const W_RESPONSE_INVALID_FORMAT = 260;
    
    /* notice exceptions */
    const N_UNKNOWN = 500;

    /**
     * Get module name.
     *
     * @return string
     */
    public static function getModuleName() {
        return "Exception";
    }
}
?>