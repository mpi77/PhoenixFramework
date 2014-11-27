<?php

/**
 * Root entity object.
 * 
 * @version 1.3
 * @author MPI
 * */
abstract class Entity {

    public function __construct() {
    }

    /**
     * Get string representation of this entity class.
     *
     * @all entities must contain a toString method
     */
    public abstract function __toString();
}
?>
