<?php

namespace Phoenix\Exceptions;

use \Phoenix\Exceptions\BaseException;

/**
 * FailureException is used to inform user that called action crashed.
 * This final state is CRITICAL for user because it means that app crashed
 * and it is impossible to make step back. This state is logged and redirected to
 * shutdown page, because it is impossible to continue with processing.
 * Typicaly thrown by unavailable database, etc.
 * While generating Response.send, the only allowed output is this exception.
 * Other output content is not allowed.
 *
 * @version 1.6
 * @author MPI
 *        
 */
class FailureException extends BaseException {
    /* SECTION: DUE TO USE LATE STATIC BINDING COPIED FROM PARENT CLASS */
    protected static $registration_enabled = true;
    protected static $data = array ();
    /* ENDofSECTION */
    
    /**
     * FailureException constructor.
     *
     * @param integer $code            
     * @param string $message            
     */
    public function __construct($code = 0, $message = null) {
        parent::__construct($message, $code);
    }

    public function __toString() {
        return "[F{$this->code}]: " . self::getTranslatedMessage($this->code) . "\n";
    }
}
?>