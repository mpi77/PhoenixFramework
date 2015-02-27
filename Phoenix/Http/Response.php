<?php

namespace Phoenix\Http;

use \Exception;

/**
 * Root response object.
 *
 * @version 1.7
 * @author MPI
 *        
 */
abstract class Response {
    const DEFAULT_CONTENT_TYPE = "text/html";
    const DEFAULT_CHARSET = "utf-8";
    
    /**
     * HTTP 1.1 response code
     */
    const S100_CONTINUE = 100;
    const S101_SWITCHING_PROTOCOLS = 101;
    const S200_OK = 200;
    const S201_CREATED = 201;
    const S202_ACCEPTED = 202;
    const S203_NON_AUTHORITATIVE_INFORMATION = 203;
    const S204_NO_CONTENT = 204;
    const S205_RESET_CONTENT = 205;
    const S206_PARTIAL_CONTENT = 206;
    const S300_MULTIPLE_CHOICES = 300;
    const S301_MOVED_PERMANENTLY = 301;
    const S302_FOUND = 302;
    const S303_SEE_OTHER = 303;
    const S303_POST_GET = 303;
    const S304_NOT_MODIFIED = 304;
    const S305_USE_PROXY = 305;
    const S307_TEMPORARY_REDIRECT = 307;
    const S400_BAD_REQUEST = 400;
    const S401_UNAUTHORIZED = 401;
    const S402_PAYMENT_REQUIRED = 402;
    const S403_FORBIDDEN = 403;
    const S404_NOT_FOUND = 404;
    const S405_METHOD_NOT_ALLOWED = 405;
    const S406_NOT_ACCEPTABLE = 406;
    const S407_PROXY_AUTHENTICATION_REQUIRED = 407;
    const S408_REQUEST_TIMEOUT = 408;
    const S409_CONFLICT = 409;
    const S410_GONE = 410;
    const S411_LENGTH_REQUIRED = 411;
    const S412_PRECONDITION_FAILED = 412;
    const S413_REQUEST_ENTITY_TOO_LARGE = 413;
    const S414_REQUEST_URI_TOO_LONG = 414;
    const S415_UNSUPPORTED_MEDIA_TYPE = 415;
    const S416_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const S417_EXPECTATION_FAILED = 417;
    const S426_UPGRADE_REQUIRED = 426;
    const S500_INTERNAL_SERVER_ERROR = 500;
    const S501_NOT_IMPLEMENTED = 501;
    const S502_BAD_GATEWAY = 502;
    const S503_SERVICE_UNAVAILABLE = 503;
    const S504_GATEWAY_TIMEOUT = 504;
    const S505_HTTP_VERSION_NOT_SUPPORTED = 505;
    
    /**
     *
     * @var Exception
     */
    private $exception;
    
    /**
     *
     * @var string
     */
    private $header_content_type;
    
    /**
     *
     * @var string
     */
    private $header_charset;

    /**
     * Response constructor.
     *
     * @param string $content_type
     *            [optional] default null
     * @param string $charset
     *            [optional] default null
     * @param Exception $e
     *            [optional] default null
     */
    public function __construct($content_type = null, $charset = null, Exception $e = null) {
        $this->setHeader($content_type, $charset);
        $this->setException($e);
    }

    /**
     * Send this response object to output.
     *
     * @all responses must contain a send method
     */
    public abstract function send();

    /**
     * Get string representation of this response class.
     *
     * @all responses must contain a toString method
     */
    public abstract function __toString();

    /**
     * Get response exception.
     *
     * @return Exception
     */
    public final function getException() {
        return $this->exception;
    }

    /**
     * Set response exception.
     *
     * @param Exception $e            
     */
    public final function setException(Exception $e = null) {
        if (!is_null($e)) {
            $this->exception = $e;
        }
    }

    /**
     * Set response header.
     *
     * @param string $content_type            
     * @param string $charset            
     */
    public final function setHeader($content_type, $charset) {
        $this->header_content_type = $content_type;
        $this->header_charset = $charset;
    }

    /**
     * Send response header.
     */
    protected final function sendHeader() {
        if (empty($this->header_content_type) || empty($this->header_charset)) {
            $this->setHeader(self::DEFAULT_CONTENT_TYPE, self::DEFAULT_CHARSET);
        }
        header("Content-Type: " . $this->header_content_type . "; charset=" . $this->header_charset);
    }
}
?>
