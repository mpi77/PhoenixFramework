<?php
/**
 * Index controller.
 *
 * @version 1.8
 * @author MPI
 *        
 */
class IndexController extends Controller {

    public function __construct(Model $model, $args) {
        parent::__construct($model, $args);
    }

    /**
     * Show index page.
     * 
     * @access HTML
     */
    public function index() {
        // allow only HtmlResponse
        /*if ($this->getResponseFormat() != Response::RESPONSE_HTML) {
            throw new WarningException(WarningException::W_RESPONSE_UNSUPPORTED_FORMAT);
        }*/
    }
}
?>