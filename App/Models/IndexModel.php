<?php

namespace App\Models;

use \Phoenix\Core\Model;
use \Phoenix\Core\Database;

/**
 * Index model.
 *
 * @version 1.2
 * @author MPI
 *        
 */
class IndexModel extends Model {

    /**
     * Index model constructor.
     *
     * @param Phoenix\Core\Database $db            
     * @return void
     */
    public function __construct(Database $db) {
        parent::__construct($db);
    }
}
?>