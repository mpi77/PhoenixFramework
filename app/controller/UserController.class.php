<?php
Router::register("user", new Route("UserModel", "UserView", "UserController"));

/**
 * User controller.
 *
 * @version 1.0
 * @author MPI
 *        
 */
class UserController extends Controller {

    public function __construct(Model $model, $args) {
        parent::__construct($model, $args);
    }

    public function getName() {
        return get_class($this);
    }
}
?>