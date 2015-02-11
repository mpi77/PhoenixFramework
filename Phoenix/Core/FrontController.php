<?php

/**
 * FrontController
 * 
 * @version 1.24
 * @author MPI
 * */
class FrontController {
    private $controller;
    private $view;
    private $db;
    private $response;
    private $args = array ();
    private $routeName;
    private $actionName;
    private $responseFormat;

    public function __construct(Database $db, $args = null) {
        $this->response = null;
        $this->args = $args;
        $this->args["GET"]["route"] = isset($this->args["GET"]["route"]) ? $this->args["GET"]["route"] : Router::DEFAULT_EMPTY_ROUTE;
        $this->args["GET"]["action"] = isset($this->args["GET"]["action"]) ? $this->args["GET"]["action"] : Router::DEFAULT_EMPTY_ACTION;
        $this->args["GET"]["format"] = (isset($this->args["GET"]["format"]) && Response::isValidResponseFormat($this->args["GET"]["format"])) ? $this->args["GET"]["format"] : Response::RESPONSE_HTML;
        $this->routeName = $this->args["GET"]["route"];
        $this->actionName = $this->args["GET"]["action"];
        $this->responseFormat = $this->args["GET"]["format"];
        
        try {
            if (!($db instanceof Database) || $db->getStatus() !== true) {
                throw new FailureException(FailureException::F_UNABLE_CONNECT_DB);
            }
            $this->db = $db;
            $this->dispatch();
        } catch (NoticeException $e) {
            $this->response = Response::responseFactory($this->responseFormat);
            $this->response->setException($e);
        } catch (WarningException $e) {
            Logger::log($e, $this->db);
            $this->response = Response::responseFactory($this->responseFormat);
            $this->response->setException($e);
        } catch (FailureException $e) {
            Logger::log($e);
            $this->response = Response::responseFactory($this->responseFormat);
            $this->response->setException($e);
        } catch (Exception $e) {
            Logger::log($e);
            $this->response = Response::responseFactory($this->responseFormat);
            $this->response->setException($e);
        }
    }

    public function __destruct() {
        if (!empty($this->db)) {
            $this->db = null;
        }
    }

    /**
     * Dispatch user request.
     *
     * @throws WarningException
     */
    private function dispatch() {
        // if route is invalid, redirect to index
        if (Router::isRoute($this->routeName) === false) {
            $this->routeName = Router::DEFAULT_EMPTY_ROUTE;
            $this->actionName = Router::DEFAULT_EMPTY_ACTION;
        }
        $route = Router::getRoute($this->routeName);
        if (!($route instanceof Route)) {
            throw new WarningException(WarningException::W_ROUTER_ROUTE_INVALID, json_encode($this->args));
        }
        $modelName = $route->getModelName();
        $controllerName = $route->getControllerName();
        $viewName = $route->getViewName();
        
        if (class_exists($modelName) && class_exists($controllerName) && class_exists($viewName)) {
            $model = new $modelName($this->db);
            $this->controller = new $controllerName($model, $this->args);
            $this->view = new $viewName($model, $this->args);
        } else {
            throw new WarningException(WarningException::W_CLASS_NOT_FOUND, json_encode($this->args));
        }
        
        if (!(Router::getRoute($this->routeName)->isAction($this->actionName) === true && (Router::getRoute($this->routeName)->getAction($this->actionName) instanceof RouteAction))) {
            throw new WarningException(WarningException::W_ROUTER_ROUTE_ACTION_INVALID, json_encode($this->args));
        }
        if (System::isCallable($this->controller, Router::getRoute($this->routeName)->getAction($this->actionName)->getRunFunctionName()) === true) {
            $this->controller->{Router::getRoute($this->routeName)->getAction($this->actionName)->getRunFunctionName()}();
        } else {
            throw new WarningException(WarningException::W_ACTION_IS_NOT_CALLABLE, json_encode($this->args));
        }
        
        if (Router::isRoute($this->routeName) === false) {
            throw new WarningException(WarningException::W_INVALID_ROUTE, json_encode($this->args));
        }
    }

    /**
     * Generate application output.
     */
    public function output() {
        try {
            if (is_null($this->response) || ($this->response instanceof Response && $this->response->getException() instanceof NoticeException)) {
                if (System::isCallable($this->view, Router::getRoute($this->routeName)->getAction($this->actionName)->getRunFunctionName()) === true) {
                    $oldException = ($this->response instanceof Response && $this->response->getException() instanceof NoticeException) ? $this->response->getException() : null;
                    $this->response = $this->view->{Router::getRoute($this->routeName)->getAction($this->actionName)->getRunFunctionName()}();
                    $this->response->setException($oldException);
                } else {
                    throw new WarningException(WarningException::W_ACTION_IS_NOT_CALLABLE, json_encode($this->args));
                }
            }
        } catch (NoticeException $e) {
            $this->response = Response::responseFactory($this->responseFormat);
            $this->response->setException($e);
        } catch (WarningException $e) {
            Logger::log($e, $this->db);
            $this->response = Response::responseFactory($this->responseFormat);
            $this->response->setException($e);
        } catch (FailureException $e) {
            Logger::log($e);
            $this->response = Response::responseFactory($this->responseFormat);
            $this->response->setException($e);
        } catch (Exception $e) {
            Logger::log($e);
            $this->response = Response::responseFactory($this->responseFormat);
            $this->response->setException($e);
        }
        
        // send response
        if ($this->response instanceof Response) {
            $this->response->send();
            exit();
        }
    }
}
?>