<?php

class View {

    private static $instance = null;
    private $data = array();

    private function __construct() {
        
    }

    public function render($template, $data = array()) {
        if (is_array($data)) {
            extract($data);
        }
        include './views/' . $template . '.php';
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new View();
        }
        return self::$instance;
    }

}
