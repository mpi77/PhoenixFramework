<?php

namespace Phoenix\Core;

use \Phoenix\Core\Model;
// use \Phoenix\Http\Request;

/**
 * Root view object.
 *
 * @version 1.8
 * @author MPI
 *        
 */
abstract class View {
    private $model;
    private $request;

    /**
     * View constructor.
     *
     * @param Model $model            
     * @param unknown $request            
     */
    public function __construct(Model $model, $request) {
        $this->model = $model;
        $this->request = $request;
    }

    /**
     * Get this model.
     *
     * @return Model
     */
    protected final function getModel() {
        return $this->model;
    }

    /**
     * Get this request.
     *
     * @return Request
     */
    protected final function getRequest() {
        return $this->request;
    }
}
?>