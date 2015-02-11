<?php

/**
 * FailureException is used to inform user that called action crashed.
 * This final state is CRITICAL for user because it means that app crashed 
 * and it is impossible to make step back. This state is logged and redirected to 
 * shutdown page, because it is impossible to continue with processing.
 * Typicaly thrown by unavailable database, etc.
 * While generating Response.send, the only allowed output is this exception.
 * Other output content is not allowed.
 *
 * @version 1.5
 * @author MPI
 * */
class FailureException extends Exception implements IAppException {
    const F_UNKNOWN = 0;
    const F_MISSING_CONFIG_DB = 1;
    const F_UNABLE_CONNECT_DB = 2;
    const F_UNABLE_SET_DB_CHARSET = 3;
    const F_UNABLE_SAVE_WARNING = 4;
    private static $error = array (
                    self::F_UNKNOWN => Translator::F_UNKNOWN,
                    self::F_MISSING_CONFIG_DB => Translator::F_MISSING_CONFIG_DB,
                    self::F_UNABLE_CONNECT_DB => Translator::F_UNABLE_CONNECT_DB,
                    self::F_UNABLE_SET_DB_CHARSET => Translator::F_UNABLE_SET_DB_CHARSET,
                    self::F_UNABLE_SAVE_WARNING => Translator::F_UNABLE_SAVE_WARNING 
    );

    public function __construct($code = 0, $message = null) {
        if (!array_key_exists($code, self::$error)) {
            $code = 0;
        }
        parent::__construct($message, $code);
    }

    public function __toString() {
        return "[F{$this->code}]: " . self::getTranslatedMessage($this->code) . "\n";
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