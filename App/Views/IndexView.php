<?php

namespace App\Views;

use \Phoenix\Core\View;
use \Phoenix\Core\Model;
use \Phoenix\Http\Request;
use \Phoenix\Utils\TemplateData;
use \Phoenix\Http\HtmlResponse;

/**
 * Index view.
 *
 * @version 1.11
 * @author MPI
 *        
 */
class IndexView extends View {
    
    /**
     *
     * @var Phoenix\Utils\TemplateData
     */
    private $teplate_data;

    /**
     * Index view constructor.
     *
     * @param Phoenix\Core\Model $model            
     * @param Phoenix\Http\Request $request            
     * @param Phoenix\Utils\TemplateData $template_data
     *            [optional] default is null
     */
    public function __construct(Model $model, Request $request, TemplateData $template_data = null) {
        parent::__construct($model, $request);
        $this->teplate_data = empty($template_data) ? new TemplateData() : $template_data;
    }

    /**
     * Show index page.
     *
     * @access HTML
     * @return Phoenix\Http\Response
     */
    public function index() {
        $this->teplate_data->set("greeting", "<Welcome page>");
        return new HtmlResponse("IndexTemplate.php", $this->teplate_data);
    }
}
?>