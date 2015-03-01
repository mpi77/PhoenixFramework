<?php

namespace Phoenix\Routers;

use \Phoenix\Routers\IRoute;
use \Phoenix\Exceptions\FailureException;
use \Phoenix\Exceptions\FrameworkExceptions;

/**
 * SimpleRoute object.
 *
 * @version 1.12
 * @author MPI
 *        
 */
class SimpleRoute implements IRoute {
    private $model;
    private $view;
    private $controller;

    /**
     * SimpleRoute constructor.
     *
     * @throws Phoenix\Exceptions\FailureException
     * @param string $model            
     * @param string $view            
     * @param string $controller            
     * @return void
     */
    public function __construct($model, $view, $controller) {
        if (empty($model) || empty($view) || empty($controller)) {
            throw new FailureException(FrameworkExceptions::F_ROUTE_MISSING_ARGS);
        }
        $this->model = $model;
        $this->view = $view;
        $this->controller = $controller;
    }

    /**
     * Get this model name.
     *
     * @return string
     */
    public function getModelName() {
        return $this->model;
    }

    /**
     * Get this view name.
     *
     * @return string
     */
    public function getViewName() {
        return $this->view;
    }

    /**
     * Get this controller name.
     *
     * @return string
     */
    public function getControllerName() {
        return $this->controller;
    }

    public function __toString() {
        return "SimpleRoute{model=" . $this->model . ", view=" . $this->view . ", controller=" . $this->controller . "}";
    }
}
?>