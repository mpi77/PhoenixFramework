<?php

/**
 * Acl class controls that user has privilege to do action.
 *
 * @version 1.0
 * @author MPI
 *
 */
class Acl{
	const ACL_USER_LOGIN = 1;

	public static function check($acl_module, $args = null){
		switch($acl_module){
			case self::ACL_USER_LOGIN:
				break;
			default:
				echo "not implemented yet";
		}
	}

	public static function isLoggedin(){
		return (isset($_SESSION["user"]["auth"]) && $_SESSION["user"]["auth"]);
	}
}
?>