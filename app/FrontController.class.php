<?php

/**
 * FrontController
 * 
 * @version 1.13
 * @author MPI
 * */
class FrontController {
    private $controller;
    private $view;
    private $db;
    private $args = array ();
    private $routeName;
    private $actionName;

    public function __construct(Database $db, $args = null) {
        try {
            if ($db->getStatus() !== true) {
                throw new FailureException(FailureException::FAILURE_UNABLE_CONNECT_DB);
            }
            $this->db = $db;
            $this->args = $args;
            System::setViewEnabled();
            System::clearException();
            $this->dispatch();
        } catch (FailureException $e) {
            Logger::log($e);
            System::redirect(Config::SITE_PATH . Config::SHUTDOWN_PAGE);
        } catch (Exception $e) {
            Logger::log($e);
            System::redirect(Config::SITE_PATH . Config::SHUTDOWN_PAGE);
        }
    }

    public function __destruct() {
        if (!empty($this->db)) {
            $this->db = null;
        }
        System::setViewEnabled();
        System::clearException();
    }

    /**
     * Dispatch user request.
     */
    private function dispatch() {
        $this->routeName = isset($this->args["GET"]["route"]) ? $this->args["GET"]["route"] : Router::DEFAULT_EMPTY_ROUTE;
        $this->actionName = isset($this->args["GET"]["action"]) ? $this->args["GET"]["action"] : Router::DEFAULT_EMPTY_ACTION;
        
        try {
            // if route is invalid, redirect to index
            if (Router::isRoute($this->routeName) === false) {
                $this->routeName = Router::DEFAULT_EMPTY_ROUTE;
                $this->actionName = Router::DEFAULT_EMPTY_ACTION;
            }
            $route = Router::getRoute($this->routeName);
            if (!($route instanceof Route)) {
                throw new WarningException(WarningException::WARNING_ROUTER_ROUTE_INVALID, json_encode($this->args));
            }
            $modelName = $route->getModelName();
            $controllerName = $route->getControllerName();
            $viewName = $route->getViewName();
            
            if (class_exists($modelName) && class_exists($controllerName) && class_exists($viewName)) {
                $model = new $modelName($this->db);
                $this->controller = new $controllerName($model, $this->args);
                $this->view = new $viewName($model, $this->args);
            } else {
                throw new WarningException(WarningException::WARNING_CLASS_NOT_FOUND, json_encode($this->args));
            }
            
            if (!(Router::getRoute($this->routeName)->isAction($this->actionName) === true && (Router::getRoute($this->routeName)->getAction($this->actionName) instanceof RouteAction))) {
                throw new WarningException(WarningException::WARNING_ROUTER_ROUTE_ACTION_INVALID, json_encode($this->args));
            }
            if (System::isCallable($this->controller, Router::getRoute($this->routeName)->getAction($this->actionName)->getRunFunctionName()) === true) {
                $this->controller->{Router::getRoute($this->routeName)->getAction($this->actionName)->getRunFunctionName()}();
            } else {
                throw new WarningException(WarningException::WARNING_ACTION_IS_NOT_CALLABLE, json_encode($this->args));
            }
            
            if (Router::isRoute($this->routeName) === false) {
                throw new WarningException(WarningException::WARNING_INVALID_ROUTE, json_encode($this->args));
            }
        } catch (NoticeException $e) {
            $_SESSION[Config::SERVER_FQDN]["exception"] = $e;
        } catch (WarningException $e) {
            Logger::log($e, $this->db);
            System::setViewDisabled();
            $_SESSION[Config::SERVER_FQDN]["exception"] = $e;
        } catch (FailureException $e) {
            Logger::log($e);
            System::redirect(Config::SITE_PATH . Config::SHUTDOWN_PAGE);
        }
    }

    /**
     * Generate output.
     */
    public function output() {
        $response = null;
        try {
            if (System::isCallable($this->view, Router::getRoute($this->routeName)->getAction($this->actionName)->getRunFunctionName()) === true) {
                $response = $this->view->{Router::getRoute($this->routeName)->getAction($this->actionName)->getRunFunctionName()}();
            } else {
                throw new WarningException(WarningException::WARNING_ACTION_IS_NOT_CALLABLE, json_encode($this->args));
            }
        } catch (NoticeException $e) {
            $_SESSION[Config::SERVER_FQDN]["exception"] = $e;
            System::makeExceptionCont();
        } catch (WarningException $e) {
            Logger::log($e, $this->db);
            $_SESSION[Config::SERVER_FQDN]["exception"] = $e;
            System::makeExceptionCont();
        } catch (FailureException $e) {
            Logger::log($e);
            System::redirect(Config::SITE_PATH . Config::SHUTDOWN_PAGE);
        } catch (Exception $e) {
            Logger::log($e);
            System::redirect(Config::SITE_PATH . Config::SHUTDOWN_PAGE);
        }
        $response->send();
    }
}
?>