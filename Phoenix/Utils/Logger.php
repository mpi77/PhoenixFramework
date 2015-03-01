<?php

namespace Phoenix\Utils;

use \Exception;
use \Phoenix\Core\Config;
use \Phoenix\Core\Database;
use \Phoenix\Dao\InternalLogDao;
use \Phoenix\Exceptions\WarningException;
use \Phoenix\Exceptions\FailureException;
use \Phoenix\Exceptions\FrameworkExceptions;
use \Phoenix\Utils\System;
use \Phoenix\Utils\Files;

/**
 * Logger object
 *
 * @version 1.6
 * @author MPI
 *        
 */
class Logger {

    /**
     * Logger constructor.
     */
    private function __construct() {
    }

    /**
     * Log exception.
     *
     * @param \Exception $e
     *            exception object
     * @param Phoenix\Core\Database $db
     *            [optional] database object, default null means save exception into log file
     * @return void
     */
    public static function log(Exception $e, Database $db = null) {
        try {
            if (!is_null($db)) {
                self::saveToDatabase($db, $e);
            } else {
                self::saveToFile($e);
            }
        } catch (Exception $ex) {
            System::redirect(Config::get(Config::KEY_SITE_FQDN) . Config::get(Config::KEY_SHUTDOWN_PAGE));
        }
    }

    /**
     * Save exception into databse.
     *
     * @param Phoenix\Core\Database $db
     *            database object
     * @param \Exception $e
     *            exception object
     * @return void
     */
    public static function saveToDatabase(Database $db, Exception $e) {
        try {
            $r = InternalLogDao::insertRecord($db, get_class($e), $e->getCode(), $e->getTraceAsString(), $e->getMessage());
            if ($r != 1) {
                throw new WarningException(FrameworkExceptions::W_DB_INVALID_SQL_ACTION);
            }
        } catch (WarningException $ex) {
            self::saveToFile(new FailureException(FrameworkExceptions::F_UNABLE_SAVE_WARNING));
            self::saveToFile($e);
            System::redirect(Config::get(Config::KEY_SITE_FQDN) . Config::get(Config::KEY_SHUTDOWN_PAGE));
        }
    }

    /**
     * Save exception into log file.
     *
     * @param \Exception $e
     *            exception object
     * @return void
     */
    public static function saveToFile(Exception $e) {
        $path = Config::getAbsoluteFolderPath(Config::KEY_DIR_LOG);
        $files = Files::findAllFiles($path, array (
                        ".",
                        ".." 
        ));
        $out_file = $path;
        sort($files);
        $reg_files = array ();
        foreach ($files as $file) {
            $r = explode("/", $file);
            if (preg_match("/^([0-9]+)\.log$/i", $r[1], $matches)) {
                $reg_files[$matches[1]] = filesize($file);
            }
        }
        $last = count($reg_files);
        if ($last > 0 && $reg_files[$last - 1] <= Config::get(Config::KEY_LOG_SIZE)) {
            $out_file .= "/" . ($last - 1) . ".log";
        } else {
            $out_file .= "/" . $last . ".log";
        }
        file_put_contents($out_file, sprintf("\n>> %s [%d] %s\n%s\n%s", get_class($e), $e->getCode(), date("Y-m-d H:i:s"), $e->getTraceAsString(), $e->getMessage()), FILE_APPEND | LOCK_EX);
    }
}
?>