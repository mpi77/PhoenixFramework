<?php

/**
 * Route action object.
 *
 * @version 1.3
 * @author MPI
 * */
class RouteAction {
    private $runFunctionName;
    private $breadcrumbsItem;

    /**
     *
     * @param string $runFunctionName            
     * @param Breadcrumbs $breadcrumbsItem            
     */
    public function __construct($runFunctionName, Breadcrumbs $breadcrumbsItem = null) {
        if (empty($runFunctionName)) {
            throw new WarningException(WarningException::WARNING_ROUTER_ROUTE_ACTION_INVALID, "RouteAction{runFunctionName=" + $runFunctionName + "}");
        }
        $this->runFunctionName = $runFunctionName;
        $this->breadcrumbsItem = $breadcrumbsItem;
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
     * Get this breadcrumbsItem.
     *
     * @return Breadcrumbs item
     */
    public function getBreadcrumbsItem() {
        return $this->breadcrumbsItem;
    }
}
?>