<?php

namespace Phoenix\Http;

use \Exception;
use \Phoenix\Http\HtmlResponse;
use \Phoenix\Http\JsonResponse;
use \Phoenix\Http\XmlResponse;

/**
 * Root response object.
 *
 * @version 1.6
 * @author MPI
 *        
 */
abstract class Response {
    const RESPONSE_UNKNOWN = 0;
    const RESPONSE_HTML = 1;
    const RESPONSE_JSON = 2;
    const RESPONSE_XML = 3;
    const CONTENT_TYPE_HTML = "text/html";
    const CONTENT_TYPE_JSON = "application/json";
    const CONTENT_TYPE_XML = "application/xml";
    const CHARSET_HTML = "utf-8";
    const CHARSET_JSON = "utf-8";
    const CHARSET_XML = "utf-8";
    private $exception;
    private $header_content_type;
    private $header_charset;

    /**
     * Response constructor.
     *
     * @param string $content_type            
     * @param string $charset            
     * @param Exception $e            
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
            $this->setHeader(self::CONTENT_TYPE_HTML, self::CHARSET_HTML);
        }
        header("Content-Type: " . $this->header_content_type . "; charset=" . $this->header_charset);
    }

    /**
     * Get new response object by given output format.
     *
     * @param integer $format
     *            constants from Response class with preffix RESPONSE_*
     *            
     * @return (Html+Json+Xml)Response
     */
    public static final function responseFactory($format) {
        switch ($format) {
            case self::RESPONSE_HTML :
                return new HtmlResponse();
                break;
            case self::RESPONSE_JSON :
                return new JsonResponse();
                break;
            case self::RESPONSE_XML :
                return new XmlResponse();
                break;
            default :
                return new HtmlResponse();
        }
    }

    /**
     * Is output fomat valid.
     *
     * @param integer $format
     *            constants from Response class with preffix RESPONSE_*
     *            
     * @return boolean
     */
    public static final function isValidResponseFormat($format) {
        if (!is_numeric($format)) {
            return false;
        }
        
        switch ($format) {
            case self::RESPONSE_HTML :
            case self::RESPONSE_JSON :
            case self::RESPONSE_XML :
                return true;
                break;
            default :
                return false;
        }
    }
}
?>
