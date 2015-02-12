<?php
/**
 * Route action unit test.
 *
 * @version 1.1
 * @author MPI
 * */
include '../../app/RouteAction.class.php';
class RouteActionTest extends PHPUnit_Framework_TestCase {
    private $routeAction;

    protected function setUp() {
        $this->routeAction = null;
    }

    public function testEmptyFunctionName() {
        $this->routeAction = new RouteAction(null);
        $this->assertNull($this->routeAction->getRunFunctionName());
        $this->assertNull($this->routeAction->getBreadcrumbsItem());
    }

    public function testFunctionNameString() {
        $this->routeAction = new RouteAction("ExFunction");
        $this->assertEquals("ExFunction", $this->routeAction->getRunFunctionName());
        $this->assertNull($this->routeAction->getBreadcrumbsItem());
    }
    
    public function testFunctionNameNumber() {
        $this->routeAction = new RouteAction(123);
        $this->assertNull($this->routeAction->getRunFunctionName());
        $this->assertNull($this->routeAction->getBreadcrumbsItem());
    }
    
    public function testFunctionNameStringBreadcrumb() {
        $mock = $this->getMock("Breadcrumbs");
        $this->routeAction = new RouteAction("ExFunction", $mock);
        $this->assertEquals("ExFunction", $this->routeAction->getRunFunctionName());
        $this->assertInstanceOf("Breadcrumbs", $this->routeAction->getBreadcrumbsItem());
    }
    
    public function testFunctionNameNumberBreadcrumb() {
        $mock = $this->getMock("Breadcrumbs");
        $this->routeAction = new RouteAction(125, $mock);
        $this->assertNull($this->routeAction->getRunFunctionName());
        $this->assertNull($this->routeAction->getBreadcrumbsItem());
    }
}
?>