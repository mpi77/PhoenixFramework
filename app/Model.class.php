<?php

/**
 * Root model object.
 * 
 * @version 1.1
 * @author MPI
 * */
abstract class Model {
	private $db;

	public function __construct(Database $db) {
		$this->db = $db;
	}

	/**
	 * Get this db link.
	 *
	 * @return Database
	 */
	protected function getDb() {
		return $this->db;
	}
	
	/**
	 * Save user activity record to db.
	 *
	 * @param int $uid
	 *        	of user
	 * @param string $description
	 *        	text msg to save
	 * @return int
	 */
	public function insertActivityRecord($uid, $message) {
		return ActivityLogEntity::insertRecord($this->db, $uid, $message);
	}

	/**
	 * Get name of this class.
	 *
	 * @all models must contain a getName method
	 */
	public abstract function getName();
}
?>