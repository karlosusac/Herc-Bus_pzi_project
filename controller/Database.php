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

        //Set connection with the database, if database is not set, call the constructor and set it
        //and return the the instance, if it is already set, just return in
        public static function setInstance(){
            if(!isset($_instance)){
                self::$_instance = new Database;
            }

            return self::$_instance;
        }

        //Return database connection, this is needed in all the query-s
        public function getConnection(){
            return $this->_connection;
        }
    }

?>