<?php
    class Frontpage extends Controller{
        
        public function index(){
            $stopsArray = [];

            $temp = Stop::getAllStops();
            foreach($temp as $t){
                //Zbog nekog razloga konstruktor ne radi???
                //$temp2 = new Stop($t->name, $t->zone);
                $temp2 = new Stop;
                $temp2->setName($t->name);
                $temp2->setZone($t->zone);
                $temp2->setId($t->id);
    
                array_push($stopsArray, $temp2);
            }
            unset($temp);
            unset($temp2);

            //Ako je sessija postavljena i u njoj se nalazi ID, dohvati korisnika koje je logiran te to primjeni u navbar (imamo opcije 
            //logiranog korisnika kod dropdown menu-a)
            if(isset($_SESSION["id"])){
                //Metoda koja dekodira kriptirani id te kreira korisnika iz njega i sprema ga u statičnu varijablu
                Login::check_login();
    
                //Load metode kojim učitavamo header,footer i željeni content, te također proslijeđivamo informacije o user-u
                $this->load("headerAndFooterMain/header", "view");
                $this->load("frontpage", "view", array("accountName" => Login::$account->getAccountName(), "stops" => $stopsArray));
                $this->load("headerAndFooterMain/footer", "view");
            } else {
                $this->load("headerAndFooterMain/header", "view");
                $this->load("frontpage", "view", array("stops" => $stopsArray));
                $this->load("headerAndFooterMain/footer", "view");
            }
        }

        public function logout(){
            Login::logout();
            header("Location: index.php");
        }
    }
?>