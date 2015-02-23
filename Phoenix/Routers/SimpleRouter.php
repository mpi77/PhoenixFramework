<?php

namespace Phoenix\Routers;

use \Phoenix\Routers\IRouter;
use \Phoenix\Routers\IRoute;

/**
 * SimpleRouter
 *
 * @version 1.5
 * @author MPI
 *        
 */
class SimpleRouter implements IRouter {
    const DISABLE_ROUTE_OVERWRITING = true;
    const DEFAULT_EMPTY_ROUTE = "index";
    const DEFAULT_EMPTY_ACTION = "index";
    private static $table = array ();
    private static $registrationEnabled = true;

    /**
     * SimpleRouter constructor.
     */
    private function __construct() {
    }

    /**
     * Get route by given route name.
     *
     * @param string $route_name
     *            (if not found route, returns default route)
     * @return IRoute
     */
    public static function getRoute($route_name) {
        $route_name = strtolower($route_name);
        self::initRouter();
        
        // return a default route if no route is found
        if (self::isRoute($route_name) === false) {
            return self::$table[self::DEFAULT_EMPTY_ROUTE];
        }
        
        return self::$table[$route_name];
    }

    /**
     * Get all registered routes in SimpleRouter.
     *
     * @return array of IRoute
     */
    public static function getAllRoutes() {
        self::initRouter();
        return self::$table;
    }

    /**
     * Check if route exists in SimpleRouter.
     *
     * @param string $route_name            
     * @return boolean => true (if route exists) | false (if route doesn't exist)
     */
    public static function isRoute($route_name) {
        self::initRouter();
        return array_key_exists(strtolower($route_name), self::$table);
    }

    /**
     * Register new route into SimpleRouter.
     *
     * @param string $route_name            
     * @param IRoute $route            
     */
    public static function register($route_name, IRoute $route) {
        if (self::$registrationEnabled === true) {
            $route_name = strtolower($route_name);
            self::initRouter();
            if ((self::DISABLE_ROUTE_OVERWRITING !== true) || (self::DISABLE_ROUTE_OVERWRITING === true && self::isRoute($route_name) === false)) {
                self::$table[$route_name] = $route;
            }
        }
    }

    /**
     * Disable registration of routes into SimpleRouter.
     */
    public static function disableRegistration() {
        self::$registrationEnabled = false;
    }

    /**
     * Init SimpleRouter table.
     */
    private static function initRouter() {
        if (empty(self::$table) || !is_array(self::$table)) {
            self::$table = array (
                            self::DEFAULT_EMPTY_ROUTE => new SimpleRoute("IndexModel", "IndexView", "IndexController") 
            );
        }
    }
}
?>