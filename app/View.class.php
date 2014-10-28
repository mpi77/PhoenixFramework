<?php

/**
 * Root view object.
 *
 * @version 1.1
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
    protected function getModel() {
        return $this->model;
    }

    /**
     * Get this route name.
     *
     * @return string
     */
    protected function getRouteName() {
        return $this->args["GET"]["route"];
    }

    /**
     * Get this action name.
     *
     * @return string
     */
    protected function getActionName() {
        return $this->args["GET"]["action"];
    }

    /**
     * Get this args.
     *
     * @return string
     */
    protected function getArgs() {
        return $this->args;
    }

    /**
     * Get this template data.
     *
     * @return TemplateData
     */
    protected function getTemplateData() {
        return $this->templateData;
    }

    /**
     * HTML output of view.
     *
     * @all views must contain a outputHtml method which
     * generates output to html tag DIV /id=content/
     */
    public abstract function outputHtml();

    /**
     * JSON output of view.
     *
     * @all views must contain a outputJson method which
     * generates output string of data JSON encoded
     */
    public abstract function outputJson();

    /**
     * Get name of this class.
     *
     * @all views must contain a getName method
     */
    public abstract function getName();
}
?>