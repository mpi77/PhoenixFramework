<?php
Router::register("index", new Route("IndexModel", "IndexView", "IndexController", array (
                "index" => new RouteAction("index", new Breadcrumbs(Config::SITE_PATH, Translator::BREADCRUMBS_BODY_INDEX_INDEX)) 
), new Breadcrumbs(Config::SITE_PATH, Translator::BREADCRUMBS_BODY_INDEX)));

/**
 * Index controller.
 *
 * @version 1.5
 * @author MPI
 *        
 */
class IndexController extends Controller {

    public function __construct(Model $model, $responseFormat, $args) {
        parent::__construct($model, $responseFormat, $args);
    }

    public function getName() {
        return get_class($this);
    }

    /**
     * Show index page.
     * 
     * @access HTML
     */
    public function index() {
        // allow only HtmlResponse
        if ($this->getResponseFormat() != Response::RESPONSE_HTML) {
            throw new WarningException(WarningException::W_RESPONSE_UNSUPPORTED_FORMAT);
        }
    }
}
?>