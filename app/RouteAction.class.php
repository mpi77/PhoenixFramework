<?php

/**
 * Route action object.
 *
 * @version 1.0
 * @author MPI
 * */
class RouteAction {
	private $runFunctionName;
	private $linkUrl;
	private $linkBody;
	private $linkTitle;

	public function __construct($runFunctionName, $linkUrl = null, $linkBody = null, $linkTitle = null) {
		$this->runFunctionName = $runFunctionName;
		$this->linkUrl = $linkUrl;
		$this->linkBody = $linkBody;
		$this->linkTitle = $linkTitle;
	}

	/**
	 * Get this runFunctionName.
	 * 
	 * @return string
	 */
	public function getRunFunctionName() {
		return $this->runFunctionName;
	}
	
	/**
	 * Get this linkUrl.
	 *
	 * @return string
	 */
	public function getLinkUrl() {
		return $this->linkUrl;
	}

	/**
	 * Get this linkBody.
	 *
	 * @return string
	 */
	public function getLinkBody() {
		return $this->linkBody;
	}
	
	/**
	 * Get this linkTitle.
	 *
	 * @return string
	 */
	public function getLinkTitle() {
	    return $this->linkTitle;
	}
}
?>