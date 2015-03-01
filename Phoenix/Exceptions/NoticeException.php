<?php

namespace Phoenix\Exceptions;

use \Phoenix\Exceptions\BaseException;

/**
 * NoticeException is used to inform user how called action finished.
 * This final state is only INFORMATIVE for user (show message)
 * and it doesn't mean that app crashed while processing. Also this
 * state is not logged. Typicaly thrown by invalid user input, etc.
 * While generating Response.send, the output content (in html content
 * div) is attached into response object with this exception.
 *
 * @version 1.8
 * @author MPI
 *        
 */
class NoticeException extends BaseException {
    /* SECTION: DUE TO USE LATE STATIC BINDING COPIED FROM PARENT CLASS */
    protected static $registration_enabled = true;
    protected static $data = array ();
    /* ENDofSECTION */
    
    /**
     * NoticeException constructor.
     *
     * @param integer $code
     *            [optional] default is 0
     * @param string $message
     *            [optional] default is null
     * @return void
     */
    public function __construct($code = 0, $message = null) {
        parent::__construct($code, $message);
    }

    public function __toString() {
        return "[N{$this->code}]: " . self::getTranslatedMessage($this->code) . "\n";
    }
}
?>