<?php

/**
 * Proxy gateway
 * 
 * @version 1.4
 * @author MPI
 * */
class Proxy {
    private $db;
    private $frontController;
    const FILE_DOWNLOAD_ROUTE = "file";
    const FILE_DOWNLOAD_ACTION = "download";

    public function __construct() {
        try {
            $this->db = new Database(Config::getDatabaseConnectionParams(Config::DB_DEFAULT_POOL));
            $this->runProxy();
        } catch (NoticeException $e) {
            System::redirect(Config::SITE_PATH . "404");
        } catch (WarningException $e) {
            Logger::saveWarning($this->db, $e);
            System::redirect(Config::SITE_PATH . "404");
        } catch (FailureException $e) {
            Logger::saveFailure($e);
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
        
        // TODO: ACL
        
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
        $this->frontController = new FrontController($this->db);
    }

    private function isApp() {
        return ((!isset($_GET["route"]) && !isset($_GET["action"]) && !isset($_GET["token"])) || (isset($_GET["route"]) && !empty($_GET["route"]) && isset($_GET["action"]) && !empty($_GET["action"])));
    }

    private function isLink() {
        return (!isset($_GET["route"]) && !isset($_GET["action"]) && isset($_GET["token"]) && !empty($_GET["token"]));
    }
}
?>