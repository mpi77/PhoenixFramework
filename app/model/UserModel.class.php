<?php
/**
 * User model.
 *
 * @version 1.0
 * @author MPI
 * */
class UserModel extends Model{

	public function __construct($db){
		parent::__construct($db);
	}

	public function getName(){
		return get_class($this);
	}
}
?>