<?php

namespace Phoenix\Exceptions;

/**
 * Phoenix framework defined Exceptions.
 *
 * For these exception constants must be explicitely
 * defined translation relationship with Translator 
 * in AppConfigurator. It is convention that exceptions 
 * defined at this place should be an integer greater 
 * than 0 and lower than 1000. Self defined exceptions 
 * in AppConfigurator should be an integer greater 
 * than 1000.
 *
 * @version 1.8
 * @author MPI
 *        
 */
class FrameworkExceptions {
    /* notice exceptions */
    const N_UNKNOWN = 0;
    
    /* warning exceptions */
    const W_UNKNOWN = 0;
    const W_ACTION_IS_NOT_CALLABLE = 1;
    const W_INVALID_PARAMETERS = 2;
    const W_PERMISSION_DENIED = 3;
    const W_INVALID_TOKEN = 4;
    const W_DB_INVALID_SQL_SELECT = 40;
    const W_DB_INVALID_SQL_ACTION = 41;
    const W_DB_UNABLE_VERIFY_RESULT = 42;
    const W_DB_UNABLE_BEGIN_TRANSACTION = 43;
    const W_DB_UNABLE_COMMIT_TRANSACTION = 44;
    const W_DB_UNABLE_ROLLBACK_TRANSACTION = 45;
    const W_ROUTER_INVALID_ROUTE = 50;
    const W_ROUTER_INVALID_ROUTE_ACTION = 51;
    const W_RESPONSE_INVALID_FORMAT = 60;
    
    
    /* failure exceptions */
    const F_UNKNOWN = 0;
    const F_CLASS_NOT_FOUND = 1;
    const F_DB_MISSING_CONFIG = 10;
    const F_DB_UNABLE_CONNECT = 11;
    const F_DB_UNABLE_SET_CHARSET = 12;
    const F_LOGGER_UNABLE_SAVE_WARNING = 13;
    const F_RESPONSE_HEADERS_SENT = 14;
    const F_RESPONSE_INVALID_HTTP_CODE = 15;
    const F_REQUEST_FORCED_HTTPS = 16;
    const F_URL_PARSE_ERROR = 17;
    const F_ROUTE_MISSING_ARGS = 18;
}
?>