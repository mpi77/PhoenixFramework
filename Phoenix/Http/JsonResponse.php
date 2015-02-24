<?php

namespace Phoenix\Http;

use \Exception;
use \Phoenix\Http\Response;

/**
 * Json response object.
 *
 * @version 1.3
 * @author MPI
 *        
 */
final class JsonResponse extends Response {

    public function __construct(Exception $e = null) {
        parent::__construct(Response::CONTENT_TYPE_JSON, Response::CHARSET_JSON, $e);
    }

    /**
     * Send this response object to output.
     *
     * @todo
     *
     */
    public function send() {
        $this->sendHeader();
    }

    /**
     * Get string representation of this response class.
     *
     * @todo
     *
     */
    public function __toString() {
    }
}
?>
