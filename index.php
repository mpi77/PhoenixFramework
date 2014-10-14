<?php
/**
 * Index page.
 *
 * @version 1.1
 * @author MPI
 * */
error_reporting(E_ALL);
define("NL", "\r\n");

// load required classes and files
require "init.php";

// start proxy gateway (if proxy will detect app request, it will return to this place)
$p = new Proxy();

// proxy detected app request, continue with app
header("Content-Type: text/html; charset=utf-8");
$f = new FrontController();

require 'gui/template/PageTemplate.php';

exit();
?>