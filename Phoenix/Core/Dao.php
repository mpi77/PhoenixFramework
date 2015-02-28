<?php

namespace Phoenix\Core;

/**
 * Root Dao object.
 *
 * @version 1.2
 * @author MPI
 *        
 */
abstract class Dao {

    /**
     * Dao constructor.
     */
    public function __construct() {
    }

    /**
     * Get string representation of this Dao class.
     *
     * @all Daos must contain a toString method
     */
    public abstract function __toString();
}
?>