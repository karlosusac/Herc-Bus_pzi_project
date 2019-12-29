<?php
    class Database {
        private static $_instance;
        private $_connection;

        //Privatni konstruktor za bazu u kojem koristimo naše konstante iz config file-a
        private function __construct (){
            $this->_connection = new PDO("mysql:host=". DB_HOST. ";dbname=". DB_DATABASE, DB_USER, DB_PASS);
            $this->_connection->setAttribute(
                PDO::ATTR_ERRMODE, 
                PDO::ERRMODE_EXCEPTION
            );
        }

        //Singleton za kreiranje instance baze, ako je paza postavljena vrati je u suprotnom je napravi tako što pozovemo konstruktor pa je onda vratimo
        public static function setInstance(){
            if(!isset($_instance)){
                self::$_instance = new Database;
            }

            return self::$_instance;
        }

        //Metoda koja vraća vezu sa bazom, potrebno u query-ima
        public function getConnection(){
            return $this->_connection;
        }
    }

?>