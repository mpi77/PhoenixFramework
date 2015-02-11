<?php
/**
 * Index view.
 *
 * @version 1.9
 * @author MPI
 * */
class IndexView extends View {

    public function __construct(Model $model, $args, TemplateData $templateData = null) {
        parent::__construct($model, $args, $templateData);
    }

    /**
     * Show index page.
     *
     * @access HTML
     */
    public function index() {
        $tpd = $this->getTemplateData();
        $response = null;
        
        if ($this->getResponseFormat() == Response::RESPONSE_HTML) {
            $tpd->set("greeting", "<Welcome page>");
            $response = new HtmlResponse("gui/template/IndexTemplate.php", $tpd);
        } else {
            throw new WarningException(WarningException::W_RESPONSE_UNSUPPORTED_FORMAT);
        }
        return $response;
    }
}
?>