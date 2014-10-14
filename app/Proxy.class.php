<?php

/**
 * Proxy gateway
 * 
 * @version 1.2
 * @author MPI
 * */
class Proxy {
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
            exit();
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
            
            if (preg_match("/^htt(p|ps):\/\/.*/", $proxyItem[0]->getLink())) {
                // external link to redirect on
                System::redirect($proxyItem[0]->getLink());
            } else {
                // local file to output
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
    }

    private function isApp() {
        return (isset($_GET["route"]) && !empty($_GET["route"]) && isset($_GET["action"]) && !empty($_GET["action"]));
    }

    private function isLink() {
        return (!isset($_GET["route"]) && !isset($_GET["action"]) && isset($_GET["token"]) && !empty($_GET["token"]));
    }
}
?>