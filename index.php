<?php
/**
 * Index page.
 *
 * @deprecated, will be removed in future release
 * 
 * @version 1.8
 * @author MPI
 * */

exit();

/*
require "app/lib/System.class.php";
require "app/Config.class.php";

System::setAppEnvironment(Config::APP_ENVIRONMENT);

require "app/lib/Breadcrumbs.class.php";
require "app/RouteAction.class.php";
require "app/Route.class.php";
require "app/Router.class.php";
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
System::autoload(__DIR__, $m);

Router::disableRegistration();

session_start();
System::initSession();

$proxy = new Proxy();

$f = $proxy->getFrontController();
if ($f instanceof FrontController) {
    $f->output();
}
exit();*/
?>