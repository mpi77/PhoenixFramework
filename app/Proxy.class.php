<?php

/**
 * Proxy gateway
 * 
 * @version 1.8
 * @author MPI
 * */
class Proxy {
    private $db;
    private $args;
    private $frontController;
    const FILE_DOWNLOAD_ROUTE = "file";
    const FILE_DOWNLOAD_ACTION = "download";

    public function __construct() {
        try {
            $this->db = new Database(Config::getDatabaseConnectionParams(Config::DB_DEFAULT_POOL));
            
            // do not change (trim&slash) $_GET and $_POST
            $this->args["GET"] = System::trimSlashMultidimAssocArray($_GET, true, true, true, true);
            $this->args["POST"] = System::trimSlashMultidimAssocArray($_POST, true, true, true, true);
            
            $this->runProxy();
        } catch (NoticeException $e) {
            System::redirect(Config::SITE_PATH . "404");
        } catch (WarningException $e) {
            Logger::log($e, $this->db);
            System::redirect(Config::SITE_PATH . "404");
        } catch (FailureException $e) {
            Logger::log($e);
            System::redirect(Config::SITE_PATH . Config::SHUTDOWN_PAGE);
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
            throw new NoticeException(NoticeException::NOTICE_INVALID_TOKEN);
        }
        $proxyItem = $proxyItem[0];
        
        // check ACL conditions
        if ($proxyItem->getOnlyAuthenticated() == Config::SET && Acl::isLoggedin() !== true) {
            // need to login before continue
            System::redirect(Config::SITE_PATH . "user/login/?r=" . $proxyItem->getToken());
        }
        if (!is_null($proxyItem->getOnlyUid()) && $_SESSION[Config::SERVER_FQDN]["user"]["uid"] != $proxyItem->getOnlyUid()) {
            // user is blocked
            throw new NoticeException(NoticeException::NOTICE_PERMISSION_DENIED);
        }
        if (!is_null($proxyItem->getOnlyGid()) && !in_array($proxyItem->getOnlyGid(), $_SESSION[Config::SERVER_FQDN]["user"]["gid"])) {
            // user has not membership in allowed group
            throw new NoticeException(NoticeException::NOTICE_PERMISSION_DENIED);
        }
        
        // detect type of request
        if (is_null($proxyItem->getRoute()) && is_null($proxyItem->getAction()) && !is_null($proxyItem->getLink())) {
            // external link to redirect on
            System::redirect($proxyItem->getLink());
        } else if (!is_null($proxyItem->getRoute()) && !is_null($proxyItem->getAction()) && is_null($proxyItem->getLink())) {
            // internal rewrite link to app
            $_GET["route"] = $proxyItem->getRoute();
            $_GET["action"] = $proxyItem->getAction();
            $this->createAppFrontController();
            return;
        } else if ($proxyItem->getRoute() == self::FILE_DOWNLOAD_ROUTE && $proxyItem->getAction() == self::FILE_DOWNLOAD_ACTION && !is_null($proxyItem->getLink())) {
            // file download
            // TODO
            exit();
        } else {
            throw new NoticeException(NoticeException::NOTICE_INVALID_TOKEN);
        }
    }

    private function createAppFrontController() {
        header("Content-Type: text/html; charset=utf-8");
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