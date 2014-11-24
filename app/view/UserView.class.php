<?php
/**
 * User view.
 *
 * @version 1.4
 * @author MPI
 * */
class UserView extends View {

    public function __construct(Model $model, $responseFormat, $args, TemplateData $templateData = null) {
        parent::__construct($model, $responseFormat, $args, $templateData);
    }

    public function getName() {
        return get_class($this);
    }
}
?>