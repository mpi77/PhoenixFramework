<?php

/**
 * init file includes all required classes
 *
 * @version 1.3
 * @author MPI
 * @deprecated
 * */

/* load required files */
require "app/lib/System.class.php";
require "app/lib/Breadcrumbs.class.php";
require "app/Route.class.php";
require "app/Router.class.php";
$m = System::findAllFiles("app", array (
                ".",
                "..",
                "System.class.php",
                "Route.class.php",
                "Router.class.php",
                "Breadcrumbs.class.php"
));
sort($m);
System::autoload(__DIR__, $m);

/* disable registering new routes */
Router::disableRegistration();

/* init session */
session_start();
System::initSession();
?>
