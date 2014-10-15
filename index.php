<?php
/**
 * Index page.
 *
 * @version 1.2
 * @author MPI
 * */
error_reporting(E_ALL);
define("NL", "\r\n");

// load required classes and files
require "init.php";

// start proxy gateway (if proxy will detect app request, it will return to this place)
$proxy = new Proxy();

// proxy detected app request, continue with app (frontcontroller)
$f = $proxy->getFrontController();
require 'gui/template/PageTemplate.php';

exit();
?>