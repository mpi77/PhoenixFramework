<?php
/**
 * SimpleRoute unit test.
 *
 * @version 1.0
 * @author MPI
 * */
include '../../../../Phoenix/Routers/IRoute.php';
include '../../../../Phoenix/Routers/SimpleRoute.php';

use \Phoenix\Routers\SimpleRoute;
class SimpleRouteTest extends PHPUnit_Framework_TestCase {
    private $routeItem;

    protected function setUp() {
        $this->routeItem = null;
    }

    public function testEmptyConstructor() {
        $this->routeItem = new SimpleRoute(null, null, null);
        $this->assertNull($this->routeItem->getModelName());
        $this->assertNull($this->routeItem->getViewName());
        $this->assertNull($this->routeItem->getControllerName());
        
        $this->routeItem = new SimpleRoute("IndexModel", null, null);
        $this->assertNull($this->routeItem->getModelName());
        $this->assertNull($this->routeItem->getViewName());
        $this->assertNull($this->routeItem->getControllerName());
        
        $this->routeItem = new SimpleRoute(null, "IndexView", null);
        $this->assertNull($this->routeItem->getModelName());
        $this->assertNull($this->routeItem->getViewName());
        $this->assertNull($this->routeItem->getControllerName());
        
        $this->routeItem = new SimpleRoute(null, null, "IndexController");
        $this->assertNull($this->routeItem->getModelName());
        $this->assertNull($this->routeItem->getViewName());
        $this->assertNull($this->routeItem->getControllerName());
    }

    public function testBaseConstructor() {
        $this->routeItem = new SimpleRoute("IndexModel", "IndexView", "IndexController");
        $this->assertSame("IndexModel", $this->routeItem->getModelName());
        $this->assertSame("IndexView", $this->routeItem->getViewName());
        $this->assertSame("IndexController", $this->routeItem->getControllerName());
    }
}
?>