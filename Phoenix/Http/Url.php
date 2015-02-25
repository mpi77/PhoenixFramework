<?php

namespace Phoenix\Http;

use Phoenix\Exceptions\WarningException;
use Phoenix\Exceptions\FrameworkExceptions;

/**
 * Url object.
 * It is based on URI Syntax (RFC 3986).
 *
 * @version 1.1
 * @author MPI
 *        
 */
class Url {
    
    /**
     *
     * @var array
     */
    public static $default_ports = array (
                    "http" => 80,
                    "https" => 443 
    );
    
    /**
     *
     * @var string
     */
    private $scheme = "";
    
    /**
     *
     * @var string
     */
    private $user = "";
    
    /**
     *
     * @var string
     */
    private $pass = "";
    
    /**
     *
     * @var string
     */
    private $host = "";
    
    /**
     *
     * @var int
     */
    private $port = null;
    
    /**
     *
     * @var string
     */
    private $path = "";
    
    /**
     *
     * @var string
     */
    private $query = "";
    
    /**
     *
     * @var string
     */
    private $fragment = "";

    /**
     * Url constructor.
     *
     * @param string $url            
     * @throws Phoenix\Exceptions\WarningException if URL is unsupported
     */
    public function __construct($url) {
        if (is_string($url)) {
            $parts = @parse_url($url);
            if ($parts === false) {
                throw new WarningException(FrameworkExceptions::W_URL_UNSUPPORTED_FORMAT);
            }
            
            foreach ($parts as $key => $val) {
                $this->$key = $val;
            }
            
            if (!$this->port && isset(self::$default_ports[$this->scheme])) {
                $this->port = self::$default_ports[$this->scheme];
            }
            
            if ($this->path === "" && ($this->scheme === "http" || $this->scheme === "https")) {
                $this->path = "/";
            }
        } else {
            throw new WarningException(FrameworkExceptions::W_URL_UNSUPPORTED_FORMAT);
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
     * @param string|array $query            
     * @return self
     */
    public function setQuery($query) {
        $this->query = (string) (is_array($query) ? http_build_query($query, "", "&") : $query);
        return $this;
    }

    /**
     * Appends the query part of URI.
     *
     * @param string|array $query            
     * @return self
     */
    public function appendQuery($query) {
        $query = (string) (is_array($query) ? http_build_query($query, "", "&") : $query);
        $this->query .= ($this->query === "" || $query === "") ? $query : "&" . $query;
        return $this;
    }

    /**
     * Returns the query part of URI.
     *
     * @return string
     */
    public function getQuery() {
        return $this->query;
    }

    /**
     * Returns query parameter of URI.
     *
     * @param string $name            
     * @param mixed $default
     *            default is null
     * @return mixed
     */
    public function getQueryParameter($name, $default = null) {
        parse_str($this->query, $params);
        return isset($params[$name]) ? $params[$name] : $default;
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
        parse_str($this->query, $params);
        if ($value === null) {
            unset($params[$name]);
        } else {
            $params[$name] = $value;
        }
        $this->setQuery($params);
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
        return $this->getHostUrl() . $this->path . ($this->query === "" ? "" : "?" . $this->query) . ($this->fragment === "" ? "" : "#" . $this->fragment);
    }

    /**
     * Returns the [user[:pass]@]host[:port] part of URI.
     *
     * @return string
     */
    public function getAuthority() {
        $authority = $this->host;
        if ($this->port && (!isset(self::$default_ports[$this->scheme]) || $this->port !== self::$default_ports[$this->scheme])) {
            $authority .= ":" . $this->port;
        }
        
        if ($this->user !== "" && $this->scheme !== "http" && $this->scheme !== "https") {
            $authority = $this->user . ($this->pass === "" ? "" : ":" . $this->pass) . "@" . $authority;
        }
        
        return $authority;
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
        parse_str($url->query, $query);
        sort($query);
        parse_str($this->query, $query2);
        sort($query2);
        $http = in_array($this->scheme, array (
                        'http',
                        'https' 
        ), true);
        return $url->scheme === $this->scheme && !strcasecmp(rawurldecode($url->host), rawurldecode($this->host)) && $url->port === $this->port && ($http || rawurldecode($url->user) === rawurldecode($this->user)) && ($http || rawurldecode($url->pass) === rawurldecode($this->pass)) && self::unescape($url->path, "%/") === self::unescape($this->path, "%/") && $query === $query2 && rawurldecode($url->fragment) === rawurldecode($this->fragment);
    }

    /**
     * Transforms URL to canonical form.
     *
     * @return self
     */
    public function canonicalize() {
        $this->path = $this->path === "" ? "/" : self::unescape($this->path, "%/");
        $this->host = strtolower(rawurldecode($this->host));
        $this->query = self::unescape(strtr($this->query, "+", " "), "%&;=+");
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
     *            reserved characters; default is %;/?:@&=+,$
     * @return string
     */
    public static function unescape($s, $reserved = "%;/?:@&=+$,") {
        // reserved (@see RFC 2396) = ";" | "/" | "?" | ":" | "@" | "&" | "=" | "+" | "$" | ","
        // within a path segment, the characters "/", ";", "=", "?" are reserved
        // within a query component, the characters ";", "/", "?", ":", "@", "&", "=", "+", ",", "$" are reserved.
        if ($reserved !== "") {
            $s = preg_replace_callback("#%(" . substr(chunk_split(bin2hex($reserved), 2, "|"), 0, -1) . ")#i", function ($m) {
                return "%25" . strtoupper($m[1]);
            }, $s);
        }
        return rawurldecode($s);
    }
}
?>
