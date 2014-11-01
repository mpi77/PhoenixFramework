<?php
Router::register("index", new Route("IndexModel", "IndexView", "IndexController", array (
                "index" => new RouteAction("index", new Breadcrumbs(Config::SITE_PATH, "index")) 
), new Breadcrumbs(Config::SITE_PATH, "Index")));

/**
 * Index controller.
 *
 * @version 1.3
 * @author MPI
 *        
 */
class IndexController extends Controller {

    public function __construct(Model $model, $args) {
        parent::__construct($model, $args);
    }

    public function getName() {
        return get_class($this);
    }

    /**
     * Show index page.
     */
    public function index() {
    }
}
?>