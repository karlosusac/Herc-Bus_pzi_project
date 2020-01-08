<?php
    class Schedule extends Controller{

        public function index(){

            if(isset($_SESSION["id"])){
                Login::check_login();

                $this->load("headerAndFooterMain/header", "view");
                $this->load("schedule", "view", array("accountName" => Login::$account->getAccountName(), "admin" => Login::$account->getAdmin(), "autobusLine" => AutobusLine::getAllLines()));
                $this->load("headerAndFooterMain/footer", "view");
            } else {

                $this->load("headerAndFooterMain/header", "view");
                $this->load("schedule", "view", array("autobusLine" => AutobusLine::getAllLines()));
                $this->load("headerAndFooterMain/footer", "view");
            }
        }

        public function logout(){
            Login::logout();
            header("Location: index.php?controller=Schedule&method=index");
        }
    }

?>