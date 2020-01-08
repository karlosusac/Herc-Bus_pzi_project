<?php
    class NewAutobusLine extends Controller{
        private static $autobusLine;


        public function index(){
            Login::check_login();
            if(Login::$account->getAdmin() == 1){
                if(isset($_POST["listOfSchedules"])){
                    
                    foreach ($_POST["listOfSchedules"] as $p){
                        var_dump($p);
                    }
                    die();

                } else if(isset($_POST["listOfStops"])){
                    self::$autobusLine = new AutobusLine($_POST["autobusLineStart"], $_POST["autobusLineStop"]);
                    $stopsArray = [];

                    foreach ($_POST["listOfStops"] as $stop){
                        $temp = Stop::getStopInfoFromStopId($stop);

                        array_push($stopsArray, $temp);
                    }
                    self::$autobusLine->setAllLineStops($stopsArray);

                    /*Radi :DDD! - Služi samo za provjeru podataka
                    print(self::$autobusLine->getStart());
                    print(self::$autobusLine->getStop());

                    foreach(self::$autobusLine->getAllLineStops() as $s){
                        print($s->name);
                    }
                    die();
                    */

                    $this->load("headerAndFooterMain/header", "view");
                    $this->load("newAutobusLineSchedule", "view", array("accountName" => Login::$account->getAccountName(), "autobusLine" => self::$autobusLine));
                    $this->load("headerAndFooterMain/footer", "view");
                    die();

                }
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

                $this->load("headerAndFooterMain/header", "view");
                $this->load("newAutobusLine", "view", array("accountName" => Login::$account->getAccountName(), "stops" => $stopsArray));
                $this->load("headerAndFooterMain/footer", "view");
                die();
            }
            
            header("Location: index.php?controller=Schedule&method=index");
        }
    }
?>