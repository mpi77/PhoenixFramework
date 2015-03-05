<?php

namespace Phoenix\Http;

use \JsonSerializable;
use Phoenix\Exceptions\FailureException;
use Phoenix\Exceptions\FrameworkExceptions;
use Phoenix\Utils\Strings;

/**
 * Url object.
 * It is based on URI Syntax (RFC 3986).
 *
 * @version 1.8
 * @author MPI
 *        
 */
class Url implements JsonSerializable {
    
    /** @var array */
    public static $default_ports = array (
                    "http" => 80,
                    "https" => 443 
    );
    
    /** @var string */
    private $scheme = "";
    
    /** @var string */
    private $user = "";
    
    /** @var string */
    private $pass = "";
    
    /** @var string */
    private $host = "";
    
    /** @var int */
    private $port = null;
    
    /** @var string */
    private $path = "";
    
    /** @var array */
    private $query = array ();
    
    /** @var string */
    private $fragment = "";

    /**
     * Url constructor.
     *
     * @param string $url
     *            [optional] default null creates emtpy Url object
     * @throws Phoenix\Exceptions\FailureException if URL is unsupported
     */
    public function __construct($url = null) {
        if (is_string($url)) {
            $p = @parse_url($url);
            if ($p === false) {
                throw new FailureException(FrameworkExceptions::F_URL_PARSE_ERROR);
            }
            
            $this->scheme = isset($p["scheme"]) ? $p["scheme"] : "";
            $this->port = isset($p["port"]) ? $p["port"] : null;
            $this->host = isset($p["host"]) ? rawurldecode($p["host"]) : "";
            $this->user = isset($p["user"]) ? rawurldecode($p["user"]) : "";
            $this->pass = isset($p["pass"]) ? rawurldecode($p["pass"]) : "";
            $this->setPath(isset($p["path"]) ? $p["path"] : "");
            $this->setQuery(isset($p["query"]) ? $p["query"] : array ());
            $this->fragment = isset($p["fragment"]) ? rawurldecode($p["fragment"]) : "";
        }
    }

    /**
     * Sets the scheme part of URI.
     *
     * @param string $scheme            
     * @return self
     */
    public function setScheme($scheme) {
        $this->scheme = (string) $scheme;
        return $this;
    }

    /**
     * Returns the scheme part of URI.
     *
     * @return string
     */
    public function getScheme() {
        return $this->scheme;
    }

    /**
     * Sets the user name part of URI.
     *
     * @param string $user            
     * @return self
     */
    public function setUser($user) {
        $this->user = (string) $user;
        return $this;
    }

    /**
     * Returns the user name part of URI.
     *
     * @return string
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Sets the password part of URI.
     *
     * @param string $password            
     * @return self
     */
    public function setPassword($password) {
        $this->pass = (string) $password;
        return $this;
    }

    /**
     * Returns the password part of URI.
     *
     * @return string
     */
    public function getPassword() {
        return $this->pass;
    }

    /**
     * Sets the host part of URI.
     *
     * @param string $host            
     * @return self
     */
    public function setHost($host) {
        $this->host = (string) $host;
        return $this;
    }

    /**
     * Returns the host part of URI.
     *
     * @return string
     */
    public function getHost() {
        return $this->host;
    }

    /**
     * Sets the port part of URI.
     *
     * @param string|int $port            
     * @return self
     */
    public function setPort($port) {
        $this->port = (int) $port;
        return $this;
    }

    /**
     * Returns the port part of URI.
     *
     * @return string
     */
    public function getPort() {
        return $this->port;
    }

    /**
     * Sets the path part of URI.
     *
     * @param string $path            
     * @return self
     */
    public function setPath($path) {
        $this->path = (string) $path;
        return $this;
    }

    /**
     * Returns the path part of URI.
     *
     * @return string
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * Sets the query part of URI.
     *
     * @param array|string $query            
     * @return self
     */
    public function setQuery($query) {
        $this->query = is_array($query) ? $query : self::parseQuery($query);
        return $this;
    }

    /**
     * Appends the query part of URI.
     *
     * @param array|string $query            
     * @return self
     */
    public function appendQuery($query) {
        $this->query = is_array($query) ? $this->query + $query : self::parseQuery($this->getQuery() . "&" . $query);
        return $this;
    }

    /**
     * Returns the query part of URI.
     *
     * @return string
     */
    public function getQuery() {
        if (PHP_VERSION_ID < 50400) {
            return str_replace("+", "%20", http_build_query($this->query, "", "&"));
        }
        return http_build_query($this->query, "", "&", PHP_QUERY_RFC3986);
    }

    /**
     * Returns query parameters of URI.
     *
     * @return array
     */
    public function getQueryParameters() {
        return $this->query;
    }

    /**
     * Returns query parameter of URI.
     *
     * @param string $name            
     * @param mixed $default
     *            [optional] default is null
     * @return mixed
     */
    public function getQueryParameter($name, $default = null) {
        return isset($this->query[$name]) ? $this->query[$name] : $default;
    }

    /**
     * Sets the query parameter of URI.
     *
     * @param string $name            
     * @param mixed $value
     *            null unsets the parameter
     * @return self
     */
    public function setQueryParameter($name, $value) {
        $this->query[$name] = $value;
        return $this;
    }

    /**
     * Sets the fragment part of URI.
     *
     * @param string $fragment            
     * @return self
     */
    public function setFragment($fragment) {
        $this->fragment = (string) $fragment;
        return $this;
    }

    /**
     * Returns the fragment part of URI.
     *
     * @return string
     */
    public function getFragment() {
        return $this->fragment;
    }

    /**
     * Returns the entire URI including query string and fragment.
     *
     * @return string
     */
    public function getAbsoluteUrl() {
        return $this->getHostUrl() . $this->path . (($tmp = $this->getQuery()) ? "?" . $tmp : "") . ($this->fragment === "" ? "" : "#" . $this->fragment);
    }

    /**
     * Returns the [user[:pass]@]host[:port] part of URI.
     *
     * @return string
     */
    public function getAuthority() {
        return $this->host === "" ? "" : ($this->user !== "" && $this->scheme !== "http" && $this->scheme !== "https" ? rawurlencode($this->user) . ($this->pass === "" ? "" : ":" . rawurlencode($this->pass)) . "@" : "") . $this->host . ($this->port && (!isset(self::$default_ports[$this->scheme]) || $this->port !== self::$default_ports[$this->scheme]) ? ":" . $this->port : "");
    }

    /**
     * Returns the scheme and authority part of URI.
     *
     * @return string
     */
    public function getHostUrl() {
        return ($this->scheme ? $this->scheme . ":" : "") . "//" . $this->getAuthority();
    }

    /**
     * Returns the base-path.
     *
     * @return string
     */
    public function getBasePath() {
        $pos = strrpos($this->path, "/");
        return $pos === false ? "" : substr($this->path, 0, $pos + 1);
    }

    /**
     * Returns the base-URI.
     *
     * @return string
     */
    public function getBaseUrl() {
        return $this->getHostUrl() . $this->getBasePath();
    }

    /**
     * Returns the relative-URI.
     *
     * @return string
     */
    public function getRelativeUrl() {
        return (string) substr($this->getAbsoluteUrl(), strlen($this->getBaseUrl()));
    }

    /**
     * URL comparison.
     *
     * @param string $url            
     * @return bool
     */
    public function isEqual($url) {
        $url = new self($url);
        $query = $url->query;
        sort($query);
        $query2 = $this->query;
        sort($query2);
        $http = in_array($this->scheme, array (
                        "http",
                        "https" 
        ), true);
        return $url->scheme === $this->scheme && !strcasecmp($url->host, $this->host) && $url->getPort() === $this->getPort() && ($http || $url->user === $this->user) && ($http || $url->pass === $this->pass) && self::unescape($url->path, "%/") === self::unescape($this->path, "%/") && $query === $query2 && $url->fragment === $this->fragment;
    }

    /**
     * Transforms URL to canonical form.
     *
     * @return self
     */
    public function canonicalize() {
        $this->path = preg_replace_callback('#[^!$&\'()*+,/:;=@%]+#', function ($m) {
            return rawurlencode($m[0]);
        }, self::unescape($this->path, "%/"));
        $this->host = strtolower($this->host);
        return $this;
    }

    /**
     *
     * @return string
     */
    public function __toString() {
        return $this->getAbsoluteUrl();
    }

    /**
     * Similar to rawurldecode, but preserves reserved chars encoded.
     *
     * @param string $s
     *            string to decode
     * @param string $reserved
     *            [optional] reserved characters; default is %;/?:@&=+,$
     * @return string
     */
    public static function unescape($s, $reserved = "%;/?:@&=+$,") {
        // reserved (@see RFC 2396) = ";" | "/" | "?" | ":" | "@" | "&" | "=" | "+" | "$" | ","
        // within a path segment, the characters "/", ";", "=", "?" are reserved
        // within a query component, the characters ";", "/", "?", ":", "@", "&", "=", "+", ",", "$" are reserved.
        if ($reserved !== "") {
            $s = preg_replace_callback('#%(' . substr(chunk_split(bin2hex($reserved), 2, '|'), 0, -1) . ')#i', function ($m) {
                return "%25" . strtoupper($m[1]);
            }, $s);
        }
        return rawurldecode($s);
    }

    /**
     * Parses query string.
     *
     * @param string $s            
     * @return array
     */
    public static function parseQuery($s) {
        parse_str($s, $res);
        if (get_magic_quotes_gpc()) { // for PHP 5.3
            $res = Strings::stripSlashes($res);
        }
        return $res;
    }
    
    /**
     * Serialize this object to JSON.
     *
     * @return string
     */
    public function jsonSerialize() {
        return $this->getAbsoluteUrl();
    }
}
?>