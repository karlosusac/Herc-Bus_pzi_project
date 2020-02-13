<?php
    class ChangePassword extends Controller{
        public static $account;
            public function index(){
                Login::check_login();

            if(isset($_SESSION["id"])){
                $this->load("headerAndFooterMain/header", "view");
                $this->load("changePassword", "view", array("account" => Login::$account));
                $this->load("headerAndFooterMain/footer", "view");
                die();
            }
            }

    }


?>