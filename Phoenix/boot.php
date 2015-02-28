<?php
/**
 * boot the application
 *
 * @version 1.1
 * @author MPI
 * */

use \App\AppConfigurator;

$cfg = new AppConfigurator();
$cfg->run();

?>