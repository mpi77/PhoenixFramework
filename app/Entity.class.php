<?php

/**
 * Root entity object.
 * 
 * @version 1.0
 * @author MPI
 * */
abstract class Entity {

	public function __construct() {
	}

	/**
	 * Get name of this class.
	 *
	 * @all views must contain a getName method
	 */
	public abstract function getName();
}
?>
