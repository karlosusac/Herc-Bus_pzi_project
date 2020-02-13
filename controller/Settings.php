<?php
    class Settings extends Controller{

        public function index(){
            Login::check_login();

            if(isset($_SESSION["id"])){
                $this->load("headerAndFooterMain/header", "view");
                $this->load("settings", "view", array("account" => Login::$account));
                $this->load("headerAndFooterMain/footer", "view");
                die();
            }
        }

        public function changeUserInfo(){
            if(isset($_POST["chngUserName"]) && isset($_POST["chngFirstName"]) && isset($_POST["chngLastName"]) && isset($_POST["chngEmail"]) && isset($_POST["chngPassword"])){
                Login::check_login();

                
                if($_POST["chngPassword"] == Login::$account->getPassword()){
                    if(!($_POST["chngUserName"] == "") && !($_POST["chngFirstName"] == "") && !($_POST["chngLastName"] == "") && !($_POST["chngEmail"] == "")){
                        
                        if(Account::areEmailAndUsernameOccupied($_POST["chngEmail"], $_POST["chngUserName"])){
                            header("Location: index.php?controller=Profile&method=index&success=Account successfully updated!");
                            
                        } else {
                            header("Location: index.php?controller=Frontpage&method=index");
                            
                        }
                    }
                } else {
                    header("Location: index.php?controller=Settings&method=index&error=Incorrect password");
                }
                
            }
            
        }
    }

?>




