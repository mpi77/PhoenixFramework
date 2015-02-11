<?php

/**
 * Xml response object.
 * 
 * @version 1.1
 * @author MPI
 * */
final class XmlResponse extends Response {

    public function __construct(Exception $e = null) {
        parent::__construct(Response::CONTENT_TYPE_XML, Response::CHARSET_XML, $e);
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
