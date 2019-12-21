<?php
class Controller {
    protected static $database_instance;

    public static function init () {
        Controller::$database_instance = Database::setInstance();
    }

    protected function load ($name, $type = "view", $data = array()){
        if ($type == "view") {
            extract($data);
            include("view/$name.php");
        } else {
            include("model/$name.php");
        }

    }
}
Controller::init();