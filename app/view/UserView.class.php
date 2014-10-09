<?php
/**
 * User view.
 *
 * @version 1.0
 * @author MPI
 * */
class UserView extends View{

	public function __construct(Model $model, $args){
		parent::__construct($model, $args);
	}

	public function getName(){
		return get_class($this);
	}
	
	public function outputJson(){
	}
	
	public function outputHtml(){
		include 'gui/template/UserTemplate.php';
	}
}
?>