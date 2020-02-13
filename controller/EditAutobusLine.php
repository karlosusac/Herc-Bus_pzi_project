<?php
    class EditAutobusLine extends Controller{
        private $_autobusLine; 


        public function index(){
            if(isset($_SESSION["id"])){
                Login::check_login();
                if(Login::$account->getAdmin() == 1){
                    if(isset($_POST["editAutobusLineSchedules"]) && isset($_POST["editAutobusLineStops"]) && isset($_POST["autobusLineId"]) && isset($_POST["autobusLineStart"]) && isset($_POST["autobusLineStop"])){
                

                        if(AutobusLine::editAutobusLine($_POST["editAutobusLineStops"], $_POST["editAutobusLineSchedules"], json_decode($_POST["autobusLineId"])->id, $_POST["autobusLineStart"], $_POST["autobusLineStop"])){
                            header("Location: index.php?controller=Schedule&method=index&success=Successfully updated!");
                        } else {
                            header("Location: index.php?controller=Schedule&method=index&error=Updating failed!");
                        }

                        die();
                    
                    } else if(!empty($temp = AutobusLine::getAutobusLineWithId($_GET["autobusLineId"]))){
                        $this->_autobusLine = new AutobusLine($temp->start, $temp->stop);
                        $this->_autobusLine->setId($_GET["autobusLineId"]);

                        $this->_autobusLine->setAllLineStops(StopsLine::getAllStopsForASingleAutobusLineOrderedByPositionOrder($this->_autobusLine->getId()));
                        
                        $this->_autobusLine->setScheduleForward(SingleSchedule::getAllSchedulesForASingleAutobusLine($this->_autobusLine->getId(), 1));
                        $this->_autobusLine->setScheduleBackward(SingleSchedule::getAllSchedulesForASingleAutobusLine($this->_autobusLine->getId(), 0));
                        
                        $stopsArray = [];
                        $autobusLineArray = [];

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

                        $autobusLineArray = array("id" => $this->_autobusLine->getId());
                        $autobusLineArray = (json_encode($autobusLineArray));

                        $this->load("headerAndFooterMain/header", "view");
                        $this->load("editAutobusLine", "view", array("accountName" => Login::$account->getAccountName(), "autobusLine" => $this->_autobusLine, "stops" => $stopsArray, "autobusLineId" => $autobusLineArray, "account" => Login::$account));
                        $this->load("headerAndFooterMain/footer", "view");
                        die();
                    }
                }
            }

            header("Location:index.php?controller=Schedule&method=index");
         }

        //Brisanje autobusne linije
        public function deleteAutobusLine(){
            if(isset($_SESSION["id"])){
                Login::check_login();$query = self::$database_instance->getConnection()->prepare("DELETE FROM autobus_line
                                                                                    WHERE id = ?");
                if(Login::$account->getAdmin() == 1){
                    if($autobusLine = AutobusLine::checkIfAutobusLineExists($_GET["autobusLineId"])){
                        
                        $query->execute([intval($_GET["autobusLineId"])]);
                        header("Location: index.php?controller=Schedule&method=index&success=Successfully deleted!");
                    } else {
                        header("Location: index.php?controller=Schedule&method=index&error=Deletion failed!");
                    }
                }
            }
            
        }
    }
?>