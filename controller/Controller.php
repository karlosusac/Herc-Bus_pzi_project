<?php
class Controller {
    //Statični atribut koji nam predstavlja bazu u query-ima
    protected static $database_instance;

    public static function init () {
        //Metoda za kreiranje atribut-a i spremamo bazu u njega
        Controller::$database_instance = Database::setInstance();
    }

    //Load metod-a koja sam služi za redirect-anje i slanje podataka po potrebi
    protected function load ($name, $type = "view", $data = array()){
        if ($type == "view") {
            extract($data);
            include("view/$name.php");
        } else {
            include("model/$name.php");
        }
    }

    public static function getLastInsertedId(){
        return self::$database_instance->getConnection()->lastInsertId();
    }

    public static function printRandomCrap(){
        print("Whoptie dooooo");
    }
}
Controller::init();