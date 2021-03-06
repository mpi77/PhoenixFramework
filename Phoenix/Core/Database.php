<?php

namespace Phoenix\Core;

use \Phoenix\Core\Config;
use \Phoenix\Exceptions\FrameworkExceptions as FX;
use \Phoenix\Exceptions\WarningException;
use \Phoenix\Exceptions\FailureException;
use \PDO;
use \PDOException;

/**
 * Database provides interaction between this program
 * and db server.
 * It is PDO wrapper for this framework.
 *
 * @version 1.12
 * @author MPI
 *        
 */
class Database {
    const EMPTY_RESULT = -1;
    /**
     *
     * @var PDO
     */
    private $link = null;
    /**
     *
     * @var integer
     */
    private $pool_id = null;
    /**
     *
     * @var boolean
     */
    private $status = null;

    /**
     * Initialize connection with db server.
     *
     * @throws Phoenix\Exceptions\FailureException
     * @param integer $pool_id
     *            it is key into Config::getDatabasePoll($pool_id)
     * @return void
     */
    public function __construct($pool_id) {
        $this->pool_id = $pool_id;
        if (empty($this->pool_id)) {
            throw new FailureException(FX::F_DB_MISSING_CONFIG);
        } else {
            $this->connect();
        }
    }

    /**
     * Run SELECT query on db.
     *
     * @throws Phoenix\Exceptions\WarningException
     * @param string $query
     *            SELECT single query
     * @param array $query_args
     *            array with query arguments in format array(":key1" => value1, ...)
     * @param array $fetch_config
     *            array with config fetch op. [type=>PDO::FETCH_ASSOC or PDO::FETCH_NUM or PDO::FETCH_CLASS, className=>string]
     * @return 2D array (more rows fetched) | 1D array (one row fetched) | Database::EMPTY_RESULT (nothing fetched)
     */
    public function selectQuery($query, $query_args, $fetch_config = array("type"=>PDO::FETCH_ASSOC, "className" => "")) {
        try {
            $r = $this->link->prepare($query);
            switch ($fetch_config["type"]) {
                case PDO::FETCH_ASSOC :
                    $r->setFetchMode(PDO::FETCH_ASSOC);
                    break;
                case PDO::FETCH_NUM :
                    $r->setFetchMode(PDO::FETCH_NUM);
                    break;
                case PDO::FETCH_CLASS :
                    $r->setFetchMode(PDO::FETCH_CLASS, $fetch_config["className"]);
                    break;
                default :
                    $r->setFetchMode(PDO::FETCH_ASSOC);
            }
            if ($r->execute($query_args)) {
                if ($r->rowCount() >= 1) {
                    return $r->fetchAll();
                } else {
                    return self::EMPTY_RESULT;
                }
            } else {
                throw new WarningException(FX::W_DB_INVALID_SQL_SELECT);
            }
        } catch (PDOException $e) {
            throw new WarningException(FX::W_DB_INVALID_SQL_SELECT);
        }
    }

    /**
     * Run INSERT, UPDATE, DELETE query on db.
     *
     * @throws Phoenix\Exceptions\WarningException
     * @param string $query
     *            action (INSERT, UPDATE, DELETE) single query
     * @param array $query_args
     *            array with query arguments in format array(":key1" => value1, ...)
     * @return integer of affected rows
     */
    public function actionQuery($query, $query_args) {
        try {
            $r = $this->link->prepare($query);
            if ($r->execute($query_args)) {
                return ($r->rowCount() > 0 ? $r->rowCount() : 0);
            } else {
                throw new WarningException(FX::W_DB_INVALID_SQL_ACTION);
            }
        } catch (PDOException $e) {
            throw new WarningException(FX::W_DB_INVALID_SQL_ACTION);
        }
    }

    /**
     * Get the ID of the last inserted row or sequence value.
     *
     * @param string $name
     *            name of the sequence object from which the ID should be returned.
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
     * @param integer $parameter_type
     *            parameters to quote string by PDO
     * @return string
     */
    public function quote($text, $parameter_type = null) {
        return $this->link->quote($text, $parameter_type);
    }

    /**
     * Start transaction.
     *
     * @throws Phoenix\Exceptions\WarningException
     * @return boolean
     */
    public function beginTransaction() {
        $r = false;
        try {
            $r = $this->link->beginTransaction();
        } catch (PDOException $e) {
            throw new WarningException(FX::W_DB_UNABLE_BEGIN_TRANSACTION);
        }
        return $r;
    }

    /**
     * Commit current transaction.
     *
     * @throws Phoenix\Exceptions\WarningException
     * @return boolean
     */
    public function commitTransaction() {
        $r = false;
        try {
            $r = $this->link->commit();
        } catch (PDOException $e) {
            throw new WarningException(FX::W_DB_UNABLE_COMMIT_TRANSACTION);
        }
        return $r;
    }

    /**
     * Rollback current transaction.
     *
     * @throws Phoenix\Exceptions\WarningException
     * @return boolean
     */
    public function rollbackTransaction() {
        $r = false;
        try {
            $r = $this->link->rollback();
        } catch (PDOException $e) {
            throw new WarningException(FX::W_DB_UNABLE_ROLLBACK_TRANSACTION);
        }
        return $r;
    }

    /**
     * Checks if inside a transaction
     *
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
     * @param integer $pool_id            
     * @return true (if succesfull test) | false (if unsuccesfull test)
     */
    public static function testConnection($pool_id) {
        $link = null;
        $cp = Config::getDatabasePool($pool_id);
        
        if (empty($cp) || !is_array($cp)) {
            return false;
        }
        
        try {
            $link = new PDO(sprintf("%s:host=%s:%d;dbname=%s;charset=%s", $cp[Config::DB_DRIVER], $cp[Config::DB_SERVER], $cp[Config::DB_PORT], $cp[Config::DB_SCHEMA], $cp[Config::DB_CHARSET]), $cp[Config::DB_LOGIN], $cp[Config::DB_PASSWORD]);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    /**
     * Connect to db server.
     *
     * @throws Phoenix\Exceptions\FailureException
     * @return void
     */
    private function connect() {
        $cp = Config::getDatabasePool($this->pool_id);
        try {
            if (empty($cp) || !is_array($cp)) {
                throw new PDOException();
            }
            $this->link = new PDO(sprintf("%s:host=%s:%d;dbname=%s;charset=%s", $cp[Config::DB_DRIVER], $cp[Config::DB_SERVER], $cp[Config::DB_PORT], $cp[Config::DB_SCHEMA], $cp[Config::DB_CHARSET]), $cp[Config::DB_LOGIN], $cp[Config::DB_PASSWORD]);
            $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->status = true;
        } catch (PDOException $e) {
            $this->status = false;
            throw new FailureException(FX::F_DB_UNABLE_CONNECT);
        }
    }
}
?>