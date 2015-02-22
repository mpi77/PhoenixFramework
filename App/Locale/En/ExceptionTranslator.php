<?php

namespace App\Locale\En;

use \Phoenix\Locale\IModuleTranslator;

/**
 * Exception translator.
 *
 * @version 1.0
 * @author MPI
 *        
 */
class ExceptionTranslator implements IModuleTranslator {
    
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
    
    /**
     * Maps self::constants to strings.
     *
     * @var array
     */
    private static $data = array (
                    self::F_UNKNOWN => "Unknown failure.",
                    self::F_MISSING_CONFIG_DB => "Empty config data for connect to db.",
                    self::F_UNABLE_CONNECT_DB => "Unnable to connect to db server.",
                    self::F_UNABLE_SET_DB_CHARSET => "Unable to set db charset.",
                    self::F_UNABLE_SAVE_WARNING => "Unable to save warning to db.",
                    self::W_UNKNOWN => "Unknown warning.",
                    self::W_CLASS_NOT_FOUND => "Missing required class.",
                    self::W_ACTION_IS_NOT_CALLABLE => "Requested action is not runnable.",
                    self::W_INVALID_PARAMETERS => "Given attributes are not valid.",
                    self::W_PERMISSION_DENIED => "Permission denied.",
                    self::W_INVALID_TOKEN => "Invalid token.",
                    self::W_DB_INVALID_SQL_SELECT => "Incorrect database (select) query.",
                    self::W_DB_INVALID_SQL_ACTION => "Incorrect database (action) query.",
                    self::W_DB_UNABLE_VERIFY_RESULT => "Unable to verify result.",
                    self::W_DB_UNABLE_BEGIN_TRANSACTION => "Unable to begin transaction.",
                    self::W_DB_UNABLE_COMMIT_TRANSACTION => "Unable to commit transaction.",
                    self::W_DB_UNABLE_ROLLBACK_TRANSACTION => "Unable to rollback transaction.",
                    self::W_ROUTER_INVALID_ROUTE => "Path is invalid.",
                    self::W_ROUTER_INVALID_ROUTE_ACTION => "Action is invalid.",
                    self::W_RESPONSE_INVALID_FORMAT => "Invalid response format.",
                    self::W_RESPONSE_UNSUPPORTED_FORMAT => "Response format is not supported.",
                    self::N_UNKNOWN => "Unknown notice." 
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