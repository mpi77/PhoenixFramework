<?php

namespace App\Locale\Lang\En;

use \Phoenix\Locale\IModuleTranslator;
use \App\Locale\Def\ExceptionDefinition as ED;

/**
 * Exception translator.
 *
 * @version 1.5
 * @author MPI
 *        
 */
class ExceptionTranslator implements IModuleTranslator {
    
    /**
     * Maps def::constants to strings.
     *
     * @var array
     */
    private static $data = array (
                    ED::F_UNKNOWN => "Unknown failure.",
                    ED::F_MISSING_CONFIG_DB => "Empty config data for connect to db.",
                    ED::F_UNABLE_CONNECT_DB => "Unnable to connect to db server.",
                    ED::F_UNABLE_SET_DB_CHARSET => "Unable to set db charset.",
                    ED::F_UNABLE_SAVE_WARNING => "Unable to save warning to db.",
                    ED::F_RESPONSE_HEADERS_SENT => "Unable to send headers.",
                    ED::F_RESPONSE_INVALID_HTTP_CODE => "Unable to set http status code.",
                    ED::F_URL_PARSE_ERROR => "Unable to parse url.",
                    ED::F_ROUTE_MISSING_ARGS => "Unable to create route in the router.",
                    ED::W_UNKNOWN => "Unknown warning.",
                    ED::W_CLASS_NOT_FOUND => "Missing required class.",
                    ED::W_ACTION_IS_NOT_CALLABLE => "Requested action is not runnable.",
                    ED::W_INVALID_PARAMETERS => "Given attributes are not valid.",
                    ED::W_PERMISSION_DENIED => "Permission denied.",
                    ED::W_INVALID_TOKEN => "Invalid token.",
                    ED::W_DB_INVALID_SQL_SELECT => "Incorrect database (select) query.",
                    ED::W_DB_INVALID_SQL_ACTION => "Incorrect database (action) query.",
                    ED::W_DB_UNABLE_VERIFY_RESULT => "Unable to verify result.",
                    ED::W_DB_UNABLE_BEGIN_TRANSACTION => "Unable to begin transaction.",
                    ED::W_DB_UNABLE_COMMIT_TRANSACTION => "Unable to commit transaction.",
                    ED::W_DB_UNABLE_ROLLBACK_TRANSACTION => "Unable to rollback transaction.",
                    ED::W_ROUTER_INVALID_ROUTE => "Path is invalid.",
                    ED::W_ROUTER_INVALID_ROUTE_ACTION => "Action is invalid.",
                    ED::W_RESPONSE_INVALID_FORMAT => "Invalid response format.",
                    ED::N_UNKNOWN => "Unknown notice." 
    );

    /**
     * ExceptionTranslator constructor.
     */
    private function __construct() {
    }

    /**
     * Get translated message for given key.
     *
     * @param integer $key            
     * @return string
     */
    public static function get($key) {
        return (is_int($key) && key_exists($key, self::$data)) ? self::$data[$key] : IModuleTranslator::DEFAULT_VALUE;
    }
}
?>