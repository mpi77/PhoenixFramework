<?php
/**
 * SimpleRouter unit test.
 *
 * @version 1.0
 * @author MPI
 * */
include '../../../../Phoenix/Routers/IRouter.php';
include '../../../../Phoenix/Routers/IRoute.php';
include '../../../../Phoenix/Routers/SimpleRouter.php';
include '../../../../Phoenix/Routers/SimpleRoute.php';

use \Phoenix\Routers\SimpleRouter;
class SimpleRouterTest extends PHPUnit_Framework_TestCase {

    public function testBegin() {
        $this->assertFalse(SimpleRouter::isRoute("unknown"));
        $this->assertTrue(SimpleRouter::isRoute("index"));
        
        $this->assertInstanceOf("Phoenix\Routers\SimpleRoute", SimpleRouter::getRoute("unknown"));
        $this->assertInstanceOf("Phoenix\Routers\SimpleRoute", SimpleRouter::getRoute("index"));
    }
}
?>