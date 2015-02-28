<?php

namespace Phoenix\Http;

use \Phoenix\Exceptions\BaseException;
use \Phoenix\Http\Response;

/**
 * Json response object.
 *
 * @version 1.5
 * @author MPI
 *        
 */
final class JsonResponse extends Response {
    const CONTENT_TYPE_JSON = "application/json";
    const CHARSET_JSON = "utf-8";

    /**
     * JsonResponse constructor.
     *
     * @param Phoenix\Exceptions\BaseException $e
     *            [optional] default null
     */
    public function __construct(BaseException $e = null) {
        parent::__construct(Response::S200_OK, self::CONTENT_TYPE_JSON, self::CHARSET_JSON, $e);
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
     */
    public function __toString() {
        return sprintf("JsonResponse{}");
    }
}
?>