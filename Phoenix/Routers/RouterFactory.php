<?php

namespace Phoenix\Routers;

use \Phoenix\Routers\SimpleRouter;

/**
 * Router factory object.
 *
 * @version 1.0
 * @author MPI
 *        
 */
class RouterFactory {
    const SIMPLE_ROUTER = 1;
    const DEFAULT_ROUTER = self::SIMPLE_ROUTER;

    private function __construct() {
    }

    /**
     * Creates new router object.
     *
     * @param integer $router
     *            [optional] constant defined in self::*_ROUTER; default null creates self::DEFAULT_ROUTER
     * @return Phoenix\Routers\IRouter
     */
    public static function createRouter($router = null) {
        switch ($router) {
            case self::SIMPLE_ROUTER :
                return new SimpleRouter();
                break;
            default :
                return self::createRouter(self::DEFAULT_ROUTER);
        }
    }
}
?>