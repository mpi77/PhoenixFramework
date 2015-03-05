<?php

namespace Phoenix\Routers;

use \Phoenix\Routers\IRoute;
use \Phoenix\Exceptions\FailureException;
use \Phoenix\Exceptions\FrameworkExceptions;

/**
 * SimpleRoute object.
 *
 * @version 1.13
 * @author MPI
 *        
 */
class SimpleRoute implements IRoute {
    /** @var string */
    private $model;
    
    /** @var string */
    private $view;
    
    /** @var string */
    private $controller;

    /**
     * SimpleRoute constructor.
     *
     * @throws Phoenix\Exceptions\FailureException
     * @param string $model
     *            fully namespaced class name
     * @param string $view
     *            fully namespaced class name
     * @param string $controller
     *            fully namespaced class name
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
     * It is fully namespaced class name.
     *
     * @return string
     */
    public function getModelName() {
        return $this->model;
    }

    /**
     * Get this view name. 
     * It is fully namespaced class name.
     *
     * @return string
     */
    public function getViewName() {
        return $this->view;
    }

    /**
     * Get this controller name. 
     * It is fully namespaced class name.
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