<?php

/**
 * Proxy gateway
 * 
 * @version 1.1
 * @author MPI
 * */
class Proxy {

    public function __construct() {
        $this->runProxyDetection();
    }

    public function __destruct() {
    }
    
    private function runProxyDetection(){
        if($this->isApp() === true){
            return;
        } 
        
        if($this->isLink() === true){
            // not implemented yet
            exit();
        }
    }
    
    private function isApp(){
        return (isset($_GET["route"]) && !empty($_GET["route"]) && isset($_GET["action"]) && !empty($_GET["action"]));
    }
    
    private function isLink(){
        return (!isset($_GET["route"]) && !isset($_GET["action"]) && isset($_GET["token"]) && !empty($_GET["token"]));
    }
}
?>