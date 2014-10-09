<?php
/**
 * Index page.
 *
 * @version 1.0
 * @author MPI
 * */
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
define("NL", "\r\n");

require 'init.php';

$f = new FrontController();

require 'gui/template/PageTemplate.php';

exit();
?>