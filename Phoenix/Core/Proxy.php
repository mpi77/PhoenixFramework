<?php
namespace Phoenix\Core;

use \Exception;
use \Phoenix\Core\Config;
use \Phoenix\Core\Database;
use \Phoenix\Core\FrontController;
use \Phoenix\Dao\ProxyDao;
use \Phoenix\Exceptions\BaseException;
use \Phoenix\Exceptions\NoticeException;
use \Phoenix\Exceptions\WarningException;
use \Phoenix\Exceptions\FailureException;
use \Phoenix\Exceptions\FrameworkExceptions;
use \Phoenix\Http\Request;
use \Phoenix\Http\RequestFactory;
use \Phoenix\Http\Response;
use \Phoenix\Http\ResponseFactory;
use \Phoenix\Utils\Logger;
use \Phoenix\Utils\System;

/**
 * Proxy gateway
 * 
 * @version 1.25
 * @author MPI
 * */
class Proxy {
    
    /** @var Phoenix\Core\Database */
    private $db;
    
    /** @var Phoenix\Http\Request */
    private $request;
    
    /** @var Phoenix\Http\Response */
    private $response;
    
    /** @var string */
    private $response_format;
    
    /** @var Phoenix\Core\FrontController */
    private $front_controller;

    /**
     * Proxy constructor.
     * 
     * @return void
     */
    public function __construct() {
        $this->response = null;
    }

    /**
     * Proxy destructor.
     *
     * @return void
     */
    public function __destruct() {
        if (!empty($this->db)) {
            $this->db = null;
        }
    }
    
    /**
     * Run proxy. 
     * It resolves user request and sends response to user.
     *
     * @return void
     */
    public function run(){
        try {
            $this->request = RequestFactory::createRequest();
            $this->response_format = $this->request->getUrl()->getQueryParameter(FrontController::URL_GET_FORMAT);
        
            $this->db = new Database(Config::get(Config::KEY_DB_PRIMARY_POOL));
        
            $this->runProxy();
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
        
        // send response
        if ($this->response instanceof Response) {
            $this->response->send();
            exit();
        } else {
            System::redirect(Config::get(Config::KEY_SITE_FQDN) . Config::get(Config::KEY_SHUTDOWN_PAGE));
        }
    }
    
    /**
     * Run proxy detection.
     * 
     * @throws Phoenix\Exceptions\WarningException
     * @return void
     */
    private function runProxy() {
        if ($this->isFrontControllerRequest() === true) {
            $this->performFrontControllerRequest();
            return;
        }
    
        if ($this->isProxyRequest() === true) {
            $this->performProxyRequest();
        }
    }

    /**
     * Resolve request in FrontController.
     *
     * @return void
     */
    private function performFrontControllerRequest() {
        $this->front_controller = new FrontController($this->db, $this->request);
        $this->response = $this->front_controller->getResponse();
    }

    /**
     * Resolve proxy request.
     *
     * @todo cache
     * @todo file download + condition
     * @throws Phoenix\Exceptions\WarningException
     */
    private function performProxyRequest() {
        $token = $this->request->getUrl()->getQueryParameter(FrontController::URL_GET_TOKEN);
        
        // @todo load from cache
        
        // load from db
        $proxy_item = ProxyDao::getProxyItemByValidToken($this->db, $token);
        if ($proxy_item == Database::EMPTY_RESULT) {
            throw new WarningException(FrameworkExceptions::W_INVALID_TOKEN);
        }
        $proxy_item = $proxy_item[0];
        
        // detect type of request
        if (is_null($proxy_item->getRoute()) && is_null($proxy_item->getAction()) && !is_null($proxy_item->getData())) {
            // external link to redirect on (data=url)
            System::redirect($proxy_item->getData());
        } else if (!is_null($proxy_item->getRoute()) && !is_null($proxy_item->getAction())) {
            $config_route = Config::get(Config::KEY_APP_PROXY_FILE_ROUTE);
            $config_action = Config::get(Config::KEY_APP_PROXY_FILE_ACTION);
            if (!empty($config_route) && !empty($config_action) && $proxy_item->getRoute() == $config_route && $proxy_item->getAction() == $config_action && !is_null($proxy_item->getData())) {
                // @todo file download
            } else {
                // internal rewrite link to app (data=query string part of url saved as json)
                $_GET = array();
                $_GET[FrontController::URL_GET_ROUTE] = $proxy_item->getRoute();
                $_GET[FrontController::URL_GET_ACTION] = $proxy_item->getAction();
                $_GET[FrontController::URL_GET_FORMAT] = $$this->response_format;
                if (!is_null($proxy_item->getData())) {
                    // decode json data and put into GET
                    $_GET = array_merge($_GET, json_decode($proxy_item->getData(), true));
                }
                $this->request = RequestFactory::createRequest();
                $this->performFrontControllerRequest();
                return;
            }
        } else {
            throw new WarningException(FrameworkExceptions::W_INVALID_TOKEN);
        }
    }

    /**
     * Detect front controller request.
     * 
     * @return boolean
     */
    private function isFrontControllerRequest() {
        $route = $this->request->getUrl()->getQueryParameter(FrontController::URL_GET_ROUTE);
        $action = $this->request->getUrl()->getQueryParameter(FrontController::URL_GET_ACTION);
        $token = $this->request->getUrl()->getQueryParameter(FrontController::URL_GET_TOKEN);
        return ((empty($route) && empty($action) && empty($token)) || (!empty($route) && !empty($action)));
    }

    /**
     * Detect proxy request.
     * 
     * @return boolean
     */
    private function isProxyRequest() {
        $route = $this->request->getUrl()->getQueryParameter(FrontController::URL_GET_ROUTE);
        $action = $this->request->getUrl()->getQueryParameter(FrontController::URL_GET_ACTION);
        $token = $this->request->getUrl()->getQueryParameter(FrontController::URL_GET_TOKEN);
        return (empty($route) && empty($action) && !empty($token));
    }
}
?>