<?php

namespace App\Locale\Def;

use \Phoenix\Locale\IModuleDefinition;

/**
 * Exception definition.
 *
 * @version 1.10
 * @author MPI
 *        
 */
class ExceptionDefinition implements IModuleDefinition {
    
    /* failure exceptions */
    const F_UNKNOWN = 100;
    const F_CLASS_NOT_FOUND = 101;
    const F_DB_MISSING_CONFIG = 110;
    const F_DB_UNABLE_CONNECT = 111;
    const F_DB_UNABLE_SET_CHARSET = 112;
    const F_LOGGER_UNABLE_SAVE_WARNING = 113;
    const F_RESPONSE_HEADERS_SENT = 114;
    const F_RESPONSE_INVALID_HTTP_CODE = 115;
    const F_REQUEST_FORCED_HTTPS = 116;
    const F_REQUEST_INVALID_METHOD = 117;
    const F_URL_PARSE_ERROR = 118;
    const F_ROUTE_MISSING_ARGS = 119;
    
    /* warning exceptions */
    const W_UNKNOWN = 200;
    const W_FUNCTION_IS_NOT_CALLABLE = 201;
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
    const W_ROUTER_INVALID_ACTION = 251;
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