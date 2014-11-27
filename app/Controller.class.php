<?php

/**
 * Root controller object.
 * 
 * @version 1.4
 * @author MPI
 * */
abstract class Controller {
    private $model;
    private $args;

    public function __construct(Model $model, $args) {
        $this->model = $model;
        $this->args = $args;
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
     * Get this route name.
     *
     * @return string
     */
    protected final function getRouteName() {
        return $this->args["GET"]["route"];
    }

    /**
     * Get this action name.
     *
     * @return string
     */
    protected final function getActionName() {
        return $this->args["GET"]["action"];
    }
    
    /**
     * Get this response format.
     *
     * @return integer
     */
    protected final function getResponseFormat() {
        return $this->args["GET"]["format"];
    }

    /**
     * Get this args.
     *
     * @return string
     */
    protected final function getArgs() {
        return $this->args;
    }
}
?>
