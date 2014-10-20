<?php

/**
 * FrontController
 * 
 * @version 1.9
 * @author MPI
 * */
class FrontController {
    private $controller;
    private $view;
    private $router;
    private $db;
    private $args = array ();

    public function __construct(Database $db, $args = null) {
        try {
            if ($db->getStatus() !== true) {
                throw new FailureException(FailureException::FAILURE_UNABLE_CONNECT_DB);
            }
            $this->db = $db;
            $this->args = $args;
            $this->router = new Router();
            $this->router->addRoute("default", "IndexController", "IndexView", "IndexModel");
            $this->router->addRoute("user", "UserController", "UserView", "UserModel");
            
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
        $route_name = isset($this->args["GET"]["route"]) ? $this->args["GET"]["route"] : "default";
        $action_name = isset($this->args["GET"]["action"]) ? $this->args["GET"]["action"] : "index";
        
        try {
            // if route is invalid, redirect to index (route=default, action=index)
            if ($this->router->isRoute($route_name) === false) {
                $action_name = "index";
            }
            $route = $this->router->getRoute($route_name);
            $model_name = $route->getModelName();
            $controller_name = $route->getControllerName();
            $view_name = $route->getViewName();
            
            // var_dump($model_name . " " . $controller_name . " " . $view_name . " " . $action_name);
            
            if (class_exists($model_name) && class_exists($controller_name) && class_exists($view_name)) {
                $model = new $model_name($this->db);
                $this->controller = new $controller_name($model, $this->args);
                $this->view = new $view_name($model, $this->args);
            } else {
                throw new WarningException(WarningException::WARNING_CLASS_NOT_FOUND, json_encode($this->args));
            }
            
            if (System::isCallable($this->controller, $action_name) === true) {
                $this->controller->{$action_name}();
            } else {
                throw new WarningException(WarningException::WARNING_ACTION_IS_NOT_CALLABLE, json_encode($this->args));
            }
            
            if ($this->router->isRoute($route_name) === false) {
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