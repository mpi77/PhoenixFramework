<?php

/**
 * WarningException is used to inform user that called action crashed
 * due to internal program error or with state incompatible with correct 
 * proccess. This final state is CRITICAL for user because it means that 
 * some program function crashed, but whole program may process ahead. 
 * It is possible to make step back, but this state is logged. In normal 
 * running program, this type of exception should not be thrown. Typicaly 
 * thrown by incorect SQL query, bad ACL, etc. 
 * While generating Response.send, the only allowed output is this exception.
 * Other output content is not allowed.
 * 
 * @version 1.4
 * @author MPI
 * */
class WarningException extends Exception implements IAppException {
    const WARNING_UNKNOWN = 0;
    const WARNING_CLASS_NOT_FOUND = 1;
    const WARNING_ACTION_IS_NOT_CALLABLE = 2;
    const WARNING_INVALID_ROUTE = 3;
    const WARNING_INVALID_SQL_SELECT = 4;
    const WARNING_INVALID_SQL_ACTION = 5;
    const WARNING_UNABLE_VERIFY_RESULT = 6;
    const WARNING_UNABLE_COMPLETE_TRANSACTION = 7;
    const WARNING_ROUTER_ROUTE_INVALID = 8;
    const WARNING_ROUTER_ROUTE_ACTION_INVALID = 9;
    private static $error = array (
                    self::WARNING_UNKNOWN => Translator::WARNING_UNKNOWN,
                    self::WARNING_CLASS_NOT_FOUND => Translator::WARNING_CLASS_NOT_FOUND,
                    self::WARNING_ACTION_IS_NOT_CALLABLE => Translator::WARNING_ACTION_IS_NOT_CALLABLE,
                    self::WARNING_INVALID_ROUTE => Translator::WARNING_INVALID_ROUTE,
                    self::WARNING_INVALID_SQL_SELECT => Translator::WARNING_INVALID_SQL_SELECT,
                    self::WARNING_INVALID_SQL_ACTION => Translator::WARNING_INVALID_SQL_ACTION,
                    self::WARNING_UNABLE_VERIFY_RESULT => Translator::WARNING_UNABLE_VERIFY_RESULT,
                    self::WARNING_UNABLE_COMPLETE_TRANSACTION => Translator::WARNING_UNABLE_COMPLETE_TRANSACTION,
                    self::WARNING_ROUTER_ROUTE_INVALID => Translator::WARNING_ROUTER_ROUTE_INVALID,
                    self::WARNING_ROUTER_ROUTE_ACTION_INVALID => Translator::WARNING_ROUTER_ROUTE_ACTION_INVALID 
    );

    public function __construct($code = 0, $message = null) {
        if (!array_key_exists($code, self::$error)) {
            $code = 0;
        }
        parent::__construct($message, $code);
    }

    public function __toString() {
        return "[W{$this->code}]: " . self::getTranslatedMessage($this->code) . "\n";
    }

    /**
     * Get translated message of exception.
     *
     * @param integer $code            
     * @return string
     */
    public static function getTranslatedMessage($code) {
        return Translate::get(self::$error[$code]);
    }
}
?>