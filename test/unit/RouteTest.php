<?php
/**
 * Route unit test.
 *
 * @version 1.4
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

    public function testRequiredArgs() {
        $this->route = new Route(null, "ExView", "ExController");
        $this->assertNull($this->route->getModelName());
        $this->assertNull($this->route->getViewName());
        $this->assertNull($this->route->getControllerName());
        $this->assertNull($this->route->getAllActions());
        $this->assertNull($this->route->getBreadcrumbsItem());
        
        $this->route = new Route("ExModel", null, "ExController");
        $this->assertNull($this->route->getModelName());
        $this->assertNull($this->route->getViewName());
        $this->assertNull($this->route->getControllerName());
        $this->assertNull($this->route->getAllActions());
        $this->assertNull($this->route->getBreadcrumbsItem());
        
        $this->route = new Route("ExModel", "ExView", null);
        $this->assertNull($this->route->getModelName());
        $this->assertNull($this->route->getViewName());
        $this->assertNull($this->route->getControllerName());
        $this->assertNull($this->route->getAllActions());
        $this->assertNull($this->route->getBreadcrumbsItem());
        
        $this->route = new Route("ExModel", "ExView", "ExController");
        $this->assertEquals("ExModel", $this->route->getModelName());
        $this->assertEquals("ExView", $this->route->getViewName());
        $this->assertEquals("ExController", $this->route->getControllerName());
        $this->assertEmpty($this->route->getAllActions());
        $this->assertNull($this->route->getBreadcrumbsItem());
    }

    public function testActionsArg() {
        $this->route = new Route("ExModel", "ExView", "ExController", array ());
        $this->assertEquals("ExModel", $this->route->getModelName());
        $this->assertEquals("ExView", $this->route->getViewName());
        $this->assertEquals("ExController", $this->route->getControllerName());
        $this->assertEmpty($this->route->getAllActions());
        $this->assertNull($this->route->getBreadcrumbsItem());
        
        $a = array (
                        "login" => $this->getMock("RouteAction") 
        );
        $this->route = new Route("ExModel", "ExView", "ExController", $a);
        $this->assertEquals("ExModel", $this->route->getModelName());
        $this->assertEquals("ExView", $this->route->getViewName());
        $this->assertEquals("ExController", $this->route->getControllerName());
        $this->assertSame($a, $this->route->getAllActions());
        $this->assertNull($this->route->getBreadcrumbsItem());
        $this->assertInstanceOf("RouteAction", $this->route->getAction("login"));
        $this->assertTrue($this->route->isAction("login"));
        
        $b = array (
                        "login" => $this->getMock("RouteAction"),
                        "logout" => $this->getMock("RouteAction"),
                        "edit" => $this->getMock("RouteAction") 
        );
        $this->route = new Route("ExModel", "ExView", "ExController", $b);
        $this->assertEquals("ExModel", $this->route->getModelName());
        $this->assertEquals("ExView", $this->route->getViewName());
        $this->assertEquals("ExController", $this->route->getControllerName());
        $this->assertSame($b, $this->route->getAllActions());
        $this->assertNull($this->route->getBreadcrumbsItem());
        $this->assertTrue($this->route->isAction("login"));
        $this->assertTrue($this->route->isAction("logout"));
        $this->assertTrue($this->route->isAction("edit"));
        $this->assertInstanceOf("RouteAction", $this->route->getAction("login"));
        $this->assertInstanceOf("RouteAction", $this->route->getAction("logout"));
        $this->assertInstanceOf("RouteAction", $this->route->getAction("edit"));
    }
    
    public function testBreadcrumbsArg() {
        $this->route = new Route("ExModel", "ExView", "ExController", array (), null);
        $this->assertEquals("ExModel", $this->route->getModelName());
        $this->assertEquals("ExView", $this->route->getViewName());
        $this->assertEquals("ExController", $this->route->getControllerName());
        $this->assertEmpty($this->route->getAllActions());
        $this->assertNull($this->route->getBreadcrumbsItem());
    
        $this->route = new Route("ExModel", "ExView", "ExController", array(), $this->getMock("Breadcrumbs"));
        $this->assertEquals("ExModel", $this->route->getModelName());
        $this->assertEquals("ExView", $this->route->getViewName());
        $this->assertEquals("ExController", $this->route->getControllerName());
        $this->assertEmpty($this->route->getAllActions());
        $this->assertInstanceOf("Breadcrumbs", $this->route->getBreadcrumbsItem());
    }
}
?>