<?php
/**
 * Proxy entity.
 *
 * @version 1.0
 * @author MPI
 * */
class ProxyEntity extends Entity {
    
    public function __construct() {
        parent::__construct();
    }

    public function getName() {
        return get_class($this);
    }

    public function __toString() {
        return "ProxyEntity{not implemented yet}";
    }
}
?>