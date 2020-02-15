<?php

    //Singleton za sesiju, ako sesija nije postavljena, postavi je
    if(!(isset($_SESSION))){
        session_start();
    }

    //Konstante (podaci) koji se koriste prilikom spajanja sa bazom podataka
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "");
    define("DB_DATABASE", "fpmoz032019");

    // -------------------------- Gibs an error for some reason when called, need to look into it --------------------------
    //Absolute path do folder-a ali nije baš praktično za koristiti, moguće da je završtiti u smeću
    $rootPath = substr(__DIR__, 0, -7);

    //SPL_AUTOLOADER - Služi za automacko pozivanje klasa. Ako u nekom file-u pozovemo neku drugu klasu sa ovim nam ne treba include ili require
    spl_autoload_register(function($class){
        if(file_exists("controller/". $class. ".php")){
            require_once ("controller/". $class. ".php");

        }elseif(file_exists("model/". $class. ".php")){
            require_once ("model/". $class. ".php");

        }
    });
?>