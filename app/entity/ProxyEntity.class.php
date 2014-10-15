<?php
/**
 * Proxy entity.
 *
 * @version 1.3
 * @author MPI
 * */
class ProxyEntity extends Entity {
    private $id;
    private $token;
    private $valid_from;
    private $valid_to;
    private $link;
    private $route;
    private $action;
    private $only_authenticated;
    private $only_uid;
    private $only_gid;

    public function __construct() {
        parent::__construct();
    }

    public function getName() {
        return get_class($this);
    }

    public function __toString() {
        return "ProxyEntity{id=" . $this->id . ", token=" . $this->token . "}";
    }

    public function getId() {
        return $this->id;
    }
    
    public function getToken(){
        return $this->token;
    }
    
    public function getValidFrom(){
        return $this->valid_from;
    }
    
    public function getValidTo(){
        return $this->valid_to;
    }
    
    public function getLink(){
        return $this->link;
    }
    
    public function getRoute(){
        return $this->route;
    }
    
    public function getAction(){
        return $this->action;
    }
    
    public function getOnlyAuthenticated(){
        return $this->only_authenticated;
    }
    
    public function getOnlyUid(){
        return $this->only_uid;
    }
    
    public function getOnlyGid(){
        return $this->only_gid;
    }

    public static function getProxyItemByValidToken(Database $db, $token) {
        $query = "SELECT id, token, valid_from, valid_to, link, route, action, only_authenticated, only_uid, only_gid FROM proxy WHERE (token=:token AND valid_from<=NOW() AND (valid_to IS NULL OR valid_to>NOW()))";
        $queryArgs = array (
                        ":token" => $token 
        );
        $fetchArgs = array (
                        "type" => PDO::FETCH_CLASS,
                        "className" => "ProxyEntity" 
        );
        return $db->selectQuery($query, $queryArgs, $fetchArgs);
    }
}
?>