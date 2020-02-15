<?php
    class ChangePassword extends Controller{
        public static $account;
            public function index(){

                if(isset($_SESSION["id"])){
                    Login::check_login();

                    $this->load("headerAndFooterMain/header", "view");
                    $this->load("headerAndFooterMain/footer", "view");
                    $this->load("changePassword", "view", array("account" => Login::$account));
                    die();
                } else {
                    header("Location: index.php?controller=Frontpage&method=index");
                }
            }

            public function changeAccountPassword(){
                Login::check_login();

                if(isset($_SESSION["id"])){
                    $_POST["password"] = str_replace(' ', '', $_POST["password"]);
                    $_POST["conPassword"] = str_replace(' ', '', $_POST["conPassword"]);
                    $_POST["oldPassword"] = str_replace(' ', '', $_POST["oldPassword"]);

                    if($_POST["oldPassword"] == Login::$account->getPassword()){
                        if($_POST["password"] == $_POST["conPassword"]){
                            if(Account::updateAccountPassword($_POST["password"])){
                                header("Location: index.php?controller=Profile&method=index&success=Password successfully updated");
                            } else {
                                header("Location: index.php?controller=Profile&method=index&error=Error has occured");                                
                            }
                        } else {
                            header("Location: index.php?controller=Profile&method=index&error=Passwords do not match");
                        }
                    } else {
                        header("Location: index.php?controller=Profile&method=index&error=Incorrect password");
                    }
                } else {
                    header("Location: index.php?controller=Frontpage&method=index");
                }
            }
    }


?>