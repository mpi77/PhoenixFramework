<?php
/**
 * Internal log entity.
 *
 * @version 1.4
 * @author MPI
 * */
class InternalLogEntity extends Entity {
    private $id;
    private $ts_insert;
    private $class;
    private $code;
    private $stack;
    private $message;
    
    public function __construct() {
        parent::__construct();
    }

    public function __toString() {
        return "InternalLogEntity{id=" . $this->id . ", ts_insert=" . $this->ts_insert . ", code=" . $this->code . ", class=" . $this->class . ", message=" . $this->message . "}";
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getTsInsert(){
        return $this->ts_insert;
    }
    
    public function getClass(){
        return $this->class;
    }
    
    public function getCode(){
        return $this->code;
    }
    
    public function getStack(){
        return $this->stack;
    }
    
    public function getMessage(){
        return $this->message;
    }

    public static function insertRecord(Database $db, $class, $code, $stack, $message = null) {
        $query = "INSERT INTO log_internal (id, ts_insert, class, code, stack, message) VALUES (default, default, :class, :code, :stack, :message)";
        $queryArgs = array (
                        ":class" => $class,
                        ":code" => $code,
                        ":stack" => $stack,
                        ":message" => $message
        );
        return $db->actionQuery($query, $queryArgs);
    }
}
?>