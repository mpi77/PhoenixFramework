<?php

namespace Phoenix\Routers;

/**
 * IRoute interface.
 *
 *
 * @version 1.0
 * @author MPI
 *        
 */
interface IRoute {

    /**
     * Get model name.
     *
     * @return string
     */
    public function getModelName();

    /**
     * Get view name.
     *
     * @return string
     */
    public function getViewName();

    /**
     * Get controller name.
     *
     * @return string
     */
    public function getControllerName();
}
?>