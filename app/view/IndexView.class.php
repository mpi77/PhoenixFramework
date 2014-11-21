<?php
/**
 * Index view.
 *
 * @version 1.5
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
	 * 
	 * @access Html
	 */
	public function index() {
	    // if format==HTML
	    $tpd = $this->getTemplateData();
	    $tpd->set("greeting", "<Welcome page>");
	    $response = new HtmlResponse("gui/template/IndexTemplate.php", $tpd);
	    return $response;
	}
}
?>