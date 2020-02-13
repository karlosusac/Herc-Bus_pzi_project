<?php
    class SingleLineSchedule extends Controller{
        
        public function index(){
            if(isset($_GET["autobusLine"])){
                if($autobusLine = AutobusLine::getCurrentlyActiveDrive($_GET["autobusLine"])){ 
                    if ($autobusLine->nextDrive = SingleSchedule::getNextScheduledDrive($_GET["autobusLine"]));

                    if(isset($_SESSION["id"])){
                        Login::check_login();
            
                        $this->load("headerAndFooterMain/header", "view");
                        $this->load("singleLineSchedule", "view", array("accountName" => Login::$account->getAccountName(), "autobusLine" => $autobusLine, "account" => Login::$account));
                        $this->load("headerAndFooterMain/footer", "view");
                        die();
                    } else {
                        $this->load("headerAndFooterMain/header", "view");
                        $this->load("singleLineSchedule", "view", array("autobusLine" => $autobusLine));
                        $this->load("headerAndFooterMain/footer", "view");
                        die();
                    } 
                }  
            }
            header("Location: index.php?controller=Schedule&method=index");
        }

        public function logout(){
            Login::logout();
            header("index.php?controller=SingleLineSchedule&method=index&autobusLineId=". print($_GET["autobusLine"]));
        }
    }
?>