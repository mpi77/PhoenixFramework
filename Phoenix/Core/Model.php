<?php

namespace Phoenix\Core;

use \Phoenix\Core\Database;
use \Phoenix\Dao\ActivityLogDao;

/**
 * Root model object.
 *
 * @version 1.7
 * @author MPI
 *        
 */
abstract class Model {
    /**
     *
     * @var Phoenix\Core\Database
     */
    private $db;

    /**
     * Model constructor.
     *
     * @param Phoenix\Core\Database $db            
     * @return void
     */
    public function __construct(Database $db) {
        $this->db = $db;
    }

    /**
     * Get this database instance.
     *
     * @return Phoenix\Core\Database
     */
    protected final function getDatabase() {
        return $this->db;
    }
}
?>