<?php

namespace Phoenix\Http;

use \JsonSerializable;
use \Phoenix\Http\Url;
use \Phoenix\Core\Config;
use \Phoenix\Exceptions\FailureException;
use \Phoenix\Exceptions\FrameworkExceptions;

/**
 * Root request object.
 *
 * @version 1.6
 * @author MPI
 *        
 */
class Request implements JsonSerializable {
    const GET = "GET";
    const POST = "POST";
    const HEAD = "HEAD";
    const PUT = "PUT";
    
    /** @var Phoenix\Http\Url */
    private $url;
    
    /** @var string */
    private $method;
    
    /** @var array */
    private $post;
    
    /** @var array */
    private $files;
    
    /** @var array */
    private $cookies;
    
    /** @var array */
    private $headers;
    
    /** @var string|null */
    private $remote_address;
    
    /** @var string|null */
    private $remote_host;

    /**
     * Request constructor.
     *
     * @throws Phoenix\Exceptions\FailureException
     * @param Url $url            
     * @param string $method            
     * @param string $post
     *            [optional] default null
     * @param string $files
     *            [optional] default null
     * @param string $cookies
     *            [optional] default null
     * @param string $headers
     *            [optional] default null
     * @param string $remote_address
     *            [optional] default null
     * @param string $remote_host
     *            [optional] default null
     * @return void
     */
    public function __construct(Url $url, $method, $post = null, $files = null, $cookies = null, $headers = null, $remote_address = null, $remote_host = null) {
        if (empty($method) || !is_string($method)) {
            throw new FailureException(FrameworkExceptions::F_REQUEST_INVALID_METHOD);
        }
        
        $this->url = $url;
        if (Config::get(Config::KEY_FORCE_HTTPS) === true && $this->isHttps() !== true) {
            throw new FailureException(FrameworkExceptions::F_REQUEST_FORCED_HTTPS);
        }
        
        $this->method = $method;
        $this->post = (array) $post;
        $this->files = (array) $files;
        $this->cookies = (array) $cookies;
        $this->headers = array_change_key_case((array) $headers, CASE_LOWER);
        $this->remote_address = $remote_address;
        $this->remote_host = $remote_host;
    }

    /**
     * Returns URL object.
     *
     * @return Phoenix\Http\Url
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * Is the request sent via unsecure (http) channel.
     *
     * @return bool
     */
    public function isHttp() {
        return $this->url->getScheme() === "http";
    }

    /**
     * Is the request sent via secure (https) channel.
     *
     * @return bool
     */
    public function isHttps() {
        return $this->url->getScheme() === "https";
    }

    /**
     * Returns variable provided via POST method ($_POST).
     * If no key is passed, returns the entire array.
     *
     * @param string $key
     *            [optional]
     * @param mixed $default
     *            [optional] default value
     * @return mixed
     */
    public function getPost($key = null, $default = null) {
        if (func_num_args() === 0) {
            return $this->post;
        } elseif (isset($this->post[$key])) {
            return $this->post[$key];
        } else {
            return $default;
        }
    }

    /**
     * Returns uploaded file.
     * Structure is FILES[string pool][int][name,type,tmp_name,error,size].
     *
     * @param string $pool
     *            find file in FILES[$pool]
     * @param string $file_name
     *            find file by file name in FILES[$pool][int][$file_name]
     * @param mixed $default
     *            [optional] returns if file was not found
     * @return mixed
     */
    public function getFile($pool, $file_name, $default = null) {
        if (empty($pool) || !is_string($pool)) {
            return $default;
        }
        if (is_string($file_name) && array_key_exists($pool, $this->files) && !empty($this->files)) {
            foreach ($this->files[$pool] as $v) {
                if ($v["name"] == $file_name) {
                    return $v;
                }
            }
        }
        return $default;
    }

    /**
     * Returns uploaded files.
     * Structure is FILES[string pool][int][name,type,tmp_name,error,size].
     *
     * @return array
     */
    public function getFiles() {
        return $this->files;
    }

    /**
     * Returns variable provided via cookies.
     *
     * @param string $key            
     * @param mixed $default
     *            [optional] default value
     * @return mixed
     */
    public function getCookie($key, $default = null) {
        return isset($this->cookies[$key]) ? $this->cookies[$key] : $default;
    }

    /**
     * Returns variables provided via cookies.
     *
     * @return array
     */
    public function getCookies() {
        return $this->cookies;
    }

    /**
     * Returns HTTP request method.
     * The method is case-sensitive.
     *
     * @return string
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * Checks if the request method is the given one.
     *
     * @param string $method            
     * @return bool
     */
    public function isMethod($method) {
        return strcasecmp($this->method, $method) === 0;
    }

    /**
     * Checks if the request method is GET.
     *
     * @return bool
     */
    public function isGet() {
        return $this->isMethod(self::GET);
    }

    /**
     * Checks if the request method is POST.
     *
     * @return bool
     */
    public function isPost() {
        return $this->isMethod(self::POST);
    }

    /**
     * Return the value of the HTTP header.
     * Pass the header name as the plain, HTTP-specified header name (e.g. 'Accept-Encoding').
     *
     * @param string $header            
     * @param mixed $default
     *            [optional] default value
     * @return mixed
     */
    public function getHeader($header, $default = null) {
        $header = strtolower($header);
        return isset($this->headers[$header]) ? $this->headers[$header] : $default;
    }

    /**
     * Returns all HTTP headers.
     *
     * @return array
     */
    public function getHeaders() {
        return $this->headers;
    }

    /**
     * Returns referrer.
     *
     * @return string|null
     */
    public function getReferer() {
        return isset($this->headers["referer"]) ? $this->headers["referer"] : null;
    }

    /**
     * Is AJAX request?
     *
     * @return bool
     */
    public function isAjax() {
        return $this->getHeader("X-Requested-With") === "XMLHttpRequest";
    }

    /**
     * Returns the IP address of the remote client.
     *
     * @return string|null
     */
    public function getRemoteAddress() {
        return $this->remote_address;
    }

    /**
     * Returns the host of the remote client.
     *
     * @return string|null
     */
    public function getRemoteHost() {
        if (!$this->remote_host) {
            $this->remote_host = $this->remote_address ? getHostByAddr($this->remote_address) : null;
        }
        return $this->remote_host;
    }

    /**
     * Parse Accept-Language header and returns preferred language.
     *
     * @param array $langs
     *            supported languages; example array("cs", "en", "it")
     * @return string|null
     */
    public function detectLanguage(array $langs) {
        $header = $this->getHeader("Accept-Language");
        if (!$header) {
            return null;
        }
        
        $s = strtolower($header);
        $s = strtr($s, "_", "-");
        rsort($langs);
        preg_match_all("#(" . implode("|", $langs) . ")(?:-[^\s,;=]+)?\s*(?:;\s*q=([0-9.]+))?#", $s, $matches);
        
        if (!$matches[0]) {
            return null;
        }
        
        $max = 0;
        $lang = null;
        foreach ($matches[1] as $key => $value) {
            $q = $matches[2][$key] === '' ? 1.0 : (float) $matches[2][$key];
            if ($q > $max) {
                $max = $q;
                $lang = $value;
            }
        }
        
        return $lang;
    }

    /**
     * Serialize this object to JSON.
     *
     * @return array
     */
    public function jsonSerialize() {
        return array (
                        "url" => $this->url,
                        "method" => $this->method,
                        "remote_address" => $this->remote_address,
                        "remote_host" => $this->remote_host 
        );
    }
}
?>