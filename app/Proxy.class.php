<?php

/**
 * Proxy gateway
 * 
 * @version 1.20
 * @author MPI
 * */
class Proxy {
    private $db;
    private $args;
    private $frontController;
    private $response;
    private $responseFormat;
    const FILE_DOWNLOAD_ROUTE = "file";
    const FILE_DOWNLOAD_ACTION = "download";

    public function __construct() {
        try {
            $this->response = null;
            $this->args["GET"] = System::trimSlashMultidimAssocArray($_GET);
            $this->args["POST"] = System::trimSlashMultidimAssocArray($_POST);
            $this->args["GET"]["route"] = isset($this->args["GET"]["route"]) ? $this->args["GET"]["route"] : Router::DEFAULT_EMPTY_ROUTE;
            $this->args["GET"]["action"] = isset($this->args["GET"]["action"]) ? $this->args["GET"]["action"] : Router::DEFAULT_EMPTY_ACTION;
            $this->args["GET"]["format"] = (isset($this->args["GET"]["format"]) && Response::isValidResponseFormat($this->args["GET"]["format"])) ? $this->args["GET"]["format"] : Response::RESPONSE_HTML;
            $this->responseFormat = $this->args["GET"]["format"];
            
            $this->db = new Database(Config::getDatabaseConnectionParams(Config::DB_DEFAULT_POOL));
            
            $this->runProxy();
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
        
        // send response with exception
        if ($this->response instanceof Response) {
            $this->response->send();
            exit();
        }
    }

    public function __destruct() {
        if (!empty($this->db)) {
            $this->db = null;
        }
    }

    public function getFrontController() {
        return $this->frontController;
    }

    private function runProxy() {
        if ($this->isApp() === true) {
            $this->createAppFrontController();
            return;
        }
        
        if ($this->isLink() === true) {
            $this->linkProcess();
        }
    }

    private function linkProcess() {
        $proxyItem = ProxyEntity::getProxyItemByValidToken($this->db, $_GET["token"]);
        if ($proxyItem == Database::EMPTY_RESULT) {
            throw new WarningException(WarningException::W_INVALID_TOKEN);
        }
        $proxyItem = $proxyItem[0];
        
        // check ACL conditions
        if ($proxyItem->getOnlyAuthenticated() == Config::SET && Acl::isLoggedin() !== true) {
            // need to login before continue
            System::redirect(Config::SITE_PATH . "user/login/?r=" . $proxyItem->getToken());
        }
        if (!is_null($proxyItem->getOnlyUid()) && $_SESSION[Config::SERVER_FQDN]["user"]["uid"] != $proxyItem->getOnlyUid()) {
            // user is blocked
            throw new WarningException(WarningException::W_PERMISSION_DENIED);
        }
        if (!is_null($proxyItem->getOnlyGid()) && !in_array($proxyItem->getOnlyGid(), $_SESSION[Config::SERVER_FQDN]["user"]["gid"])) {
            // user has not membership in allowed group
            throw new WarningException(WarningException::W_PERMISSION_DENIED);
        }
        
        // detect type of request
        if (is_null($proxyItem->getRoute()) && is_null($proxyItem->getAction()) && !is_null($proxyItem->getData())) {
            // external link to redirect on (data=url)
            System::redirect($proxyItem->getData());
        } else if (!is_null($proxyItem->getRoute()) && !is_null($proxyItem->getAction())) {
            if ($proxyItem->getRoute() == self::FILE_DOWNLOAD_ROUTE && $proxyItem->getAction() == self::FILE_DOWNLOAD_ACTION && !is_null($proxyItem->getData())) {
                // file download
                // TODO
                exit();
            } else {
                // internal rewrite link to app (data=query string part of url saved as json)
                $_GET["route"] = $proxyItem->getRoute();
                $_GET["action"] = $proxyItem->getAction();
                if (!is_null($proxyItem->getData())) {
                    // decode json data and put into GET
                    $_GET = array_merge($_GET, json_decode($proxyItem->getData(), true));
                }
                $this->args["GET"] = System::trimSlashMultidimAssocArray($_GET);
                $this->createAppFrontController();
                return;
            }
        } else {
            throw new WarningException(WarningException::W_INVALID_TOKEN);
        }
    }

    private function createAppFrontController() {
        $this->frontController = new FrontController($this->db, $this->args);
    }

    private function isApp() {
        return ((!isset($_GET["route"]) && !isset($_GET["action"]) && !isset($_GET["token"])) || (isset($_GET["route"]) && !empty($_GET["route"]) && isset($_GET["action"]) && !empty($_GET["action"])));
    }

    private function isLink() {
        return (!isset($_GET["route"]) && !isset($_GET["action"]) && isset($_GET["token"]) && !empty($_GET["token"]));
    }
}
?>