<?php
/**
 * Breadcrumbs class.
 *
 * @version 1.5
 * @author MPI
 *
 */
class Breadcrumbs {

    private function __construct() {
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
        return self::makeBreadcrumbString(!is_null($routeName) ? $routeName : $_GET["route"], !is_null($actionName) ? $actionName : $_GET["action"], $appendBefore, $appendAfter);
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
    private static function makeBreadcrumbString($routeName = null, $actionName = null, $appendBefore = null, $appendAfter = null, $styleBoxId = "page-breadcrumb", $styleOlClass = "breadcrumb", $styleActiveClass = "active") {
        $r = sprintf("<div id=\"%s\"><ol class=\"%s\">", $styleBoxId, $styleOlClass);
        $r .= !is_null($appendBefore) ? $appendBefore : "";
        $r .= sprintf("<li><a href=\"%s\">%s</a></li>", Config::SITE_PATH, "Home");
        if (!empty($routeName) && !empty($actionName) && Router::isRoute($routeName) && $routeName != Router::DEFAULT_EMPTY_ROUTE) {
            $route = Router::getRoute($routeName);
            $r .= sprintf("<li><a href=\"%s\">%s</a></li>", $route->getLinkUrl(), $route->getLinkBody());
            if ($route->isAction($actionName)) {
                $r .= sprintf("<li><a href=\"%s\" class=\"%s\">%s</a></li>", $route->getAction($actionName)->getLinkUrl(), $styleActiveClass, $route->getAction($actionName)->getLinkBody());
            }
        }
        $r .= !is_null($appendAfter) ? $appendAfter : "";
        $r .= "</ol></div>";
        return $r;
    }
}
?>