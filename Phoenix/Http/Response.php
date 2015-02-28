<?php

namespace Phoenix\Http;

use \Phoenix\Utils\DateTime;
use \Phoenix\Exceptions\BaseException;
use \Phoenix\Exceptions\FailureException;
use \Phoenix\Exceptions\FrameworkExceptions;

/**
 * Root response object.
 *
 * @version 1.9
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
     * @var Phoenix\Exceptions\BaseException
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
     *
     * @var integer
     */
    private $code;
    
    /**
     *
     * @var string The domain in which the cookie will be available
     */
    public $cookie_domain = "";
    
    /**
     *
     * @var string The path in which the cookie will be available
     */
    public $cookie_path = "/";
    
    /**
     *
     * @var string Whether the cookie is available only through HTTPS
     */
    public $cookie_secure = false;
    
    /**
     *
     * @var string Whether the cookie is hidden from client-side
     */
    public $cookie_http_only = true;
    
    /**
     *
     * @var bool Whether warn on possible problem with data in output buffer
     */
    public $warn_on_buffer = true;

    /**
     * Response constructor.
     *
     * @param integer $code
     *            [optional] HTTP/1.1 status code, default Response::S200_OK
     * @param string $content_type
     *            [optional] default Response::DEFAULT_CONTENT_TYPE
     * @param string $charset
     *            [optional] [optional] default Response::DEFAULT_CHARSET
     * @param Phoenix\Exceptions\BaseException $e
     *            [optional] default null
     */
    public function __construct($code = null, $content_type = null, $charset = null, BaseException $e = null) {
        $this->setException($e);
        $this->setCode(empty($code) ? self::S200_OK : $code);
        $this->setContentType($content_type, $charset);
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
     * @return Phoenix\Exceptions\BaseException
     */
    public final function getException() {
        return $this->exception;
    }

    /**
     * Set response exception.
     *
     * @param Phoenix\Exceptions\BaseException $e
     *            [optional] default null
     */
    public final function setException(BaseException $e = null) {
        $this->exception = $e;
    }

    /**
     * Set HTTP response code.
     *
     * @throws Phoenix\Exceptions\FailureException if HTTP headers have been sent or invalid http status code
     *        
     * @param integer $code
     *            HTTP/1.1 status code
     * @return void
     */
    public final function setCode($code) {
        $code = (int) $code;
        if ($code < 100 || $code > 599) {
            throw new FailureException(FrameworkExceptions::F_RESPONSE_INVALID_HTTP_CODE);
        }
        $this->checkHeaders();
        $this->code = $code;
        $protocol = isset($_SERVER["SERVER_PROTOCOL"]) ? $_SERVER["SERVER_PROTOCOL"] : "HTTP/1.1";
        header($protocol . " " . $code, true, $code);
        return;
    }

    /**
     * Get HTTP response code.
     *
     * @return integer
     */
    public final function getCode() {
        return $this->code;
    }

    /**
     * Sends a HTTP header and replaces a previous one.
     *
     * @throws Phoenix\Exceptions\FailureException if HTTP headers have been sent
     * @param string $name
     *            header name
     * @param string $value
     *            header value
     * @return void
     */
    public final function setHeader($name, $value) {
        $this->checkHeaders();
        if ($value === null) {
            header_remove($name);
        } elseif (strcasecmp($name, "Content-Length") === 0 && ini_get("zlib.output_compression")) {
            // ignore, PHP bug #44164
        } else {
            header($name . ": " . $value, true, $this->code);
        }
        return;
    }

    /**
     * Adds HTTP header.
     * This function does NOT overwrite any header.
     *
     * @throws Phoenix\Exceptions\FailureException if HTTP headers have been sent
     * @param string $name
     *            header name
     * @param string $value
     *            header value
     * @return void
     */
    public final function addHeader($name, $value) {
        $this->checkHeaders();
        header($name . ": " . $value, false, $this->code);
        return;
    }

    /**
     * Sends a Content-type HTTP header.
     *
     * @throws Phoenix\Exceptions\FailureException if HTTP headers have been sent
     * @param string $type
     *            [optional] default Response::DEFAULT_CONTENT_TYPE
     * @param string $charset
     *            [optional] default Response::DEFAULT_CHARSET
     * @return void
     */
    public final function setContentType($type = null, $charset = null) {
        $this->header_content_type = $type;
        $this->header_charset = $charset;
        if (empty($this->header_content_type) || empty($this->header_charset)) {
            $this->header_content_type = self::DEFAULT_CONTENT_TYPE;
            $this->header_charset = self::DEFAULT_CHARSET;
        }
        $this->setHeader("Content-Type", $this->header_content_type . "; charset=" . $this->header_charset);
        return;
    }

    /**
     * Sets the number of seconds before a page cached on a browser expires.
     *
     * @throws Phoenix\Exceptions\FailureException if HTTP headers have been sent
     * @param string|int|\DateTime $time
     *            [optional] default null means no cache, otherwise it is cache time; supported format here http://php.net/manual/en/datetime.formats.php
     * @return void
     */
    public final function setExpiration($time = null) {
        if (empty($time)) { // no cache
            $this->setHeader("Cache-Control", "s-maxage=0, max-age=0, must-revalidate");
            $this->setHeader("Expires", "Tue, 1 Jan 1991 00:00:00 GMT");
            return;
        }
        $time = DateTime::from($time);
        $this->setHeader("Cache-Control", "max-age=" . ($time->format("U") - time()));
        $this->setHeader("Expires", DateTime::formatHttpDate($time));
        return;
    }

    /**
     * Checks if headers have been sent.
     *
     * @return bool
     */
    public final function isSent() {
        return headers_sent();
    }

    /**
     * Get value of an HTTP header.
     *
     * @param string $header
     *            name of the header
     * @param mixed $default
     *            [optional] default null
     * @return mixed
     */
    public final function getHeader($header, $default = null) {
        $header .= ":";
        $len = strlen($header);
        foreach (headers_list() as $item) {
            if (strncasecmp($item, $header, $len) === 0) {
                return ltrim(substr($item, $len));
            }
        }
        return $default;
    }

    /**
     * Get list of headers to sent.
     *
     * @return array (name => value)
     */
    public final function getHeaders() {
        $headers = array ();
        foreach (headers_list() as $header) {
            $a = strpos($header, ":");
            $headers[substr($header, 0, $a)] = (string) substr($header, $a + 2);
        }
        return $headers;
    }

    /**
     * Send cookie.
     *
     * @throws Phoenix\Exceptions\FailureException if HTTP headers have been sent
     * @param string $name
     *            name of the cookie
     * @param string $value
     *            value of the cookie
     * @param string|int|\DateTime $time
     *            expiration time, value 0 means until the browser is closed; supported format here http://php.net/manual/en/datetime.formats.php
     * @param string $path
     *            [optional] default null
     * @param string $domain
     *            [optional] default null
     * @param bool $secure
     *            [optional] default null
     * @param bool $http_only
     *            [optional] default null
     * @return void
     */
    public final function setCookie($name, $value, $time, $path = null, $domain = null, $secure = null, $http_only = null) {
        $this->checkHeaders();
        setcookie($name, $value, $time ? DateTime::from($time)->format("U") : 0, $path === null ? $this->cookie_path : (string) $path, $domain === null ? $this->cookie_domain : (string) $domain, $secure === null ? $this->cookie_secure : (bool) $secure, $http_only === null ? $this->cookie_http_only : (bool) $http_only);
        $this->removeDuplicateCookies();
        return;
    }

    /**
     * Delete cookie.
     *
     * @throws Phoenix\Exceptions\FailureException if HTTP headers have been sent
     * @param string $name
     *            name of the cookie
     * @param string $path
     *            [optional] default null
     * @param string $domain
     *            [optional] default null
     * @param bool $secure
     *            [optional] default null
     * @return void
     */
    public final function deleteCookie($name, $path = null, $domain = null, $secure = null) {
        $this->setCookie($name, null, 0, $path, $domain, $secure);
        return;
    }

    /**
     * Remove duplicate cookies from response.
     *
     * @return void
     */
    private final function removeDuplicateCookies() {
        if (headers_sent($file, $line) || ini_get("suhosin.cookie.encrypt")) {
            return;
        }
        $flatten = array ();
        foreach (headers_list() as $header) {
            if (preg_match('/^Set-Cookie: .+?=/', $header, $m)) {
                $flatten[$m[0]] = $header;
                header_remove("Set-Cookie");
            }
        }
        foreach (array_values($flatten) as $key => $header) {
            header($header, $key === 0);
        }
        return;
    }

    /**
     * Checks if headers were sent before any content.
     * If fails, it throws FailureException.
     *
     * @throws Phoenix\Exceptions\FailureException
     */
    private final function checkHeaders() {
        if (headers_sent($file, $line)) {
            throw new FailureException(FrameworkExceptions::F_RESPONSE_HEADERS_SENT, "output started at " . $file . ":" . $line);
        } elseif ($this->warn_on_buffer && ob_get_length() && !array_filter(ob_get_status(true), function ($i) {
            return !$i["chunk_size"];
        })) {
            throw new FailureException(FrameworkExceptions::F_RESPONSE_HEADERS_SENT, "sending a HTTP header while already having some data in output buffer");
        }
        return;
    }
}
?>