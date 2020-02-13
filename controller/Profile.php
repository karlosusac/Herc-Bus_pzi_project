<?php
    class Profile extends Controller{

        public function index(){
            Login::check_login();

            if(isset($_SESSION["id"])){
                $this->load("headerAndFooterMain/header", "view");
                $this->load("headerAndFooterMain/footer", "view");
                $this->load("profile", "view", array("account" => Login::$account, "account" => Login::$account));
                
                die();
            }
            Account::areEmailAndUsernameOccupied($_POST["chngEmail"], $_POST["chngUserName"]);

          
        }
    }
   

?>




