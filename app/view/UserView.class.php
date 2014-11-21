<?php
/**
 * User view.
 *
 * @version 1.3
 * @author MPI
 * */
class UserView extends View {

    public function __construct(Model $model, $args, TemplateData $templateData = null) {
        parent::__construct($model, $args, $templateData);
    }

    public function getName() {
        return get_class($this);
    }
}
?>