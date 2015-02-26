<?php

namespace Phoenix\Utils;

/**
 * File utils.
 *
 * @version 1.0
 * @author MPI
 *        
 */
class Files {

    private function __construct() {
    }

    private function __destruct() {
    }
    
    /**
     * Find all files in given directory.
     *
     * @param string $dir
     *            where start listing
     * @param array $exclude
     *            with names to exlude from result
     * @return 1D string array
     */
    public static function findAllFiles($dir, $exclude) {
        $root = scandir($dir);
        $result = array ();
        foreach ($root as $value) {
            if (in_array($value, $exclude)) {
                continue;
            }
            if (is_file("$dir/$value")) {
                $result[] = "$dir/$value";
                continue;
            }
            foreach (self::findAllFiles("$dir/$value", $exclude) as $value) {
                $result[] = $value;
            }
        }
        return $result;
    }

    /**
     * Remove given files.
     *
     * @param array $files
     *            string array with full names of files to remove
     */
    public static function removeFiles($files) {
        foreach ($files as $v) {
            if (file_exists($v)) {
                unlink($v);
            }
        }
    }
}
?>