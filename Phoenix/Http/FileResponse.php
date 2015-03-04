<?php

namespace Phoenix\Http;

use \Phoenix\Exceptions\BaseException;
use \Phoenix\Http\Response;

/**
 * File response object.
 *
 * @version 1.0
 * @author MPI
 *        
 */
final class FileResponse extends Response {
    const CONTENT_TYPE_FILE = "text/plain";
    const CHARSET_FILE = "utf-8";

    /**
     * FileResponse constructor.
     *
     * @param Phoenix\Exceptions\BaseException $e
     *            [optional] default null
     */
    public function __construct(BaseException $e = null) {
        parent::__construct(Response::S200_OK, self::CONTENT_TYPE_FILE, self::CHARSET_FILE, $e);
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
        return sprintf("FileResponse{}");
    }
}
?>