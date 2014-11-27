<?php
/**
 * User entity.
 *
 * @version 1.1
 * @author MPI
 * */
class UserEntity extends Entity {
    private $uid;
    private $email;
    private $password;
    private $type;
    private $status;
    private $first_name;
    private $last_name;
    private $phone;
    private $ts_insert;
    private $ts_last_login;
    private $renew_token;
    private $renew_valid_to;
    private $language;
    
    public function __construct() {
        parent::__construct();
    }

    public function __toString() {
        return "UserEntity{uid=" . $this->uid . ", email=" . $this->email . ", password=" . $this->password . ", type=" . $this->type . ", status=" . $this->status . "}";
    }
    
    public function getUid(){
        return $this->uid;
    }
    
    public function getEmail(){
        return $this->email;
    }
    
    public function getPassword(){
        return $this->password;
    }
    
    public function getType(){
        return $this->type;
    }
    
    public function getStatus(){
        return $this->status;
    }
    
    public function getFirstName(){
        return $this->first_name;
    }
    
    public function getLastName(){
        return $this->last_name;
    }
    
    public function getPhone(){
        return $this->phone;
    }
    
    public function getTsInsert(){
        return $this->ts_insert;
    }
    
    public function getLastLogin(){
        return $this->ts_last_login;
    }
    
    public function getRenewToken(){
        return $this->renew_token;
    }
    
    public function getRenewValidTo(){
        return $this->renew_valid_to;
    }
    
    public function getLanguage(){
        return $this->language;
    }
}
?>