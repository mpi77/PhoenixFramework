<?php

namespace Phoenix\Routers;

/**
 * IRouter interface.
 *
 *
 * @version 1.1
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
    public function getRoute($route_name);

    /**
     * Get all registered routes.
     *
     * @return array of IRoute
     */
    public function getAllRoutes();

    /**
     * Check if route exists.
     *
     * @param string $route_name            
     * @return boolean
     */
    public function isRoute($route_name);
}
?>