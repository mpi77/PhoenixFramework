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
 * @version 1.7
 * @author MPI
 * */
class WarningException extends Exception implements IAppException {
    const W_UNKNOWN = 0;
    const W_CLASS_NOT_FOUND = 1;
    const W_ACTION_IS_NOT_CALLABLE = 2;
    const W_INVALID_ROUTE = 3;
    const W_INVALID_SQL_SELECT = 4;
    const W_INVALID_SQL_ACTION = 5;
    const W_UNABLE_VERIFY_RESULT = 6;
    const W_UNABLE_COMPLETE_TRANSACTION = 7;
    const W_ROUTER_ROUTE_INVALID = 8;
    const W_ROUTER_ROUTE_ACTION_INVALID = 9;
    const W_INVALID_PARAMETERS = 10; 
    const W_PERMISSION_DENIED = 11;
    const W_LOGIN_REQUIRED = 12;
    const W_INVALID_TOKEN = 13;
    const W_USER_NOT_FOUND = 14;
    const W_RESPONSE_INVALID_FORMAT = 15;
    const W_RESPONSE_UNSUPPORTED_FORMAT = 16;
    private static $error = array (
                    self::W_UNKNOWN => Translator::W_UNKNOWN,
                    self::W_CLASS_NOT_FOUND => Translator::W_CLASS_NOT_FOUND,
                    self::W_ACTION_IS_NOT_CALLABLE => Translator::W_ACTION_IS_NOT_CALLABLE,
                    self::W_INVALID_ROUTE => Translator::W_INVALID_ROUTE,
                    self::W_INVALID_SQL_SELECT => Translator::W_INVALID_SQL_SELECT,
                    self::W_INVALID_SQL_ACTION => Translator::W_INVALID_SQL_ACTION,
                    self::W_UNABLE_VERIFY_RESULT => Translator::W_UNABLE_VERIFY_RESULT,
                    self::W_UNABLE_COMPLETE_TRANSACTION => Translator::W_UNABLE_COMPLETE_TRANSACTION,
                    self::W_ROUTER_ROUTE_INVALID => Translator::W_ROUTER_ROUTE_INVALID,
                    self::W_ROUTER_ROUTE_ACTION_INVALID => Translator::W_ROUTER_ROUTE_ACTION_INVALID,
                    self::W_INVALID_PARAMETERS => Translator::W_INVALID_PARAMETERS,
                    self::W_PERMISSION_DENIED => Translator::W_PERMISSION_DENIED,
                    self::W_LOGIN_REQUIRED => Translator::W_LOGIN_REQUIRED,
                    self::W_INVALID_TOKEN => Translator::W_INVALID_TOKEN,
                    self::W_USER_NOT_FOUND => Translator::W_USER_NOT_FOUND,
                    self::W_RESPONSE_INVALID_FORMAT => Translator::W_RESPONSE_INVALID_FORMAT,
                    self::W_RESPONSE_UNSUPPORTED_FORMAT => Translator::W_RESPONSE_UNSUPPORTED_FORMAT
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