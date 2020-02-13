<?php
    class ActiveTickets extends Controller{
        public function index(){
            Login::check_login();

            if(isset($_SESSION["id"])){

                $tickets = Ticket::getAllUserTickets();

                $this->load("headerAndFooterMain/header", "view");
                $this->load("headerAndFooterMain/footer", "view");
                $this->load("activeTickets", "view", array("account" => Login::$account, "tickets" => $tickets));
                die();
            }
        }
    }


?>