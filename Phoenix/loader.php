<?php
/**
 * register loader
 *
 * @version 1.1
 * @author MPI
 * */

include "../Phoenix/Loaders/SimpleLoader.php";
spl_autoload_register("\Phoenix\Loaders\SimpleLoader::load");

?>
