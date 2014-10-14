<?php
/**
 * Proxy entity.
 *
 * @version 1.1
 * @author MPI
 * */
class ProxyEntity extends Entity {
    
    private $id;
    private $token;
    private $valid_from;
    private $valid_to;
    private $link;
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
        return "ProxyEntity{id=" + $this->id + ", token=" + $this->token + "}";
    }
}
?>