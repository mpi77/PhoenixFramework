<?php
/**
 * boot the application
 *
 * @version 1.2
 * @author MPI
 * */

use \App\AppConfigurator;
use \Phoenix\Core\Proxy;

$cfg = new AppConfigurator();
$cfg->run();

$proxy = new Proxy();
$proxy->run();

?>