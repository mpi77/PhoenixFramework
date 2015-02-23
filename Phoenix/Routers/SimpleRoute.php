<?php

namespace Phoenix\Routers;
use \Phoenix\Routers\IRoute;

/**
 * SimpleRoute object.
 *
 * @version 1.10
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
     * @param string $model            
     * @param string $view            
     * @param string $controller            
     */
    public function __construct($model, $view, $controller) {
        if (empty($model) || empty($view) || empty($controller)) {
            return;
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