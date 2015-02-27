<?php

namespace Phoenix\Http;

use \Exception;
use \Phoenix\Http\Response;

/**
 * Json response object.
 *
 * @version 1.4
 * @author MPI
 *        
 */
final class JsonResponse extends Response {
    const CONTENT_TYPE_JSON = "application/json";
    const CHARSET_JSON = "utf-8";

    /**
     * JsonResponse constructor.
     *
     * @param Exception $e
     *            [optional] default null
     */
    public function __construct(Exception $e = null) {
        parent::__construct(self::CONTENT_TYPE_JSON, self::CHARSET_JSON, $e);
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
