<?php

/**
 * init file includes all required classes
 *
 * @version 1.0
 * @author MPI
 * */

/* load required files */
require "app/lib/System.class.php";
$m = System::findAllFiles("app", array(
		".",
		"..",
		"System.class.php"
));
sort($m);
autoload($m);

/* init session */
session_start();
System::initSession();

/**
 * Load classes in given list.
 *
 * @param array $file_list
 *        	1D with files for include
 *        	
 */
function autoload($file_list){
	foreach($file_list as $file){
		if(file_exists($file)){
			require __DIR__ . "/" . $file;
		}
	}
}
?>
