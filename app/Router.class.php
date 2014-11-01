<?php

/**
 * Router 
 *
 * @version 1.3
 * @author MPI
 * */
class Router {
    const DISABLE_ROUTE_OVERWRITING = true;
    const DEFAULT_EMPTY_ROUTE = "index";
    const DEFAULT_EMPTY_ACTION = "index";
    
    private static $table = array ();
    private static $registrationEnabled = true;

    private function __construct() {
    }

    /**
     * Register new route to controller.
     *
     * @param string $routeName            
     * @param Route $route            
     */
    public static function register($routeName, Route $route) {
        if (self::$registrationEnabled === true) {
            $routeName = strtolower($routeName);
            self::initRouter();
            if((self::DISABLE_ROUTE_OVERWRITING !== true) || (self::DISABLE_ROUTE_OVERWRITING === true && self::isRoute($routeName) === false)){
                self::$table[$routeName] = $route;
            }
        }
    }

    /**
     * Get route by given routeName.
     *
     * @param string $routeName
     *            (if not found route, returns default route)
     * @return Route
     */
    public static function getRoute($routeName) {
        $routeName = strtolower($routeName);
        self::initRouter();
        
        // return a default route if no route is found
        if (self::isRoute($routeName) === false) {
            return self::$table[self::DEFAULT_EMPTY_ROUTE];
        }
        
        return self::$table[$routeName];
    }
    
    /**
     * Get all registered routes.
     *
     * @return array of Route
     */
    public static function getAllRoutes() {
        self::initRouter();
        return self::$table;
    }

    /**
     * Disable registration of controllers.
     */
    public static function disableRegistration() {
        self::$registrationEnabled = false;
    }

    /**
     * Check if route exists.
     *
     * @param string $routeName            
     * @return boolean => true (if route exists) | false (if route doesn't exist)
     */
    public static function isRoute($routeName) {
        return array_key_exists(strtolower($routeName), self::$table);
    }

    /**
     * Init router.
     */
    private static function initRouter() {
        if (empty(self::$table) || !is_array(self::$table)) {
            self::$table = array ();
        }
    }
}
?>