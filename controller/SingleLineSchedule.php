<?php
    class SingleLineSchedule extends Controller{
        
        public function index(){
            if(isset($_GET["autobusLine"])){
                if($autobusLine = self::getCurrentlyActiveDrive($_GET["autobusLine"])){ 
                    if ($autobusLine->nextDrive = self::getNextScheduledDrive($_GET["autobusLine"])){}

                    if(isset($_SESSION["id"])){
                        Login::check_login();
            
                        $this->load("headerAndFooterMain/header", "view");
                        $this->load("singleLineSchedule", "view", array("accountName" => Login::$account->getAccountName(), "autobusLine" => $autobusLine));
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

        //Vraća sve podatke o autobusnoj lini čiji id proslijedimo
        public static function getCurrentlyActiveDrive($autobusLineId){
            $query = self::$database_instance->getConnection()->prepare("SELECT *
                                                                        FROM autobus_line
                                                                        WHERE id = ?");
            $query->execute([$autobusLineId]);
            $result = $query->fetch(PDO::FETCH_OBJ);

            //Ako postoji autobusna linije onda ćemo u nju staviti sve stanice kojim autobus prolazi i cijeli raspored vožnje za 
            //tu liniju
            if(!empty($result)){
                $autobusLine = new AutobusLine($result->start, $result->stop);
                $autobusLine->setId($result->ID);

                $autobusLine->setAllLineStops(Schedule::getAllStopsForASingleAutobusLine($autobusLine->getId()));
                $autobusLine->setScheduleForward(Schedule::getAllSchedulesForASingleAutobusLine($autobusLine->getId(), 1));
                $autobusLine->setScheduleBackward(Schedule::getAllSchedulesForASingleAutobusLine($autobusLine->getId(), 0));
                
                //Pronalazi trenutnu vožnji i sprema te podatke
                self::checkIfDriveIsActive($autobusLine, $autobusLine->getScheduleForward(), 1);
                self::checkIfDriveIsActive($autobusLine, $autobusLine->getScheduleBackward(), 0);
                
                return $autobusLine;
            } else {
                return false;
            }
        }

        //Metoda za traženje dali postoji sljedeća vožnja za proslijeđeni id autobusne linije i trenutnog vremena, ako nema
        //vrati false ako ima nadodaj i trenutni datum na to vrijeme i vrati ga
        public static function getNextScheduledDrive($autobusLineId){
            date_default_timezone_set("Europe/Sarajevo");
            $timeNow = date( "H:i:s", time());
            $query = self::$database_instance->getConnection()->prepare("SELECT start_time
                                                                    FROM schedule
                                                                    WHERE autobus_line_id = ? AND start_time > ?
                                                                    ORDER BY start_time ASC
                                                                    LIMIT 1");
            $query->execute([$autobusLineId, $timeNow]);
            $schedule = $query->fetch(PDO::FETCH_OBJ);
            if(empty($schedule)){
                return false;
            } else {
                $date = date("Y-m-d");
                $dateWithTime = date( "Y-m-d H:i:s", strtotime("$date $schedule->start_time"));
                return ($dateWithTime);    
            }
        }

        //Metoda za dohvaćanje trenutnog datuma sa vremenom (korišteno samo za frontend)
        public static function getDateNow($time){
            $date = date("Y-m-d");
            return date( "Y-m-d H:i:s", strtotime("$date $time"));
        }

        //Sorry na glupom imenu bio je test, kod display-anja vožnji ova metoda će obojati vožnju koja se trenutno odvija drugačije
        //od ostalih, vema glup način ali radi... Potencijalni rework ali mi se ne da sa frontend-om baš zezati...
        public static function displayCorrectBtn($start, $stop){
            $timeNow = date("H:i:s");

            if($start < $timeNow && $stop > $timeNow){
                print("btn-primary");
            } else {
                print("btn-outline-primary");
            }
        }

        //Isto kao i gore samo služi za treženje SLJEDEĆE vožnje a ne trenutne
        public static function displayCorrectBtnForTheNextDrive($start, $autobusLineId){
            $timeNow = date("H:i:s");

            $query = self::$database_instance->getConnection()->prepare("SELECT start_time
                                                                        FROM schedule
                                                                        WHERE start_time >= ? AND autobus_line_id = ?
                                                                        ORDER BY start_time ASC");
            $query->execute([$timeNow, $autobusLineId]);
            $nextDrive = $query->fetch(PDO::FETCH_OBJ)->start_time;

            if($start == $nextDrive){
                print("btn-primary");
            } else {
                print("btn-outline-primary");
            }
        }

        //Vraća nam trenutnu vožnju
        public static function checkIfDriveIsActive($autobusLine, $schedule, $direction){
            date_default_timezone_set("Europe/Sarajevo");
            $timeNow = date( "H:i:s", time());

            foreach ($schedule as $s){
                if($s->start_time < $timeNow && $s->stop_time > $timeNow){
                    $autobusLine->startTime = $s->start_time;
                    $autobusLine->stopTime = $s->stop_time;
                    $autobusLine->direction = $direction;
                    break;
                }
            }

            return $autobusLine;
        }
    }
?>