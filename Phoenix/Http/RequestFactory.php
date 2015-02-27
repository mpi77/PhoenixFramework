<?php

namespace Phoenix\Http;

use \Phoenix\Http\Url;
use \Phoenix\Http\Request;
use \Phoenix\Utils\Strings;
use \Phoenix\Utils\System;

/**
 * Request factory object.
 *
 * @version 1.6
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
    const CHARS = '\x09\x0A\x0D\x20-\x7E\xA0-\x{10FFFF}';
    /**
     *
     * @var array
     */
    private static $urlFilters = array (
                    "path" => array (
                                    "/\/{2,}/" => "/" 
                    ),
                    "url" => array () 
    );
    
    /**
     *
     * @var bool
     */
    private static $binary = false;
    /**
     *
     * @var array
     */
    private static $proxies = array ();

    private function __construct() {
    }

    /**
     *
     * @param bool $binary
     *            [optional] default is true
     * @return boolean
     */
    public static function setBinary($binary = true) {
        self::$binary = (bool) $binary;
        return true;
    }

    /**
     * Sets proxy.
     *
     * @param array|string $proxy            
     * @return boolean
     */
    public static function setProxy($proxy) {
        self::$proxies = (array) $proxy;
        return true;
    }

    /**
     * Creates current Request object.
     *
     * @return Phoenix\Http\Request
     */
    public static function createRequest() {
        
        // prepare Url of the request.
        $url = new Url();
        $url->setScheme(!empty($_SERVER["HTTPS"]) && strcasecmp($_SERVER["HTTPS"], "off") ? "https" : "http");
        $url->setUser(isset($_SERVER["PHP_AUTH_USER"]) ? $_SERVER["PHP_AUTH_USER"] : "");
        $url->setPassword(isset($_SERVER["PHP_AUTH_PW"]) ? $_SERVER["PHP_AUTH_PW"] : "");
        
        // host & port
        if ((isset($_SERVER[$tmp = "HTTP_HOST"]) || isset($_SERVER[$tmp = "SERVER_NAME"])) && preg_match("/^([a-z0-9_.-]+|\[[a-f0-9:]+\])(:\d+)?\z/i", $_SERVER[$tmp], $pair)) {
            $url->setHost(strtolower($pair[1]));
            if (isset($pair[2])) {
                $url->setPort(substr($pair[2], 1));
            } elseif (isset($_SERVER["SERVER_PORT"])) {
                $url->setPort($_SERVER["SERVER_PORT"]);
            }
        }
        
        // path & query
        $requestUrl = isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : "/";
        $requestUrl = preg_replace(array_keys(self::$urlFilters["url"]), array_values(self::$urlFilters["url"]), $requestUrl);
        $tmp = explode("?", $requestUrl, 2);
        $path = Url::unescape($tmp[0], "%/?#");
        $path = Strings::fixEncoding(preg_replace(array_keys(self::$urlFilters["path"]), array_values(self::$urlFilters["path"]), $path));
        $url->setPath($path);
        
        // detect script path
        $lpath = strtolower($path);
        $script = isset($_SERVER["SCRIPT_NAME"]) ? strtolower($_SERVER["SCRIPT_NAME"]) : "";
        if ($lpath !== $script) {
            $max = min(strlen($lpath), strlen($script));
            for($i = 0; $i < $max && $lpath[$i] === $script[$i]; $i++)
                ;
            $path = $i ? substr($path, 0, strrpos($path, "/", $i - strlen($path) - 1) + 1) : "/";
        }
        $url->setPath($path);
        
        // GET, POST, COOKIE
        $useFilter = (!in_array(ini_get("filter.default"), array (
                        "",
                        "unsafe_raw" 
        )) || ini_get("filter.default_flags"));
        $query = $useFilter ? filter_input_array(INPUT_GET, FILTER_UNSAFE_RAW) : (empty($_GET) ? array () : $_GET);
        $post = $useFilter ? filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW) : (empty($_POST) ? array () : $_POST);
        $cookies = $useFilter ? filter_input_array(INPUT_COOKIE, FILTER_UNSAFE_RAW) : (empty($_COOKIE) ? array () : $_COOKIE);
        if (get_magic_quotes_gpc()) {
            $query = Strings::stripslashes($query, $useFilter);
            $post = Strings::stripslashes($post, $useFilter);
            $cookies = Strings::stripslashes($cookies, $useFilter);
        }
        
        // remove invalid characters
        $reChars = '/^[' . self::CHARS . ']*+\z/u';
        if (!self::$binary) {
            $list = array (
                            & $query,
                            & $post,
                            & $cookies 
            );
            while (list ( $key, $val ) = each($list)) {
                foreach ($val as $k => $v) {
                    if (is_string($k) && (!preg_match($reChars, $k) || preg_last_error())) {
                        unset($list[$key][$k]);
                    } elseif (is_array($v)) {
                        $list[$key][$k] = $v;
                        $list[] = & $list[$key][$k];
                    } else {
                        $list[$key][$k] = (string) preg_replace('/[^' . self::CHARS . ']+/u', "", $v);
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
                if (!self::$binary && is_string($k) && (!preg_match($reChars, $k) || preg_last_error())) {
                    continue;
                }
                $files[$k] = self::rebuildFiles($_FILES[$k]);
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
        foreach (self::$proxies as $proxy) {
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
        if ($method === "POST" && isset($_SERVER["HTTP_X_HTTP_METHOD_OVERRIDE"]) && preg_match("/^[A-Z]+\z/", $_SERVER["HTTP_X_HTTP_METHOD_OVERRIDE"])) {
            $method = $_SERVER["HTTP_X_HTTP_METHOD_OVERRIDE"];
        }
        
        return new Request($url, $method, $post, $files, $cookies, $headers, $remoteAddr, $remoteHost);
    }

    /**
     * Rebuild Files array.
     * Output structure is FILES[string pool][int][name,type,tmp_name,error,size].
     *
     * @param array $file_post            
     * @return array
     */
    private static function rebuildFiles(&$files) {
        $r = array ();
        $reChars = '/^[' . self::CHARS . ']*+\z/u';
        
        for($i = 0; $i < count($files["name"]); $i++) {
            if (empty($files["name"][$i])) {
                continue;
            }
            
            $name = $files["name"][$i];
            if (get_magic_quotes_gpc()) {
                $name = Strings::stripslashes($name);
            }
            if (!self::$binary && is_string($name) && (!preg_match($reChars, $name) || preg_last_error())) {
                $name = "renamed";
            }
            
            $r[$i]["name"] = $name;
            $r[$i]["type"] = $files["type"][$i];
            $r[$i]["tmp_name"] = $files["tmp_name"][$i];
            $r[$i]["error"] = $files["error"][$i];
            $r[$i]["size"] = $files["size"][$i];
        }
        
        return $r;
    }
}
?>
