<?php

/**
 * FrontController
 * 
 * @version 1.11
 * @author MPI
 * */
class FrontController {
    private $controller;
    private $view;
    private $db;
    private $args = array ();

    public function __construct(Database $db, $args = null) {
        try {
            if ($db->getStatus() !== true) {
                throw new FailureException(FailureException::FAILURE_UNABLE_CONNECT_DB);
            }
            $this->db = $db;
            $this->args = $args;
            System::setViewEnabled();
            System::clearException();
        } catch (FailureException $e) {
            Logger::log($e);
            System::redirect(Config::SITE_PATH . Config::SHUTDOWN_PAGE);
        }
        
        $this->dispatch();
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
        $routeName = isset($this->args["GET"]["route"]) ? $this->args["GET"]["route"] : Router::DEFAULT_EMPTY_ROUTE;
        $actionName = isset($this->args["GET"]["action"]) ? $this->args["GET"]["action"] : Router::DEFAULT_EMPTY_ACTION;
        
        try {
            // if route is invalid, redirect to index
            if (Router::isRoute($routeName) === false) {
                $routeName = Router::DEFAULT_EMPTY_ROUTE;
                $actionName = Router::DEFAULT_EMPTY_ACTION;
            }
            $route = Router::getRoute($routeName);
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
            
            if (Router::getRoute($routeName)->isAction($actionName) === true && System::isCallable($this->controller, Router::getRoute($routeName)->getAction($actionName)->getRunFunctionName()) === true) {
                $this->controller->{Router::getRoute($routeName)->getAction($actionName)->getRunFunctionName()}();
            } else {
                throw new WarningException(WarningException::WARNING_ACTION_IS_NOT_CALLABLE, json_encode($this->args));
            }
            
            if (Router::isRoute($routeName) === false) {
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
     * Generate HTML output.
     */
    public function output() {
        try {
            System::makeExceptionCont();
            if (!empty($this->view) && System::isViewEnabled()) {
                $this->view->outputHtml();
            } else {
                echo "<div class=\"page-header\">&nbsp;</div>";
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
        }
    }
}
?>