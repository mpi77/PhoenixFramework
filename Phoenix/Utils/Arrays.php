<?php

namespace Phoenix\Utils;

/**
 * Arrays utils.
 *
 * @version 1.0
 * @author MPI
 *        
 */
class Arrays {

    private function __construct() {
    }

    private function __destruct() {
    }

    /**
     * Compare given 1D arrays.
     * If all values from array $a are on same index in array $b, return true.
     *
     * @param array $a            
     * @param array $b            
     * @return boolean
     */
    public static function areEqual($a, $b) {
        if (count($a) != count($b))
            return false;
        for($i = 0; $i < count($a); $i++) {
            if ($a[$i] != $b[$i] || empty($a[$i]) != empty($b[$i]))
                return false;
        }
        return true;
    }

    /**
     * Check if given array is multidimensional.
     *
     * @param array $a            
     * @return boolean
     */
    public static function isMultidimensional($a) {
        if (!is_array($a)) {
            return false;
        }
        foreach ($a as $v) {
            if (is_array($v))
                return true;
        }
        return false;
    }

    /**
     * Trim&slash on 1D integer indexed array.
     * If item value is null, this item is added at same place.
     *
     * @param boolean $trim
     *            (true = make trim)
     * @param boolean $slash
     *            (true = make addslashes)
     * @return 1D array
     */
    public static function trimSlash1D($array, $trim = false, $slash = false) {
        $a = array ();
        for($i = 0; $i < count($array); $i++) {
            $tmp = null;
            if (!empty($array[$i])) {
                if ($trim === true)
                    $tmp = trim($array[$i]);
                if ($slash === true)
                    $tmp = addslashes($tmp);
            }
            array_push($a, $tmp);
        }
        return $a;
    }

    /**
     * Trim&slash on 1D string associative indexed array.
     * If item value is null, this item is added at same place.
     *
     * @param boolean $trim
     *            (true = make trim)
     * @param boolean $slash
     *            (true = make addslashes)
     * @return 1D array
     */
    public static function trimSlash1DAssoc($array, $trim = false, $slash = false) {
        $a = array ();
        foreach ($array as $k => $v) {
            $tmp = null;
            if (!empty($v)) {
                if ($trim === true)
                    $tmp = trim($v);
                if ($slash === true)
                    $tmp = addslashes($tmp);
            }
            $a[$k] = $tmp;
        }
        return $a;
    }

    /**
     * Trim&slash on multidimensional string indexed array.
     * If item value is null, this item is added at the same place.
     * Trim&slash are made also on string indexes.
     *
     * @param boolean $trim_*
     *            (true = run trim)
     * @param boolean $slash_*
     *            (true = run addslashes)
     * @return mixed array
     */
    public static function trimSlashMultidimAssoc($array, $trim_key = true, $slash_key = true, $trim_value = true, $slash_value = true) {
        $r = array ();
        foreach ($array as $k => $v) {
            $tmp_value = null;
            $tmp_key = null;
            if (is_array($v)) {
                $tmp_value = self::trimSlashMultidimAssocArray($v, $trim_key, $slash_key, $trim_value, $slash_value);
            } else {
                if (!empty($v)) {
                    if ($trim_value === true) {
                        $tmp_value = trim($v);
                    }
                    if ($slash_value === true) {
                        $tmp_value = addslashes($tmp_value);
                    }
                }
            }
            $tmp_key = ($trim_key ? trim($k) : $k);
            $tmp_key = ($slash_key ? addslashes($tmp_key) : $tmp_key);
            $r[$tmp_key] = $tmp_value;
        }
        return $r;
    }
}
?>