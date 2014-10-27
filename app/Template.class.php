<?php

/**
 * Root template object.
 *
 * @version 1.1
 * @author MPI
 * */
class Template {
    const NOT_FOUND = null;
    
    private $data;

    public function __construct($data = null) {
        if (is_null($data)) {
            $this->data = array ();
        } else {
            $this->data = $data;
        }
    }
    
    public function get($key){
        if(array_key_exists($key, $this->data)){
            return $this->data[$key];
        } else{
            return self::NOT_FOUND;
        }
    }
    
    public function set($key, $value){
        $this->data[$key] = $value;
    }
}
?>