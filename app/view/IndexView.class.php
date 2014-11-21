<?php
/**
 * Index view.
 *
 * @version 1.3
 * @author MPI
 * */
class IndexView extends View{
    
	public function __construct(Model $model, $args, TemplateData $templateData = null){
		parent::__construct($model, $args, $templateData);
	}

	public function getName(){
		return get_class($this);
	}
	
	/**
	 * Show index page.
	 */
	public function index() {
	    $tpd = $this->getTemplateData();
	    $tpd->set("greeting", "<Welcome page>");
	    return new HtmlResponse("gui/template/IndexTemplate.php", $tpd);
	}

	public function outputHtml(){
	    // deprecated
	}
}
?>