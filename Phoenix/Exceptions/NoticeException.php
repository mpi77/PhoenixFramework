<?php

/**
 * NoticeException is used to inform user how called action finished.
 * This final state is only INFORMATIVE for user (show message) 
 * and it doesn't mean that app crashed while processing. Also this
 * state is not logged. Typicaly thrown by invalid user input, etc.
 * While generating Response.send, the output content (in html content 
 * div) is attached into response object with this exception.
 *
 * @version 1.5
 * @author MPI
 * */
class NoticeException extends Exception implements IAppException {
    const N_UNKNOWN = 0;
    const N_LOGIN_FAILED = 1;
    const N_INVALID_PARAMETERS = 2; 
    const N_PASSWORD_INVALID_FORMAT = 3;
    const N_INPUT_INVALID_FORMAT = 4;
    const N_SUCCESSFULLY_SAVED = 5;
    const N_RENEW_EMAIL_ERROR = 6;
    const N_RENEW_EMAIL_SENDED = 7;
    const N_PASSWORD_CHANGED = 8;
    const N_USER_CREATE_EMAIL_ERROR = 9;
    const N_EMAIL_USED_ENTER_ANOTHER = 10;
    const N_USER_CREATE_EMAIL_SENDED = 11;
    const N_USER_ACTIVATED = 12;
    const N_NOTHING_TO_DISPLAY = 13;
    const N_FILE_IS_NOT_DELETABLE = 14;
    private static $notice = array (
                    self::N_UNKNOWN => Translator::N_UNKNOWN,
                    self::N_LOGIN_FAILED => Translator::N_LOGIN_FAILED,
                    self::N_INVALID_PARAMETERS => Translator::N_INVALID_PARAMETERS,
                    self::N_PASSWORD_INVALID_FORMAT => Translator::N_PASSWORD_INVALID_FORMAT,
                    self::N_INPUT_INVALID_FORMAT => Translator::N_INPUT_INVALID_FORMAT,
                    self::N_SUCCESSFULLY_SAVED => Translator::N_SUCCESSFULLY_SAVED,
                    self::N_RENEW_EMAIL_ERROR => Translator::N_RENEW_EMAIL_ERROR,
                    self::N_RENEW_EMAIL_SENDED => Translator::N_RENEW_EMAIL_SENDED,
                    self::N_PASSWORD_CHANGED => Translator::N_PASSWORD_CHANGED,
                    self::N_USER_CREATE_EMAIL_ERROR => Translator::N_USER_CREATE_EMAIL_ERROR,
                    self::N_EMAIL_USED_ENTER_ANOTHER => Translator::N_EMAIL_USED_ENTER_ANOTHER,
                    self::N_USER_CREATE_EMAIL_SENDED => Translator::N_USER_CREATE_EMAIL_SENDED,
                    self::N_USER_ACTIVATED => Translator::N_USER_ACTIVATED,
                    self::N_NOTHING_TO_DISPLAY => Translator::N_NOTHING_TO_DISPLAY,
                    self::N_FILE_IS_NOT_DELETABLE => Translator::N_FILE_IS_NOT_DELETABLE 
    );

    public function __construct($code = 0, $message = null) {
        if (!array_key_exists($code, self::$notice)) {
            $code = 0;
        }
        parent::__construct($message, $code);
    }

    public function __toString() {
        return "[N{$this->code}]: " . self::getTranslatedMessage($this->code) . "\n";
    }

    /**
     * Get translated message of exception.
     *
     * @param integer $code            
     * @return string
     */
    public static function getTranslatedMessage($code) {
        return Translate::get(self::$notice[$code]);
    }
}
?>