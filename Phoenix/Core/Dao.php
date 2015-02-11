<?php

/**
 * Root Dao object.
 * 
 * @version 1.0
 * @author MPI
 * */
abstract class Dao {

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
