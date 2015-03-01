<?php
/**
 * SimpleRouter unit test.
 *
 * @version 1.1
 * @author MPI
 * */
include '../../../../Phoenix/Routers/IRouter.php';
include '../../../../Phoenix/Routers/IRoute.php';
include '../../../../Phoenix/Routers/SimpleRouter.php';
include '../../../../Phoenix/Routers/SimpleRoute.php';
include '../../../../Phoenix/Exceptions/BaseException.php';
include '../../../../Phoenix/Exceptions/FrameworkExceptions.php';
include '../../../../Phoenix/Exceptions/FailureException.php';

use \Phoenix\Routers\SimpleRoute;
use \Phoenix\Routers\SimpleRouter;

class SimpleRouterTest extends PHPUnit_Framework_TestCase {

    private $router;
    private static $route_table = array();
    
    protected function setUp() {
        $this->router = new SimpleRouter();
    }
    
    public function testDefaultRouterContent() {
        $this->assertFalse($this->router->isRoute("unknown"));
        $this->assertTrue($this->router->isRoute("index"));
        
        $this->assertInstanceOf("Phoenix\Routers\SimpleRoute", $this->router->getRoute("unknown"));
        $this->assertInstanceOf("Phoenix\Routers\SimpleRoute", $this->router->getRoute("index"));
    }
    
    public function testCustomRouterContent() {
        self::$route_table["user"] = new SimpleRoute("UserModel", "UserView", "UserController");
        self::$route_table["photo"] = new SimpleRoute("PhotoModel", "PhotoView", "PhotoController");
        self::$route_table["target"] = new SimpleRoute("TargetModel", "TargetView", "TargetController");
        
        SimpleRouter::register("user", self::$route_table["user"]);
        SimpleRouter::register("photo", self::$route_table["photo"]);
        SimpleRouter::register("target", self::$route_table["target"]);
        $this->assertTrue($this->router->isRoute("user"));
        $this->assertTrue($this->router->isRoute("photo"));
        $this->assertTrue($this->router->isRoute("target"));
        $this->assertInstanceOf("Phoenix\Routers\SimpleRoute", $this->router->getRoute("user"));
        $this->assertInstanceOf("Phoenix\Routers\SimpleRoute", $this->router->getRoute("photo"));
        $this->assertInstanceOf("Phoenix\Routers\SimpleRoute", $this->router->getRoute("target"));
        $all = $this->router->getAllRoutes();
        unset($all["index"]);
        $this->assertSame(self::$route_table, $all);
    }
    
    /**
     * @expectedException Phoenix\Exceptions\FailureException
     */
    public function testInvalidRouterContent() {
        SimpleRouter::register("basket", new SimpleRoute(null, null, null));
    }
    
    public function testOverwriteRouterContent() {
    
        /* Does not overwrite content of user item. */
        SimpleRouter::register("user", new SimpleRoute("BasketModel", "BasketView", "BasketController"));
        
        $this->assertTrue($this->router->isRoute("user"));
        $this->assertTrue($this->router->isRoute("photo"));
        $this->assertTrue($this->router->isRoute("target"));
        $this->assertFalse($this->router->isRoute("basket"));
        $this->assertInstanceOf("Phoenix\Routers\SimpleRoute", $this->router->getRoute("user"));
        $this->assertInstanceOf("Phoenix\Routers\SimpleRoute", $this->router->getRoute("photo"));
        $this->assertInstanceOf("Phoenix\Routers\SimpleRoute", $this->router->getRoute("target"));
        $this->assertInstanceOf("Phoenix\Routers\SimpleRoute", $this->router->getRoute("basket"));
        $all = $this->router->getAllRoutes();
        unset($all["index"]);
        $this->assertSame(self::$route_table, $all);
    }
    
    public function testVerifyCustomRouterContent() {
        $this->assertTrue($this->router->isRoute("user"));
        $this->assertTrue($this->router->isRoute("photo"));
        $this->assertTrue($this->router->isRoute("target"));
        $this->assertFalse($this->router->isRoute("basket"));
        $this->assertInstanceOf("Phoenix\Routers\SimpleRoute", $this->router->getRoute("user"));
        $this->assertInstanceOf("Phoenix\Routers\SimpleRoute", $this->router->getRoute("photo"));
        $this->assertInstanceOf("Phoenix\Routers\SimpleRoute", $this->router->getRoute("target"));
        $this->assertInstanceOf("Phoenix\Routers\SimpleRoute", $this->router->getRoute("basket")); // default is returned
        $all = $this->router->getAllRoutes();
        unset($all["index"]);
        $this->assertSame(self::$route_table, $all);
    }
    
    public function testDisableRegisteringRouterContent() {
        SimpleRouter::disableRegistration();
        
        SimpleRouter::register("basket", new SimpleRoute("BasketModel", "BasketView", "BasketController"));
        
        $this->assertTrue($this->router->isRoute("user"));
        $this->assertTrue($this->router->isRoute("photo"));
        $this->assertTrue($this->router->isRoute("target"));
        $this->assertFalse($this->router->isRoute("basket"));
        $this->assertInstanceOf("Phoenix\Routers\SimpleRoute", $this->router->getRoute("user"));
        $this->assertInstanceOf("Phoenix\Routers\SimpleRoute", $this->router->getRoute("photo"));
        $this->assertInstanceOf("Phoenix\Routers\SimpleRoute", $this->router->getRoute("target"));
        $this->assertInstanceOf("Phoenix\Routers\SimpleRoute", $this->router->getRoute("basket"));
        $all = $this->router->getAllRoutes();
        unset($all["index"]);
        $this->assertSame(self::$route_table, $all);
    }
}
?>