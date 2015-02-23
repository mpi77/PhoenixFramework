<?php

namespace Phoenix\Routers;

/**
 * IRouter interface.
 *
 *
 * @version 1.0
 * @author MPI
 *        
 */
interface IRouter {

    /**
     * Get route by given route_name.
     *
     * @param string $route_name
     *            (if not found route, returns default route)
     * @return IRoute
     */
    public static function getRoute($route_name);

    /**
     * Get all registered routes.
     *
     * @return array of IRoute
     */
    public static function getAllRoutes();

    /**
     * Check if route exists.
     *
     * @param string $routeName            
     * @return boolean => true (if route exists) | false (if route doesn't exist)
     */
    public static function isRoute($route_name);
}
?>