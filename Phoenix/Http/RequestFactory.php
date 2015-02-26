<?php

namespace Phoenix\Http;

use \Phoenix\Http\Url;
use \Phoenix\Http\Request;
use \Phoenix\Utils\Strings;
use \Phoenix\Utils\System;

/**
 * Request factory object.
 *
 * @version 1.1
 * @author MPI
 *        
 */
class RequestFactory {
    /**
     * valid chars
     *
     * @internal
     *
     */
    const CHARS = '#^[\x09\x0A\x0D\x20-\x7E\xA0-\x{10FFFF}]*+\z#u';
    /**
     *
     * @var array
     */
    public $urlFilters = array (
                    "path" => array (
                                    "#/{2,}#" => "/" 
                    ),
                    "url" => array () 
    );
    
    /**
     *
     * @var bool
     */
    private $binary = false;
    /**
     *
     * @var array
     */
    private $proxies = array ();

    /**
     *
     * @param bool $binary
     *            [optional] default is true
     * @return self
     */
    public function setBinary($binary = true) {
        $this->binary = (bool) $binary;
        return $this;
    }

    /**
     * Sets proxy.
     *
     * @param array|string $proxy            
     * @return self
     */
    public function setProxy($proxy) {
        $this->proxies = (array) $proxy;
        return $this;
    }

    /**
     * Creates current Request object.
     *
     * @return Phoenix\Http\Request
     */
    public function createRequest() {
        
        // prepare Url of the request.
        $url = new Url();
        $url->setScheme(!empty($_SERVER["HTTPS"]) && strcasecmp($_SERVER["HTTPS"], "off") ? "https" : "http");
        $url->setUser(isset($_SERVER["PHP_AUTH_USER"]) ? $_SERVER["PHP_AUTH_USER"] : "");
        $url->setPassword(isset($_SERVER["PHP_AUTH_PW"]) ? $_SERVER["PHP_AUTH_PW"] : "");
        
        // host & port
        if ((isset($_SERVER[$tmp = "HTTP_HOST"]) || isset($_SERVER[$tmp = "SERVER_NAME"])) && preg_match("#^([a-z0-9_.-]+|\[[a-f0-9:]+\])(:\d+)?\z#i", $_SERVER[$tmp], $pair)) {
            $url->setHost(strtolower($pair[1]));
            if (isset($pair[2])) {
                $url->setPort(substr($pair[2], 1));
            } elseif (isset($_SERVER["SERVER_PORT"])) {
                $url->setPort($_SERVER["SERVER_PORT"]);
            }
        }
        
        // path & query
        $requestUrl = isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : "/";
        $requestUrl = preg_replace(array_keys($this->urlFilters["url"]), array_values($this->urlFilters["url"]), $requestUrl);
        $tmp = explode("?", $requestUrl, 2);
        $path = Strings::fixEncoding(preg_replace(array_keys($this->urlFilters["path"]), array_values($this->urlFilters["path"]), $tmp[0]));
        $url->setPath($path);
        $url->setQuery(isset($tmp[1]) ? $tmp[1] : "");
        
        // detect script path
        $script = isset($_SERVER["SCRIPT_NAME"]) ? $_SERVER["SCRIPT_NAME"] : "";
        if ($path !== $script) {
            $max = min(strlen($path), strlen($script));
            for($i = 0; $i < $max && $path[$i] === $script[$i]; $i++)
                ;
            $path = $i ? substr($path, 0, strrpos($path, "/", $i - $max - 1) + 1) : "/";
        }
        // $url->setScriptPath($path);
        
        // GET, POST, COOKIE
        $useFilter = (!in_array(ini_get("filter.default"), array (
                        "",
                        "unsafe_raw" 
        )) || ini_get("filter.default_flags"));
        $query = $url->getQueryParameters();
        $post = $useFilter ? filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW) : (empty($_POST) ? array () : $_POST);
        $cookies = $useFilter ? filter_input_array(INPUT_COOKIE, FILTER_UNSAFE_RAW) : (empty($_COOKIE) ? array () : $_COOKIE);
        if (get_magic_quotes_gpc()) {
            $post = Strings::stripslashes($post, $useFilter);
            $cookies = Strings::stripslashes($cookies, $useFilter);
        }
        
        // remove invalid characters
        if (!$this->binary) {
            $list = array (
                            & $query,
                            & $post,
                            & $cookies 
            );
            while (list ( $key, $val ) = each($list)) {
                foreach ($val as $k => $v) {
                    if (is_string($k) && (!preg_match(self::CHARS, $k) || preg_last_error())) {
                        unset($list[$key][$k]);
                    } elseif (is_array($v)) {
                        $list[$key][$k] = $v;
                        $list[] = & $list[$key][$k];
                    } elseif (!preg_match(self::CHARS, $v) || preg_last_error()) {
                        $list[$key][$k] = "";
                    }
                }
            }
            unset($list, $key, $val, $k, $v);
        }
        $url->setQuery($query);
        
        // FILES
        $files = array ();
        if (!empty($_FILES)) {
            foreach ($_FILES as $k => $v) {
                if (!$this->binary && is_string($k) && (!preg_match(self::CHARS, $k) || preg_last_error())) {
                    continue;
                }
                $files[$k] = $this->rebuildFiles($_FILES[$k]);
            }
        }
        
        // HEADERS
        if (function_exists("apache_request_headers")) {
            $headers = apache_request_headers();
        } else {
            $headers = array ();
            foreach ($_SERVER as $k => $v) {
                if (strncmp($k, "HTTP_", 5) == 0) {
                    $k = substr($k, 5);
                } elseif (strncmp($k, "CONTENT_", 8)) {
                    continue;
                }
                $headers[strtr($k, "_", "-")] = $v;
            }
        }
        $remoteAddr = isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : NULL;
        $remoteHost = isset($_SERVER["REMOTE_HOST"]) ? $_SERVER["REMOTE_HOST"] : NULL;
        
        // proxy
        foreach ($this->proxies as $proxy) {
            if (System::ipMatch($remoteAddr, $proxy)) {
                if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                    $remoteAddr = trim(current(explode(",", $_SERVER["HTTP_X_FORWARDED_FOR"])));
                }
                if (isset($_SERVER["HTTP_X_FORWARDED_HOST"])) {
                    $remoteHost = trim(current(explode(",", $_SERVER["HTTP_X_FORWARDED_HOST"])));
                }
                break;
            }
        }
        $method = isset($_SERVER["REQUEST_METHOD"]) ? $_SERVER["REQUEST_METHOD"] : NULL;
        if ($method === "POST" && isset($_SERVER["HTTP_X_HTTP_METHOD_OVERRIDE"]) && preg_match("#^[A-Z]+\z#", $_SERVER["HTTP_X_HTTP_METHOD_OVERRIDE"])) {
            $method = $_SERVER["HTTP_X_HTTP_METHOD_OVERRIDE"];
        }
        
        return new Request($url, $method, $post, $files, $cookies, $headers, $remoteAddr, $remoteHost);
    }

    function rebuildFiles(&$file_post) {
        $file_ary = array ();
        $file_count = count($file_post["name"]);
        
        for($i = 0; $i < $file_count; $i++) {
            if (empty($file_post["name"][$i])) {
                continue;
            }
            
            $name = $file_post["name"][$i];
            if (get_magic_quotes_gpc()) {
                $name = stripSlashes($name);
            }
            if (!$this->binary && is_string($name) && (!preg_match(self::CHARS, $name) || preg_last_error())) {
                $name = "renamed";
            }
            
            $file_ary[$i]["name"] = $name;
            $file_ary[$i]["type"] = $file_post["type"][$i];
            $file_ary[$i]["tmp_name"] = $file_post["tmp_name"][$i];
            $file_ary[$i]["error"] = $file_post["error"][$i];
            $file_ary[$i]["size"] = $file_post["size"][$i];
        }
        
        return $file_ary;
    }
}
?>