<?php

namespace Phoenix\Http;

use \Exception;
use \Phoenix\Http\Response;

/**
 * Xml response object.
 *
 * @version 1.4
 * @author MPI
 *        
 */
final class XmlResponse extends Response {
    const CONTENT_TYPE_XML = "application/xml";
    const CHARSET_XML = "utf-8";

    /**
     * XmlResponse constructor.
     *
     * @param Exception $e
     *            [optional] default null
     */
    public function __construct(Exception $e = null) {
        parent::__construct(self::CONTENT_TYPE_XML, self::CHARSET_XML, $e);
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
