<?php

/**
 * Logger object
 *
 * @version 1.5
 * @author MPI
 * */
class Logger {

    private function __construct() {
    }

    /**
     * Log Exception.
     *
     * @param Database $db
     *            database object
     * @param Exception $e
     *            Exception object
     */
    public static function log(Exception $e, Database $db = null) {
        try {
            if (!is_null($db)) {
                Logger::saveIntoDatabase($db, $e);
            } else {
                Logger::saveIntoFile($e);
            }
        } catch (Exception $ex) {
            System::redirect(Config::SITE_PATH . Config::SHUTDOWN_PAGE);
        }
    }

    /**
     * Save Exception into Databse.
     *
     * @param Database $db
     *            database object
     * @param Exception $e
     *            Exception object
     */
    public static function saveIntoDatabase(Database $db, Exception $e) {
        try {
            $r = InternalLogEntity::insertRecord($db, get_class($e), $e->getCode(), $e->getTraceAsString(), $e->getMessage());
            if ($r != 1) {
                throw new WarningException(WarningException::W_INVALID_SQL_ACTION);
            }
        } catch (WarningException $ex) {
            self::saveIntoFile(new FailureException(FailureException::F_UNABLE_SAVE_WARNING));
            self::saveIntoFile($e);
            System::redirect(Config::SITE_PATH . Config::SHUTDOWN_PAGE);
        }
    }

    /**
     * Save Exception into log file.
     *
     * @param FailureException $e
     *            Exception object
     */
    public static function saveIntoFile(Exception $e) {
        $files = System::findAllFiles(Config::LOG_DIR, array (
                        ".",
                        ".." 
        ));
        $out_file = Config::LOG_DIR;
        sort($files);
        $reg_files = array ();
        foreach ($files as $file) {
            $r = explode("/", $file);
            if (preg_match("/^([0-9]+)\.log$/i", $r[1], $matches)) {
                $reg_files[$matches[1]] = filesize($file);
            }
        }
        $last = count($reg_files);
        if ($last > 0 && $reg_files[$last - 1] <= Config::LOG_SIZE) {
            $out_file .= "/" . ($last - 1) . ".log";
        } else {
            $out_file .= "/" . $last . ".log";
        }
        file_put_contents($out_file, sprintf("\n>> %s [%d] %s\n%s\n%s", get_class($e), $e->getCode(), date("Y-m-d H:i:s"), $e->getTraceAsString(), $e->getMessage()), FILE_APPEND | LOCK_EX);
    }
}
?>