<?php
/**
 * SimpleRoute unit test.
 *
 * @version 1.1
 * @author MPI
 * */
include '../../../../Phoenix/Routers/IRoute.php';
include '../../../../Phoenix/Routers/SimpleRoute.php';
include '../../../../Phoenix/Exceptions/BaseException.php';
include '../../../../Phoenix/Exceptions/FrameworkExceptions.php';
include '../../../../Phoenix/Exceptions/FailureException.php';

use \Phoenix\Routers\SimpleRoute;
class SimpleRouteTest extends PHPUnit_Framework_TestCase {
    private $routeItem;

    protected function setUp() {
        $this->routeItem = null;
    }

    /**
     * @expectedException Phoenix\Exceptions\FailureException
     */
    public function testEmptyConstructor() {
        $this->routeItem = new SimpleRoute(null, null, null);
    }

    /**
     * @expectedException Phoenix\Exceptions\FailureException
     */
    public function testInvalidConstructor1() {
        $this->routeItem = new SimpleRoute("IndexModel", null, null);
    }

    /**
     * @expectedException Phoenix\Exceptions\FailureException
     */
    public function testInvalidConstructor2() {
        $this->routeItem = new SimpleRoute(null, "IndexView", null);
    }

    /**
     * @expectedException Phoenix\Exceptions\FailureException
     */
    public function testInvalidConstructor3() {
        $this->routeItem = new SimpleRoute(null, null, "IndexController");
    }

    public function testBaseConstructor() {
        $this->routeItem = new SimpleRoute("IndexModel", "IndexView", "IndexController");
        $this->assertSame("IndexModel", $this->routeItem->getModelName());
        $this->assertSame("IndexView", $this->routeItem->getViewName());
        $this->assertSame("IndexController", $this->routeItem->getControllerName());
    }
}
?>