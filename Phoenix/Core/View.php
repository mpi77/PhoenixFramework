<?php

namespace Phoenix\Core;

use \Phoenix\Core\Model;
use \Phoenix\Http\Request;

/**
 * Root view object.
 *
 * @version 1.10
 * @author MPI
 *        
 */
abstract class View {
    private $model;
    private $request;

    /**
     * View constructor.
     *
     * @param Phoenix\Core\Model $model            
     * @param Phoenix\Http\Request $request            
     * @return void
     */
    public function __construct(Model $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }

    /**
     * Get this model.
     *
     * @return Phoenix\Core\Model
     */
    protected final function getModel() {
        return $this->model;
    }

    /**
     * Get this request.
     *
     * @return Phoenix\Http\Request
     */
    protected final function getRequest() {
        return $this->request;
    }
}
?>