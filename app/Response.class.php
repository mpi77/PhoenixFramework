<?php

/**
 * Root response object.
 * 
 * @version 1.1
 * @author MPI
 * */
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
    private $headerContentType;
    private $headerCharset;

    public function __construct($contentType = null, $charset = null, Exception $e = null) {
        $this->setHeader($contentType, $charset);
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
     * Set response exception.
     *
     * @param Exception $e            
     */
    public function setException(Exception $e = null) {
        if (!is_null($e)) {
            $this->exception = $e;
        }
    }

    /**
     * Set response header.
     *
     * @param string $contentType            
     * @param string $charset            
     */
    public function setHeader($contentType, $charset) {
        $this->headerContentType = $contentType;
        $this->headerCharset = $charset;
    }

    /**
     * Send response header.
     */
    protected function sendHeader() {
        if (empty($this->headerContentType) || empty($this->headerCharset)) {
            $this->setHeader(self::CONTENT_TYPE_HTML, self::CHARSET_HTML);
        }
        header("Content-Type: " . $this->headerContentType . "; charset=" . $this->headerCharset);
    }
}
?>
