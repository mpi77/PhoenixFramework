<?php

/**
 * Route object.
 *
 * @version 1.7
 * @author MPI
 * */
class Route {
    private $model;
    private $view;
    private $controller;
    private $actions;
    private $breadcrumbsItem;

    /**
     *
     * @param string $model            
     * @param string $view            
     * @param string $controller            
     * @param array $actions            
     * @param Breadcrumbs $breadcrumbsItem            
     */
    public function __construct($model, $view, $controller, $actions = null, Breadcrumbs $breadcrumbsItem = null) {
        if(empty($model) || empty($view) || empty($controller)){
            return;
        }
        $this->model = $model;
        $this->view = $view;
        $this->controller = $controller;
        $this->actions = !is_null($actions) ? $actions : array ();
        $this->breadcrumbsItem = $breadcrumbsItem;
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

    /**
     * Get action.
     *
     * @param string $actionName            
     * @return mixed
     */
    public function getAction($actionName) {
        $actionName = strtolower($actionName);
        
        if ($this->isAction($actionName) === false) {
            return null;
        }
        
        return $this->actions[$actionName];
    }

    /**
     * Get all available actions.
     *
     * @return mixed
     */
    public function getAllActions() {
        return $this->actions;
    }

    /**
     * Check if action exists.
     *
     * @param string $actionName            
     * @return boolean => true (if action exists) | false (if action doesn't exist)
     */
    public function isAction($actionName) {
        return array_key_exists(strtolower($actionName), $this->actions);
    }

    /**
     * Get this breadcrumbsItem.
     *
     * @return Breadcrumbs item
     */
    public function getBreadcrumbsItem() {
        return $this->breadcrumbsItem;
    }
}
?>