<?php

namespace Phoenix\Loaders;

/**
 * SimpleLoader
 *
 * @version 1.3
 * @author MPI
 *        
 */
class SimpleLoader {
    const FOLDER_PREFIX = "../";
    const PHP_SUFFIX = ".php";
    private static $filesOk = 0;
    private static $filesFail = 0;

    /**
     * Load given class name.
     *
     * @param string $className            
     */
    public static function load($className) {
        $file = self::FOLDER_PREFIX . str_replace("\\", "/", $className) . self::PHP_SUFFIX;
        if (file_exists($file)) {
            include ($file);
            if (class_exists($className)) {
                self::$filesOk++;
                return true;
            }
        }
        self::$filesFail++;
        return false;
    }

    /**
     * Get statistics of loading classes.
     *
     * @return array (indexes: filesOk, filesFail)
     */
    public static function getStats() {
        return array (
                        "filesOk" => self::$filesOk,
                        "filesFail" => self::$filesFail 
        );
    }
}
?>