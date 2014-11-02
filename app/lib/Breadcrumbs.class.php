<?php
/**
 * Breadcrumbs class.
 *
 * @version 1.11
 * @author MPI
 *
 */
class Breadcrumbs {
    private $url;
    private $body;
    private $title;

    /**
     *
     * @param string $url            
     * @param integer $body
     *            translate constant for body
     * @param integer $title
     *            translate constant for title
     */
    public function __construct($url, $body, $title = null) {
        $this->url = $url;
        $this->body = $body;
        $this->title = $title;
    }

    /**
     * Get this url.
     *
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * Get this body.
     *
     * @return integer
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * Get this title.
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    public function __toString() {
        return "Breadcrumbs{url=" . $this->url . ", body=" . $this->body . ", title=" . $this->title . "}";
    }

    /**
     * Get breadcrumbs string.
     *
     * @param string $routeName
     *            default empty, GET[route] if this arg is null
     * @param string $actionName
     *            default empty, GET[action] if this arg is null
     * @param string $appendBefore
     *            default empty
     * @param string $appendAfter
     *            default empty
     *            
     * @return string
     */
    public static function get($routeName = null, $actionName = null, $appendBefore = null, $appendAfter = null) {
        return self::makeBreadcrumbsString(!is_null($routeName) ? $routeName : (isset($_GET["route"]) ? $_GET["route"] : null), !is_null($actionName) ? $actionName : (isset($_GET["action"]) ? $_GET["action"] : null), $appendBefore, $appendAfter);
    }

    /**
     * Print breadcrumbs string.
     *
     * @param string $routeName
     *            default empty, GET[route] if this arg is null
     * @param string $actionName
     *            default empty, GET[action] if this arg is null
     * @param string $appendBefore
     *            default empty
     * @param string $appendAfter
     *            default empty
     *            
     * @return string
     */
    public static function e($routeName = null, $actionName = null, $appendBefore = null, $appendAfter = null) {
        echo self::get($routeName, $actionName, $appendBefore, $appendAfter);
    }

    /**
     * Make breadcrumbs string.
     *
     * @param string $routeName
     *            default empty
     * @param string $actionName
     *            default empty
     * @param string $appendBefore
     *            default empty
     * @param string $appendAfter
     *            default empty
     * @param string $styleBoxId
     *            default page-breadcrumb
     * @param string $styleOlClass
     *            default breadcrumb
     * @param string $styleActiveClass
     *            default active
     *            
     * @return string
     */
    private static function makeBreadcrumbsString($routeName = null, $actionName = null, $appendBefore = null, $appendAfter = null, $styleBoxId = "page-breadcrumb", $styleOlClass = "breadcrumb", $styleActiveClass = "active") {
        $r = sprintf("<div id=\"%s\"><ol class=\"%s\">", $styleBoxId, $styleOlClass);
        $r .= !is_null($appendBefore) ? $appendBefore : "";
        $r .= sprintf("<li><a href=\"%s\">%s</a></li>", Config::SITE_PATH, "Home");
        if (!empty($routeName) && !empty($actionName) && Router::isRoute($routeName) && $routeName != Router::DEFAULT_EMPTY_ROUTE) {
            $route = Router::getRoute($routeName);
            if ($route instanceof Route) {
                if ($route->getBreadcrumbsItem() instanceof Breadcrumbs) {
                    $r .= self::makeBreadcrumbsItemString($route->getBreadcrumbsItem()->getUrl(), $route->getBreadcrumbsItem()->getBody(), $route->getBreadcrumbsItem()->getTitle(), null);
                }
                if ($route->isAction($actionName) && ($route->getAction($actionName) instanceof RouteAction) && ($route->getAction($actionName)->getBreadcrumbsItem() instanceof Breadcrumbs)) {
                    $r .= self::makeBreadcrumbsItemString($route->getAction($actionName)->getBreadcrumbsItem()->getUrl(), $route->getAction($actionName)->getBreadcrumbsItem()->getBody(), $route->getAction($actionName)->getBreadcrumbsItem()->getTitle(), $styleActiveClass);
                }
            }
        }
        $r .= !is_null($appendAfter) ? $appendAfter : "";
        $r .= "</ol></div>";
        return $r;
    }

    /**
     * Make breadcrumbs item string.
     *
     * @param string $url            
     * @param string $body            
     * @param string $title            
     * @param string $activeClass            
     * @return string
     */
    private static function makeBreadcrumbsItemString($url, $body, $title, $activeClass) {
        return sprintf("<li><a href=\"%s\"%s%s>%s</a></li>", $url, (!empty($title) ? " title=\"" . $title . "\"" : ""), (!empty($activeClass) ? " class=\"" . $activeClass . "\"" : ""), $body);
    }
}
?>