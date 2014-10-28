<?php
/**
 * Index view.
 *
 * @version 1.1
 * @author MPI
 * */
class IndexView extends View{
    
	public function __construct(Model $model, $args, TemplateData $templateData = null){
		parent::__construct($model, $args, $templateData);
	}

	public function getName(){
		return get_class($this);
	}

	public function outputJson(){
	}

	public function outputHtml(){
	    $tpd = $this->getTemplateData();
	    $tpd->set("greeting", "<Welcome page>");
		include 'gui/template/IndexTemplate.php';
	}
}
?>