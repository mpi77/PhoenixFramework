<?php

/**
 * Root template data object.
 *
 * @version 1.8
 * @author MPI
 * */
class TemplateData {
    const NOT_FOUND = null;
    private $data;

    public function __construct($data = null) {
        if (is_null($data)) {
            $this->data = array ();
        } else {
            $this->data = $data;
        }
    }

    /**
     * Get value from this template object.
     *
     * @param string $key
     *            if key is NULL, all data will be returned
     *            
     * @return mixed
     */
    public function get($key = null) {
        if (is_null($key)) {
            return $this->data;
        } else {
            if (is_string($key) && array_key_exists($key, $this->data)) {
                return $this->data[$key];
            } else {
                return self::NOT_FOUND;
            }
        }
    }

    /**
     * Get all values from this template object.
     *
     * @return mixed
     */
    public function getAll() {
        return $this->get();
    }

    /**
     * Set value into this template object.
     *
     * @param string $key            
     * @param mixed $value            
     */
    public function set($key, $value) {
        if (!empty($key) && is_string($key)) {
            $this->data[$key] = $value;
        }
    }

    /**
     * Checks if this template object has given key.
     *
     * @param string $key            
     *
     * @return boolean
     */
    public function has($key) {
        return (is_string($key) ? array_key_exists($key, $this->data) : false);
    }

    /**
     * Print htmlspecialchars(string) from template object.
     *
     * @param string $key            
     */
    public function es($key) {
        $this->e($key, true);
    }

    /**
     * Print string from template object.
     *
     * @param string $key            
     * @param boolean $enableHtmlspecialchars
     *            default false
     */
    public function e($key, $enableHtmlspecialchars = false) {
        if (is_string($key) && array_key_exists($key, $this->data) && is_string($this->data[$key])) {
            echo ($enableHtmlspecialchars === true) ? htmlspecialchars($this->data[$key]) : $this->data[$key];
        }
    }
}
?>