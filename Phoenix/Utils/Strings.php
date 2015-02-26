<?php

namespace Phoenix\Utils;

/**
 * String utils.
 *
 * @version 1.1
 * @author MPI
 *        
 */
class Strings {

    private function __construct() {
    }

    private function __destruct() {
    }

    /**
     * Removes invalid code unit sequences from UTF-8 string.
     *
     * @param string $s
     *            byte stream to fix
     * @return string
     */
    public static function fixEncoding($s) {
        // removes xD800-xDFFF, x110000 and higher
        if (PHP_VERSION_ID < 50400) {
            return @iconv("UTF-16", "UTF-8//IGNORE", iconv("UTF-8", "UTF-16//IGNORE", $s)); // intentionally @
        } else {
            return htmlspecialchars_decode(htmlspecialchars($s, ENT_NOQUOTES | ENT_IGNORE, "UTF-8"), ENT_NOQUOTES);
        }
    }

    /**
     * Strips slashes.
     *
     * @param string|array $arr            
     * @param bool $onlyKeys
     *            [optional] default false
     *            
     */
    public static function stripSlashes($arr, $onlyKeys = false) {
        $res = array ();
        foreach ($arr as $k => $v) {
            $res[stripslashes($k)] = is_array($v) ? self::stripSlashes($v, $onlyKeys) : ($onlyKeys ? $v : stripslashes($v));
        }
        return $res;
    }
}
?>