<?php

/**
 * Root view object.
 *
 * @version 1.6
 * @author MPI
 * */
abstract class View {
    private $model;
    private $templateData;
    private $args;

    public function __construct(Model $model, $args, TemplateData $templateData = null) {
        $this->model = $model;
        $this->args = $args;
        $this->templateData = is_null($templateData) ? new TemplateData() : $templateData;
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
     * @return mixed
     */
    protected final function getArgs() {
        return $this->args;
    }

    /**
     * Get this template data.
     *
     * @return TemplateData
     */
    protected final function getTemplateData() {
        return $this->templateData;
    }

    /**
     * Get name of this class.
     *
     * @all views must contain a getName method
     */
    public abstract function getName();
}
?>