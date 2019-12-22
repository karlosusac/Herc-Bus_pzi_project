<?php require_once ("config/init.php");

$controller = isset($_GET["controller"]) ? $_GET["controller"] : "login";
$method = isset($_GET["method"]) ? $_GET["method"] : "index";

include ("controller/$controller.php");
$object = new $controller();
$object->$method();