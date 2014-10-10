<?php

/**
 * Root entity object.
 * 
 * @version 1.1
 * @author MPI
 * */
abstract class Entity {

	public function __construct() {
	}

	/**
	 * Get name of this class.
	 *
	 * @all entities must contain a getName method
	 */
	public abstract function getName();
	
	/**
	 * Get string representation of this entity class.
	 *
	 * @all entities must contain a toString method
	 */
	public abstract function toString();
}
?>
