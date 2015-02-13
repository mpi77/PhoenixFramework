<?php

namespace Phoenix\Core;

use \Phoenix\Core\Model;
use \Phoenix\Http\Request;

/**
 * Root controller object.
 *
 * @version 1.7
 * @author MPI
 *        
 */
abstract class Controller {
    private $model;
    private $request;

    /**
     * Controller constructor.
     *
     * @param Model $model            
     * @param Request $request            
     */
    public function __construct(Model $model, Request $request) {
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
