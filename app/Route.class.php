<?php

/**
 * Route object.
 *
 * @version 1.3
 * @author MPI
 * */
class Route {
	private $model;
	private $view;
	private $controller;
	private $actions;
	private $linkUrl;
	private $linkBody;
	private $linkTitle;

	public function __construct($model, $view, $controller, $actions = null, $linkUrl = null, $linkBody = null, $linkTitle = null) {
		$this->model = $model;
		$this->view = $view;
		$this->controller = $controller;
		$this->actions = !is_null($actions) ? $actions : array();
		$this->linkUrl = $linkUrl;
		$this->linkBody = $linkBody;
		$this->linkTitle = $linkTitle;
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
	 * Get this linkUrl.
	 *
	 * @return string
	 */
	public function getLinkUrl() {
	    return $this->linkUrl;
	}
	
	/**
	 * Get this linkBody.
	 *
	 * @return string
	 */
	public function getLinkBody() {
	    return $this->linkBody;
	}
	
	/**
	 * Get this linkTitle.
	 *
	 * @return string
	 */
	public function getLinkTitle() {
	    return $this->linkTitle;
	}
}
?>