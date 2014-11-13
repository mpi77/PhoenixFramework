<?php
/**
 * Route unit test.
 *
 * @version 1.0
 * @author MPI
 * */
include '../../app/Route.class.php';
class RouteTest extends PHPUnit_Framework_TestCase {
    private $route;

    protected function setUp() {
        $this->route = null;
    }

    public function testEmptyConstructor() {
        $this->route = new Route(null, null, null);
        $this->assertNull($this->route->getModelName());
        $this->assertNull($this->route->getViewName());
        $this->assertNull($this->route->getControllerName());
        $this->assertNull($this->route->getAllActions());
        $this->assertNull($this->route->getBreadcrumbsItem());
    }
}
?>