<?php
    class Frontpage extends Controller{
        
        public function index(){
            //Ako je sessija postavljena i u njoj se nalazi ID, dohvati korisnika koje je logiran te to primjeni u navbar (imamo opcije 
            //logiranog korisnika kod dropdown menu-a)
            if(isset($_SESSION["id"])){
                //Metoda koja dekodira kriptirani id te kreira korisnika iz njega i sprema ga u statičnu varijablu
                Login::check_login();
    
                //Load metode kojim učitavamo header,footer i željeni content, te također proslijeđivamo informacije o user-u
                $this->load("headerAndFooterMain/header", "view");
                $this->load("frontpage", "view", array("accountName" => Login::$account->getAccountName()));
                $this->load("headerAndFooterMain/footer", "view");
            } else {
                $this->load("headerAndFooterMain/header", "view");
                $this->load("frontpage", "view");
                $this->load("headerAndFooterMain/footer", "view");
            }
        }

        public function logout(){
            Login::logout();
            header("Location: index.php");
        }
    }
?>