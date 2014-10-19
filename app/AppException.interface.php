<?php

/**
 * AppException interface
 *
 * @version 1.0
 * @author MPI
 * */
interface IAppException {
	public static function getTranslatedMessage($code);
}
?>