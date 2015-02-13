<?php

namespace Phoenix\Exceptions;

use \Phoenix\Exceptions\BaseException;

/**
 * WarningException is used to inform user that called action crashed
 * due to internal program error or with state incompatible with correct
 * proccess.
 * This final state is CRITICAL for user because it means that
 * some program function crashed, but whole program may process ahead.
 * It is possible to make step back, but this state is logged. In normal
 * running program, this type of exception should not be thrown. Typicaly
 * thrown by incorect SQL query, bad ACL, etc.
 * While generating Response.send, the only allowed output is this exception.
 * Other output content is not allowed.
 *
 * @version 1.9
 * @author MPI
 *        
 */
class WarningException extends BaseException {
    /* SECTION: DUE TO USE LATE STATIC BINDING COPIED FROM PARENT CLASS */
    protected static $registration_enabled = true;
    protected static $data = array ();
    /* ENDofSECTION */
    
    /**
     * WarningException constructor.
     * 
     * @param integer $code            
     * @param string $message            
     */
    public function __construct($code = 0, $message = null) {
        parent::__construct($code, $message);
    }

    public function __toString() {
        return "[W{$this->code}]: " . self::getTranslatedMessage($this->code) . "\n";
    }
}
?>