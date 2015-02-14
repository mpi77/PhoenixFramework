<?php

namespace App\Locale;

use \Phoenix\Locale\Translator as T;
use \App\AppTranslator as AT;

/**
 * English translator.
 *
 * @version 1.9
 * @author MPI
 *        
 */
class EnglishTranslator extends AT {
    private static $info = array (
                    T::INFO_LANGUAGE_NAME => "english",
                    T::INFO_CLASS_NAME => __CLASS__ 
    );
    private $data = array (
                    AT::F_UNKNOWN => "Unknown failure.",
                    AT::F_MISSING_CONFIG_DB => "Empty config data for connect to db.",
                    AT::F_UNABLE_CONNECT_DB => "Unnable to connect to db server.",
                    AT::F_UNABLE_SET_DB_CHARSET => "Unable to set db charset.",
                    AT::F_UNABLE_SAVE_WARNING => "Unable to save warning to db.",
                    AT::W_UNKNOWN => "Unknown warning.",
                    AT::W_CLASS_NOT_FOUND => "Missing required class.",
                    AT::W_ACTION_IS_NOT_CALLABLE => "Requested action is not runnable.",
                    AT::W_INVALID_PARAMETERS => "Given attributes are not valid.",
                    AT::W_PERMISSION_DENIED => "Permission denied.",
                    AT::W_INVALID_TOKEN => "Invalid token.",
                    AT::W_DB_INVALID_SQL_SELECT => "Incorrect database (select) query.",
                    AT::W_DB_INVALID_SQL_ACTION => "Incorrect database (action) query.",
                    AT::W_DB_UNABLE_VERIFY_RESULT => "Unable to verify result.",
                    AT::W_DB_UNABLE_BEGIN_TRANSACTION => "Unable to begin transaction.",
                    AT::W_DB_UNABLE_COMMIT_TRANSACTION => "Unable to commit transaction.",
                    AT::W_DB_UNABLE_ROLLBACK_TRANSACTION => "Unable to rollback transaction.",
                    AT::W_ROUTER_INVALID_ROUTE => "Path is invalid.",
                    AT::W_ROUTER_INVALID_ROUTE_ACTION => "Action is invalid.",
                    AT::W_RESPONSE_INVALID_FORMAT => "Invalid response format.",
                    AT::W_RESPONSE_UNSUPPORTED_FORMAT => "Response format is not supported.",
                    AT::N_UNKNOWN => "Unknown notice." 
    );

    public function __construct() {
        parent::__construct();
    }

    public function get($key) {
        return (key_exists($key, $this->data)) ? $this->data[$key] : T::DEFAULT_VALUE;
    }

    public static function langInfo() {
        return self::$info;
    }
}
?>