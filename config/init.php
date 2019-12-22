<?php

    //Database info
    define("DB_HOST", "127.0.0.1");
    define("DB_USER", "root");
    define("DB_PASS", "");
    define("DB_DATABASE", "herc-bus_database");

    // -------------------------- Gibs an error for some reason when called, need to look into it --------------------------
    //Path to the root of the server folder
    $rootPath = substr(__DIR__, 0, -7);

    //Autoload classes when they are called in the program
    spl_autoload_register(function($class){
        if(file_exists("controller/". $class. ".php")){
            require_once ("controller/". $class. ".php");

        }elseif(file_exists("model/". $class. ".php")){
            require_once ("model/". $class. ".php");

        }
    });
?>