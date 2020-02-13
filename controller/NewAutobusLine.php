<?php
    class NewAutobusLine extends Controller{
        private $autobusLine;

        public function index(){
            if(isset($_SESSION["id"])){
                Login::check_login();
                if(Login::$account->getAdmin() == 1){
                    if(isset($_POST["listOfSchedules"])){
                        $temp = json_decode($_POST["autobusLine"]);
                        $this->autobusLine = new AutobusLine($temp->Start, $temp->Stop);
                        $this->autobusLine->setAllLineStops($temp->Stops);
                        unset($temp);

                        $scheduleForward = [];
                        $scheduleBackward = [];
                        foreach ($_POST["listOfSchedules"] as $p){
                            if(($p["direction"]) == 0){
                                array_push($scheduleBackward, $p);
                            } else {
                                array_push($scheduleForward, $p);
                            }
                        }

                        $this->autobusLine->setScheduleForward($_POST["listOfSchedules"]);
                        
                        if(!empty($autobusLineId = AutobusLine::insertNewAutobusLine($this->autobusLine))){
                            $this->autobusLine->setId($autobusLineId);
                            StopsLine::insertNewAutobusLineStops($this->autobusLine);
                            SingleSchedule::insertNewAutobusSchedule($this->autobusLine);

                            header("Location: index.php?controller=Schedule&method=index");
                            die();

                        } else {
                            
                            header("Location: index.php?controller=Schedule&method=index&error=error has occured");
                            die();
                        }

                    } else if(isset($_POST["listOfStops"])){
                        $this->autobusLine = new AutobusLine($_POST["autobusLineStart"], $_POST["autobusLineStop"]);
                        $this->autobusLine->setAllLineStops($_POST["listOfStops"]);

                        $array = array("Start" => $this->autobusLine->getStart(), "Stop" => $this->autobusLine->getStop(), "Stops" => $this->autobusLine->getAllLineStops());
                        $array = (json_encode($array));

                        $this->load("headerAndFooterMain/header", "view");
                        $this->load("newAutobusLineSchedule", "view", array("accountName" => Login::$account->getAccountName(), "autobusLine" => $this->autobusLine, "array" => $array, "account" => Login::$account));
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
                    $this->load("newAutobusLine", "view", array("accountName" => Login::$account->getAccountName(), "stops" => $stopsArray, "account" => Login::$account));
                    $this->load("headerAndFooterMain/footer", "view");
                    die();
                }
                
                header("Location: index.php?controller=Schedule&method=index");
            } else {
                header("Location: index.php?controller=Schedule&method=index");
            }
        }
    }
?>