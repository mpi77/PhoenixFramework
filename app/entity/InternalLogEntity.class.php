<?php
/**
 * Internal log entity.
 *
 * @version 1.2
 * @author MPI
 * */
class InternalLogEntity extends Entity {
    private $id;
    private $ts_insert;
    private $class;
    private $code;
    private $stack;
    
    public function __construct() {
        parent::__construct();
    }

    public function getName() {
        return get_class($this);
    }

    public function __toString() {
        return "InternalLogEntity{id=" . $this->id . ", ts_insert=" . $this->ts_insert . ", code=" . $this->code . ", class=" . $this->class . "}";
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

    public static function insertRecord(Database $db, $class, $code, $stack) {
        $query = "INSERT INTO log_internal (id, ts_insert, class, code, stack) VALUES (default, default, :class, :code, :stack)";
        $queryArgs = array (
                        ":class" => $class,
                        ":code" => $code,
                        ":stack" => $stack 
        );
        return $db->actionQuery($query, $queryArgs);
    }
}
?>