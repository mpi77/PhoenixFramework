<?php

/**
 * Json response object.
 * 
 * @version 1.0
 * @author MPI
 * */
final class JsonResponse extends Response {

    public function __construct(Exception $e = null) {
        parent::__construct(Response::CONTENT_TYPE_HTML, Response::CHARSET_HTML, $e);
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