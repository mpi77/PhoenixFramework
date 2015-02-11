<?php
/**
 * Ucr Dao.
 *
 * @version 1.2
 * @author MPI
 * */
class UcrDao extends Dao {
    private $id;
    private $email;
    private $token;
    private $user_type;
    private $valid_to;
    
    public function __construct() {
        parent::__construct();
    }

    public function __toString() {
        return "UcrDao{id=" . $this->id . ", email=" . $this->email . ", token=" . $this->token . ", user_type=" . $this->user_type . ", valid_to=" . $this->valid_to . "}";
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getEmail(){
        return $this->email;
    }
    
    public function getToken(){
        return $this->token;
    }
    
    public function getUserType(){
        return $this->user_type;
    }
    
    public function getValidTo(){
        return $this->valid_to;
    }
}
?>