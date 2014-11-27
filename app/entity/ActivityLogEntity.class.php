<?php
/**
 * Activity log entity.
 *
 * @version 1.1
 * @author MPI
 * */
class ActivityLogEntity extends Entity {
    private $id;
    private $user_uid;
    private $message;
    private $ts_insert;
    
    public function __construct() {
        parent::__construct();
    }

    public function __toString() {
        return "ActivityLogEntity{id=" . $this->id . ", ts_insert=" . $this->ts_insert . ", user_uid=" . $this->user_uid . ", message=" . $this->message . "}";
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getTsInsert(){
        return $this->ts_insert;
    }
    
    public function getUserUid(){
        return $this->user_uid;
    }
    
    public function getMessage(){
        return $this->message;
    }

    public static function insertRecord(Database $db, $user_uid, $message) {
        $query = "INSERT INTO log_activity (id, ts_insert, user_uid, message) VALUES (default, NOW(), :user_uid, :message)";
        $queryArgs = array (
                        ":user_uid" => $user_uid,
                        ":message" => $message
        );
        return $db->actionQuery($query, $queryArgs);
    }
}
?>