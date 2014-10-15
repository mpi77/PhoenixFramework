<?php

/**
 * Proxy gateway
 * 
 * @version 1.3
 * @author MPI
 * */
class Proxy {
    const FILE_DOWNLOAD_ROUTE = "file";
    const FILE_DOWNLOAD_ACTION = "download";
    private $db;

    public function __construct() {
        $this->runProxyDetection();
    }

    public function __destruct() {
    }

    private function runProxyDetection() {
        if ($this->isApp() === true) {
            return;
        }
        
        if ($this->isLink() === true) {
            $this->linkProcess();
        }
    }

    private function linkProcess() {
        try {
            $this->db = new Database(Config::getDatabaseConnectionParams(Config::DB_DEFAULT_POOL));
            $proxyItem = ProxyEntity::getProxyItemByValidToken($this->db, $_GET["token"]);
            if ($proxyItem == Database::EMPTY_RESULT) {
                throw new NoticeException(NoticeException::NOTICE_INVALID_TOKEN);
            }
            // TODO: ACL
            
            if (is_null($proxyItem[0]->getRoute()) && is_null($proxyItem[0]->getAction()) && !is_null($proxyItem[0]->getLink())) {
                // external link to redirect on
                System::redirect($proxyItem[0]->getLink());
            } else if (!is_null($proxyItem[0]->getRoute()) && !is_null($proxyItem[0]->getAction()) && is_null($proxyItem[0]->getLink())) {
                // internal rewrite link to app
                $_GET["route"] = $proxyItem[0]->getRoute();
                $_GET["action"] = $proxyItem[0]->getAction();
                return;
            } else if ($proxyItem[0]->getRoute() == self::FILE_DOWNLOAD_ROUTE && $proxyItem[0]->getAction() == self::FILE_DOWNLOAD_ACTION && !is_null($proxyItem[0]->getLink())) {
                // file download
            } else {
                throw new NoticeException(NoticeException::NOTICE_INVALID_TOKEN);
            }
        } catch (NoticeException $e) {
            header("Location: " . Config::SITE_PATH . "404");
            exit();
        } catch (WarningException $e) {
            Logger::saveWarning($this->db, $e);
            header("Location: " . Config::SITE_PATH . "404");
            exit();
        } catch (FailureException $e) {
            Logger::saveFailure($e);
            header("Location: " . Config::SITE_PATH . "500");
            exit();
        }
        exit();
    }

    private function isApp() {
        return (isset($_GET["route"]) && !empty($_GET["route"]) && isset($_GET["action"]) && !empty($_GET["action"]));
    }

    private function isLink() {
        return (!isset($_GET["route"]) && !isset($_GET["action"]) && isset($_GET["token"]) && !empty($_GET["token"]));
    }
}
?>