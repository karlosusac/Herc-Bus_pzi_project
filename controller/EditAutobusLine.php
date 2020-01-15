<?php
    class EditAutobusLine extends Controller{
        private $_autobusLine; 


        public function index(){
            if(isset($_SESSION["id"])){
                Login::check_login();
                if(Login::$account->getAdmin() == 1){
                    if(!empty($temp = AutobusLine::getAutobusLineWithId($_GET["autobusLineId"]))){
                        $this->_autobusLine = new AutobusLine($temp->start, $temp->stop);
                        $this->_autobusLine->setId($_GET["autobusLineId"]);

                        $this->_autobusLine->setAllLineStops(StopsLine::getAllStopsForASingleAutobusLineOrderedByPositionOrder($this->_autobusLine->getId()));
                        
                        $this->_autobusLine->setScheduleForward(SingleSchedule::getAllSchedulesForASingleAutobusLine($this->_autobusLine->getId(), 1));
                        $this->_autobusLine->setScheduleBackward(SingleSchedule::getAllSchedulesForASingleAutobusLine($this->_autobusLine->getId(), 0));
                        
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
                        $this->load("editAutobusLine", "view", array("accountName" => Login::$account->getAccountName(), "autobusLine" => $this->_autobusLine, "stops" => $stopsArray));
                        $this->load("headerAndFooterMain/footer", "view");
                        die();
                    }
                }
            }

            header("Location:index.php?controller=Schedule&method=index");
         }
    }
?>