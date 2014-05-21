<?php

class Config {

    private static $instance = null;
    private $data = array();

    private function __construct() {
        include './config/database.php';
        $this->data = $cnf;
    }

    public function getConfig($key) {
        return $this->data[$key];
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Config();
        }
        return self::$instance;
    }

}
