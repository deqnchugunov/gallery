<?php

class BaseModel {

    private static $connection = null;
    protected $db_connection = null;

    public function __construct() {
        if (self::$connection == null) {
            $config = Config::getInstance();
            self::$connection = new mysqli($config->getConfig('db_host'), $config->getConfig('db_user'), $config->getConfig('db_pass'), $config->getConfig('db_database'), $config->getConfig('db_port'));
            if (self::$connection->connect_error) {
                die('Connection Error');
            }
            self::$connection->set_charset("utf8");
        }
        mb_internal_encoding('utf-8');
        $this->db_connection = self::$connection;
    }

}
