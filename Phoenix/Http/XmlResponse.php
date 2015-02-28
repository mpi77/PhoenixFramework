<?php

namespace Phoenix\Http;

use \Phoenix\Exceptions\BaseException;
use \Phoenix\Http\Response;

/**
 * Xml response object.
 *
 * @version 1.5
 * @author MPI
 *        
 */
final class XmlResponse extends Response {
    const CONTENT_TYPE_XML = "application/xml";
    const CHARSET_XML = "utf-8";

    /**
     * XmlResponse constructor.
     *
     * @param Phoenix\Exceptions\BaseException $e
     *            [optional] default null
     */
    public function __construct(BaseException $e = null) {
        parent::__construct(Response::S200_OK, self::CONTENT_TYPE_XML, self::CHARSET_XML, $e);
    }

    /**
     * Send this response object to output.
     *
     * @todo
     *
     */
    public function send() {
    }

    /**
     * Get string representation of this response class.
     *
     * @return string
     *
     */
    public function __toString() {
        return sprintf("XmlResponse{}");
    }
}
?>