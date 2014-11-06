<?php
/**
 * Index page.
 *
 * @version 1.3
 * @author MPI
 * */
error_reporting(E_ALL);
define("NL", "\r\n");

/* load required files before scan */
require "app/lib/System.class.php";
require "app/lib/Breadcrumbs.class.php";
require "app/RouteAction.class.php";
require "app/Route.class.php";
require "app/Router.class.php";
/* get files from app dir */
$m = System::findAllFiles("app", array (
                ".",
                "..",
                "System.class.php",
                "Breadcrumbs.class.php",
                "RouteAction.class.php",
                "Route.class.php",
                "Router.class.php"
));
sort($m);
/* load files */
System::autoload(__DIR__, $m);

/* disable registering new routes */
Router::disableRegistration();

/* init session */
session_start();
System::initSession();

/* start proxy gateway (if proxy will detect app request, it will return to this place) */
$proxy = new Proxy();

/* proxy detected app request, continue with app (frontcontroller) */
$f = $proxy->getFrontController();
require 'gui/template/PageTemplate.php';

exit();
?>