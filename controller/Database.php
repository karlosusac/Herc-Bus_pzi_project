<?php
    class Database {
        private static $_instance;
        private $_connection;

        private function __construct (){

            $this->_connection = new PDO("mysql:host=". DB_HOST. ";dbname=". DB_DATABASE, DB_USER, DB_PASS);
            $this->_connection->setAttribute(
                PDO::ATTR_ERRMODE, 
                PDO::ERRMODE_EXCEPTION
            );
        }

        public static function setInstance(){
            if(!isset($_instance)){
                self::$_instance = new Database;
            }

            return self::$_instance;
        }

        public function getConnection(){
            return $this->_connection;
        }
    }

?>