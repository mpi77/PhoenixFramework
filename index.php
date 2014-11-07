<?php
/**
 * Index page.
 *
 * @version 1.5
 * @author MPI
 * */

/* load system and config - for basic init */
require "app/lib/System.class.php";
require "app/Config.class.php";

/* set application environment */
System::setAppEnvironment(Config::APP_ENVIRONMENT);

/* load required files before scan - depends on order */
require "app/lib/Breadcrumbs.class.php";
require "app/RouteAction.class.php";
require "app/Route.class.php";
require "app/Router.class.php";
/* get files from app dir */
$m = System::findAllFiles("app", array (
                ".",
                "..",
                "System.class.php",
                "Config.class.php",
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
require 'gui/template/MasterTemplate.php';

exit();
?>