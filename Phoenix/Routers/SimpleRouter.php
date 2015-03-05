<?php

namespace Phoenix\Routers;

use \Phoenix\Routers\IRouter;
use \Phoenix\Routers\IRoute;
use \Phoenix\Routers\SimpleRoute;

/**
 * SimpleRouter
 *
 * @version 1.8
 * @author MPI
 *        
 */
class SimpleRouter implements IRouter {
    const DISABLE_ROUTE_OVERWRITING = true;
    const DEFAULT_EMPTY_ROUTE = "index";
    const DEFAULT_EMPTY_ACTION = "index";
    
    /** @var array */
    private static $table = array ();
    
    /** @var boolean */
    private static $registration_enabled = true;

    /**
     * SimpleRouter constructor.
     * Default route table is: array(self::DEFAULT_EMPTY_ROUTE=>SimpleRoute("IndexModel", "IndexView", "IndexController"))
     */
    public function __construct() {
    }

    /**
     * Get route by given route name.
     *
     * @param string $route_name
     *            (if route is not found, returns default route specified by self::DEFAULT_EMPTY_ROUTE)
     * @return IRoute
     */
    public function getRoute($route_name) {
        $route_name = strtolower($route_name);
        self::init();
        
        // return a default route if no route is found
        if ($this->isRoute($route_name) === false) {
            return self::$table[self::DEFAULT_EMPTY_ROUTE];
        }
        
        return self::$table[$route_name];
    }

    /**
     * Get all registered routes in SimpleRouter.
     *
     * @return array of IRoute
     */
    public function getAllRoutes() {
        self::init();
        return self::$table;
    }

    /**
     * Check if route exists in SimpleRouter.
     *
     * @param string $route_name            
     * @return boolean => true (if route exists) | false (if route doesn't exist)
     */
    public function isRoute($route_name) {
        self::init();
        return array_key_exists(strtolower($route_name), self::$table);
    }

    /**
     * Register new route into SimpleRouter.
     *
     * @throws Phoenix\Exceptions\FailureException
     * @param string $route_name            
     * @param IRoute $route            
     * @return void
     */
    public static function register($route_name, IRoute $route) {
        if (self::$registration_enabled === true) {
            $route_name = strtolower($route_name);
            self::init();
            if ((self::DISABLE_ROUTE_OVERWRITING !== true) || (self::DISABLE_ROUTE_OVERWRITING === true && array_key_exists($route_name, self::$table) === false)) {
                self::$table[$route_name] = $route;
            }
        }
    }

    /**
     * Disable registration of routes into SimpleRouter.
     *
     * @return void
     */
    public static function disableRegistration() {
        self::$registration_enabled = false;
    }

    /**
     * Init SimpleRouter table.
     * It creates route table with default self::DEFAULT_EMPTY_ROUTE=>SimpleRoute("IndexModel", "IndexView", "IndexController")
     *
     * @return void
     */
    private static function init() {
        if (empty(self::$table) || !is_array(self::$table)) {
            self::$table = array (
                            self::DEFAULT_EMPTY_ROUTE => new SimpleRoute("IndexModel", "IndexView", "IndexController") 
            );
        }
    }
}
?>