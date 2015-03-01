<?php
/**
 * User controller.
 *
 * @version 1.6
 * @author MPI
 *        
 */
class UserController extends Controller {
    private static $validationTable = array ();

    public function __construct(Model $model, $args) {
        parent::__construct($model, $args);
    }

    public static function getRegexp($key) {
        return self::$validationTable[$key];
    }
}
?>