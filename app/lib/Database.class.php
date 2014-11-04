<?php

/**
 * Database provides interaction between this program
 * and db server.
 *
 * @version 1.5
 * @author MPI
 *        
 */
class Database {
    private $link = null;
    private $connectionParams = null;
    private $status = null;
    const EMPTY_RESULT = -1;

    /**
     * Initialize connection with db server.
     *
     * @param array $connectionParams
     *            with keys[server, port, login, password, schema, charset, driver]
     * @throws FailureException
     */
    public function __construct($connectionParams) {
        $this->connectionParams = $connectionParams;
        if (empty($this->connectionParams)) {
            throw new FailureException(FailureException::FAILURE_MISSING_CONFIG_DB);
        } else {
            $this->connect();
        }
    }

    /**
     * Ask SELECT query on db.
     *
     * @param string $query
     *            SELECT single query
     * @param array $queryArgs
     *            array with query arguments
     * @param array $fetchConfig
     *            array with config fetch op. [type=>PDO::FETCH_ASSOC or PDO::FETCH_NUM or PDO::FETCH_CLASS, className=>string]
     * @throws WarningException
     * @return 2D array (more rows fetched) | 1D array (one row fetched) | Database::EMPTY_RESULT (nothing fetched)
     */
    public function selectQuery($query, $queryArgs, $fetchConfig = array("type"=>PDO::FETCH_ASSOC, "className" => "")) {
        try {
            $r = $this->link->prepare($query);
            switch ($fetchConfig["type"]) {
                case PDO::FETCH_ASSOC :
                    $r->setFetchMode(PDO::FETCH_ASSOC);
                    break;
                case PDO::FETCH_NUM :
                    $r->setFetchMode(PDO::FETCH_NUM);
                    break;
                case PDO::FETCH_CLASS :
                    $r->setFetchMode(PDO::FETCH_CLASS, $fetchConfig["className"]);
                    break;
                default :
                    $r->setFetchMode(PDO::FETCH_ASSOC);
            }
            if ($r->execute($queryArgs)) {
                if ($r->rowCount() >= 1) {
                    return $r->fetchAll();
                } else {
                    return self::EMPTY_RESULT;
                }
            } else {
                throw new WarningException(WarningException::WARNING_INVALID_SQL_SELECT);
            }
        } catch (PDOException $e) {
            throw new WarningException(WarningException::WARNING_INVALID_SQL_SELECT);
        }
    }

    /**
     * Ask INSERT, UPDATE, DELETE query on db.
     *
     * @param string $query
     *            action (INSERT, UPDATE, DELETE) single query
     * @param array $queryArgs
     *            array with query arguments
     * @throws WarningException
     * @return number of affected rows
     */
    public function actionQuery($query, $queryArgs) {
        try {
            $r = $this->link->prepare($query);
            if ($r->execute($queryArgs)) {
                return ($r->rowCount() > 0 ? $r->rowCount() : 0);
            } else {
                throw new WarningException(WarningException::WARNING_INVALID_SQL_ACTION);
            }
        } catch (PDOException $e) {
            throw new WarningException(WarningException::WARNING_INVALID_SQL_ACTION);
        }
    }

    /**
     * Get the ID of the last inserted row or sequence value.
     *
     * @param string $name
     *            Name of the sequence object from which the ID should be returned.
     * @return string
     */
    public function lastInsertId($name = null) {
        return $this->link->lastInsertId($name);
    }

    /**
     * Get quoted input string.
     *
     * @param string $text
     *            input text to be escaped
     * @param
     *            integer
     *            parameters to quote string by PDO
     * @return string
     */
    public function quote($text, $parameter_type = null) {
        return $this->link->quote($text, $parameter_type);
    }

    /**
     * Start transaction.
     *
     * @throws PDOException
     * @return boolean
     */
    public function beginTransaction() {
        return $this->link->beginTransaction();
    }

    /**
     * Commit current transaction.
     *
     * @throws PDOException
     * @return boolean
     */
    public function commitTransaction() {
        return $this->link->commit();
    }

    /**
     * Rollback current transaction.
     *
     * @throws PDOException
     * @return boolean
     */
    public function rollbackTransaction() {
        return $this->link->rollback();
    }

    /**
     * Checks if inside a transaction
     *
     * @throws PDOException
     * @return boolean
     */
    public function inTransaction() {
        return $this->link->inTransaction();
    }

    /**
     * Get current status of db connection.
     *
     * @return boolean (true if conn is up | false if conn is down)
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Test connection to db server.
     *
     * @param array $connectionParams
     *            with keys[server, login, password, schema, charset, driver]
     *            
     * @return true (if succesfull test) | false (if unsuccesfull test)
     */
    public static function testConnection($connectionParams) {
        $link = null;
        
        if (empty($connectionParams)) {
            return false;
        }
        
        try {
            $link = new PDO(sprintf("%s:host=%s:%d;dbname=%s;charset=%s", $connectionParams["driver"], $connectionParams["server"], $connectionParams["port"], $connectionParams["schema"], $connectionParams["charset"]), $connectionParams["login"], $connectionParams["password"]);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    /**
     * Connect to db server.
     *
     * @throws FailureException
     */
    private function connect() {
        try {
            $this->link = new PDO(sprintf("%s:host=%s:%d;dbname=%s;charset=%s", $this->connectionParams["driver"], $this->connectionParams["server"], $this->connectionParams["port"], $this->connectionParams["schema"], $this->connectionParams["charset"]), $this->connectionParams["login"], $this->connectionParams["password"]);
            $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->status = true;
        } catch (PDOException $e) {
            $this->status = false;
            throw new FailureException(FailureException::FAILURE_UNABLE_CONNECT_DB);
        }
    }
}

?>