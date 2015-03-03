<?php

namespace Phoenix\Core;

use \Phoenix\Core\Model;
use \Phoenix\Http\Request;
use \Phoenix\Http\Response;

/**
 * Root view object.
 *
 * @version 1.11
 * @author MPI
 *        
 */
abstract class View {
    /**
     *
     * @var Phoenix\Core\Model
     */
    private $model;
    /**
     *
     * @var Phoenix\Http\Request
     */
    private $request;
    /**
     *
     * @var Phoenix\Http\Response
     */
    private $response;

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

    /**
     * Set this response.
     *
     * @param Phoenix\Http\Response $response            
     * @return void
     */
    protected final function setResponse(Response $response) {
        $this->response = $response;
    }

    /**
     * Get this response.
     *
     * @return Phoenix\Http\Response
     */
    public final function getResponse() {
        return $this->response;
    }
}
?>