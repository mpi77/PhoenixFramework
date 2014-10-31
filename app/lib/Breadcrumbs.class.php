<?php
/**
 * Breadcrumbs class.
 *
 * @version 1.2
 * @author MPI
 *
 */
class Breadcrumbs {

    private function __construct() {
    }

    public static function get($routeName, $actionName, $appendBefore = null, $appendAfter = null) {
        return self::makeBreadcrumbString($routeName, $actionName, $appendBefore, $appendAfter);
    }

    private static function makeBreadcrumbString($routeName, $actionName, $appendBefore = null, $appendAfter = null, $styleBoxId = "page-breadcrumb", $styleOlClass = "breadcrumb") {
        $route = Router::getRoute($routeName);
        $r = sprintf("<div id=\"%s\"><ol class=\"%s\">", $styleBoxId, $styleOlClass);
        $r .= !is_null($appendBefore) ? $appendBefore : "";
        $r .= sprintf("<li><a href=\"%s\">%s</a></li>", Config::SITE_PATH, "Home");
        $r .= sprintf("<li><a href=\"%s\">%s</a></li>", $route->getLinkUrl(), $route->getLinkBody());
        $r .= sprintf("<li><a href=\"%s\">%s</a></li>", $route->getAction($actionName)->getLinkUrl(), $route->getAction($actionName)->getLinkBody());
        $r .= !is_null($appendAfter) ? $appendAfter : "";
        $r .= "</ol></div>";
        return $r;
    }
}
?>