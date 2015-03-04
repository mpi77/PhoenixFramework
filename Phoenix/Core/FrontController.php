<?php

namespace Phoenix\Core;

use \Phoenix\Core\Model;
use \Phoenix\Core\View;
use \Phoenix\Core\Controller;
use \Phoenix\Core\Database;
use \Phoenix\Exceptions\BaseException;
use \Phoenix\Exceptions\NoticeException;
use \Phoenix\Exceptions\WarningException;
use \Phoenix\Exceptions\FailureException;
use \Phoenix\Exceptions\FrameworkExceptions;
use \Phoenix\Http\Request;
use \Phoenix\Http\Response;
use \Phoenix\Http\ResponseFactory;
use \Phoenix\Routers\IRoute;
use \Phoenix\Routers\IRouter;
use \Phoenix\Routers\RouterFactory;
use \Phoenix\Utils\Logger;
use \Phoenix\Utils\System;

/**
 * FrontController
 *
 * @version 1.25
 * @author MPI
 *        
 */
class FrontController {
    /** @var Phoenix\Core\Database */
    private $db;
    
    /** @var Phoenix\Http\Request */
    private $request;
    
    /** @var Phoenix\Http\Response */
    private $response;
    
    /** @var Phoenix\Core\Model */
    private $model;
    
    /** @var Phoenix\Core\Controller */
    private $controller;
    
    /** @var Phoenix\Core\View  */
    private $view;
    
    /** @var Phoenix\Routers\IRouter */
    private $router;
    
    /** @var string */
    private $response_format;

    /**
     * Frontcontroller constructor.
     * It performs dispatching user request and runs the controller action.
     *
     * @param Phoenix\Core\Database $db            
     * @param Phoenix\Http\Request $request            
     * @return void
     */
    public function __construct(Database $db, Request $request) {
        $this->response = null;
        try {
            if ($db->getStatus() !== true) {
                throw new FailureException(FrameworkExceptions::F_DB_UNABLE_CONNECT);
            }
            $this->db = $db;
            $this->request = $request;
            $this->router = RouterFactory::createRouter(Config::get(Config::KEY_APP_USE_ROUTER));
            
            $this->dispatch();
            $this->performControllerAction();
        } catch (NoticeException $e) {
            $this->response = ResponseFactory::createResponse($this->response_format);
            $this->response->setException($e);
        } catch (WarningException $e) {
            Logger::log($e, $this->db);
            $this->response = ResponseFactory::createResponse($this->response_format);
            $this->response->setException($e);
        } catch (FailureException $e) {
            Logger::log($e);
            $this->response = ResponseFactory::createResponse($this->response_format);
            $this->response->setException($e);
        } catch (Exception $e) {
            Logger::log($e);
            $this->response = ResponseFactory::createResponse($this->response_format);
            $this->response->setException($e);
        }
    }

    /**
     * Frontcontroller destructor.
     *
     * @return void
     */
    public function __destruct() {
        if (!empty($this->db)) {
            $this->db = null;
        }
    }

    /**
     * Get this response.
     * It performs view action.
     *
     * @return Phoenix\Http\Response
     */
    public function getResponse() {
        try {
            $this->performViewAction();
        } catch (NoticeException $e) {
            $this->response = ResponseFactory::createResponse($this->response_format);
            $this->response->setException($e);
        } catch (WarningException $e) {
            Logger::log($e, $this->db);
            $this->response = ResponseFactory::createResponse($this->response_format);
            $this->response->setException($e);
        } catch (FailureException $e) {
            Logger::log($e);
            $this->response = ResponseFactory::createResponse($this->response_format);
            $this->response->setException($e);
        } catch (Exception $e) {
            Logger::log($e);
            $this->response = ResponseFactory::createResponse($this->response_format);
            $this->response->setException($e);
        }
        return $this->response;
    }

    /**
     * Dispatch user request and prepare model, view and controller.
     *
     * @throws Phoenix\Exceptions\WarningException
     * @return void
     */
    private function dispatch() {
        $route_name = $this->request->getUrl()->getQueryParameter("route");
        $this->response_format = $this->request->getUrl()->getQueryParameter("format");
        
        // if route is not found in router, it will returns default route for used router
        $route = $this->router->getRoute($route_name);
        if (!($route instanceof IRoute)) {
            throw new WarningException(FrameworkExceptions::W_ROUTER_INVALID_ROUTE, json_encode($this->request));
        }
        
        $this->createMvc($route->getModelName(), $route->getViewName(), $route->getControllerName());
    }

    /**
     * Create MVC objects.
     *
     * @throws Phoenix\Exceptions\FailureException
     * @param string $model_name
     *            fully namespaced model class name
     * @param string $view_name
     *            fully namespaced view class name
     * @param string $controller_name
     *            fully namespaced controller class name
     * @return void
     */
    private function createMvc($model_name, $view_name, $controller_name) {
        if (class_exists($model_name) && class_exists($view_name) && class_exists($controller_name)) {
            $this->model = new $model_name($this->db);
            $this->view = new $view_name($this->model, $this->request);
            $this->controller = new $controller_name($this->model, $this->request);
        } else {
            throw new FailureException(FrameworkExceptions::F_CLASS_NOT_FOUND, json_encode($this->request));
        }
    }

    /**
     * Perform action on this controller.
     *
     * @throws Phoenix\Exceptions\WarningException
     * @return void
     */
    private function performControllerAction() {
        $route_name = $this->request->getUrl()->getQueryParameter("route");
        $action_name = $this->request->getUrl()->getQueryParameter("action");
        if (System::isCallable($this->controller, $action_name)) {
            $this->controller->{$action_name}();
        } else {
            throw new WarningException(FrameworkExceptions::W_ACTION_IS_NOT_CALLABLE, json_encode($this->request));
        }
        
        // @todo
        if ($this->router->isRoute($route_name) === false) {
            throw new WarningException(FrameworkExceptions::W_ROUTER_INVALID_ROUTE, json_encode($this->request));
        }
    }

    /**
     * Perform action on this view.
     *
     * @throws Phoenix\Exceptions\WarningException
     * @return void
     */
    private function performViewAction() {
        /*
         * ($this->response == null) means that cotroller does not throw any exception and everything is ok
         *
         * ($this->response == Response && $this->response->getException() == NoticeException) means that controller
         * throws NoticeException
         *
         * it is possible to create new response with content only in situations mentioned above
         */
        $action_name = $this->request->getUrl()->getQueryParameter("action");
        if (is_null($this->response) || ($this->response instanceof Response && $this->response->getException() instanceof NoticeException)) {
            if (System::isCallable($this->view, $action_name)) {
                $old_exception = ($this->response instanceof Response && $this->response->getException() instanceof NoticeException) ? $this->response->getException() : null;
                $this->view->{$action_name}();
                $this->response = $this->view->getResponse();
                $this->response->setException($old_exception);
            } else {
                throw new WarningException(FrameworkExceptions::W_ACTION_IS_NOT_CALLABLE, json_encode($this->request));
            }
        }
    }
}
?>