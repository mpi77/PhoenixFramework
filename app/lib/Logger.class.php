<?php

/**
 * Logger object
 *
 * @version 1.2
 * @author MPI
 * */
class Logger {

    private function __construct() {
    }

    /**
     * Save Exception into db.
     *
     * @param Database $db
     *            database object
     * @param Exception $e
     *            Exception object
     */
    public static function saveException(Database $db, Exception $e) {
        try {
            $r = InternalLogEntity::insertRecord($db, get_class($e), $e->getCode(), $e->getTraceAsString());
            if ($r != 1) {
                throw new WarningException(WarningException::WARNING_INVALID_SQL_ACTION);
            }
        } catch (WarningException $e) {
            self::saveFailure(new FailureException(FailureException::FAILURE_UNABLE_SAVE_WARNING));
            header("Location: " . Config::SITE_PATH . Config::SHUTDOWN_PAGE);
            exit();
        }
    }

    /**
     * Save warning into db.
     *
     * @param Database $db
     *            database object
     * @param WarningException $e
     *            WarningException object
     */
    public static function saveWarning(Database $db, WarningException $e) {
        try {
            $r = InternalLogEntity::insertRecord($db, "WarningException", $e->getCode(), $e->getTraceAsString());
            if ($r != 1) {
                throw new WarningException(WarningException::WARNING_INVALID_SQL_ACTION);
            }
        } catch (WarningException $e) {
            self::saveFailure(new FailureException(FailureException::FAILURE_UNABLE_SAVE_WARNING));
            header("Location: " . Config::SITE_PATH . Config::SHUTDOWN_PAGE);
            exit();
        }
    }

    /**
     * Save failure to log file.
     *
     * @param FailureException $e            
     */
    public static function saveFailure(FailureException $e) {
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
        file_put_contents($out_file, sprintf("\n>> %s [%d] %s\n%s", $e->getName(), $e->getCode(), date("Y-m-d H:i:s"), $e->getTraceAsString()), FILE_APPEND | LOCK_EX);
    }
}
?>