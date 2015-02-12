<?php

namespace Phoenix\Core;

use \Phoenix\Core\Database;
use \Phoenix\Dao\ActivityLogDao;

/**
 * Root model object.
 *
 * @version 1.5
 * @author MPI
 *        
 */
abstract class Model {
    private $db;

    /**
     * Model constructor.
     *
     * @param Database $db            
     */
    public function __construct(Database $db) {
        $this->db = $db;
    }

    /**
     * Get this db instance.
     *
     * @return Database
     */
    protected final function getDb() {
        return $this->db;
    }

    /**
     * Save user activity record to db.
     *
     * @param integer $uid
     *            of user
     * @param string $description
     *            text msg to save
     * @return integer
     */
    public final function insertActivityRecord($uid, $message) {
        return ActivityLogDao::insertRecord($this->db, $uid, $message);
    }
}
?>