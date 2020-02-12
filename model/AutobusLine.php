<?php
    class AutobusLine extends Controller{
        private $_id;
        private $_start;
        private $_stop;

        private $_allLineStops;
        private $_scheduleForward;
        private $_scheduleBackward;

        public function __construct($start, $stop){
            $this->_start = $start;
            $this->_stop = $stop;
        }

        //GETTERS

        public function getId(){
            return $this->_id;
        }

        public function getStart(){
            return $this->_start;
        }

        public function getStop(){
            return $this->_stop;
        }

        public function getAllLineStops(){
            return $this->_allLineStops;
        }

        public function getScheduleForward(){
            return $this->_scheduleForward;
        }

        public function getScheduleBackward(){
            return $this->_scheduleBackward;
        }
        //----------------------------

        //SETTERS

        public function setId($id){
            $this->_id = $id;
        }

        public function setStart($start){
            $this->_start = $start;
        }

        public function setStop($stop){
            $this->_stop = $stop;
        }

        public function setAllLineStops($stops){
            $this->_allLineStops = $stops;
        }

        public function setScheduleForward($sf){
            $this->_scheduleForward = $sf;
        }

        public function setScheduleBackward($sb){
            $this->_scheduleBackward = $sb;
        }
        //----------------------------

        //CUSTOM

        //Dohvaća sve postojuće linije
        public static function getAllLines(){
            $autobusLines = [];
            
            $query = self::$database_instance->getConnection()->prepare("SELECT *
                                                                        FROM autobus_line");
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);

            foreach($results as $result){
                $autobusLine = new AutobusLine($result->start, $result->stop);
                $autobusLine->setId($result->ID);
                
                $autobusLine->setAllLineStops(StopsLine::getAllStopsForASingleAutobusLine($autobusLine->getId()));
                $autobusLine->setScheduleForward(SingleSchedule::getAllSchedulesForASingleAutobusLine($autobusLine->getId(), 1));
                $autobusLine->setScheduleBackward(SingleSchedule::getAllSchedulesForASingleAutobusLine($autobusLine->getId(), 0));
                array_push($autobusLines, $autobusLine);
            }

            return $autobusLines;
        }

        public static function getAutobusLineWithId($autobusLineId){
            $query = self::$database_instance->getConnection()->prepare("SELECT *
                                                                        FROM autobus_line
                                                                        WHERE id = ?");
            $query->execute([$autobusLineId]);
            return $query->fetch(PDO::FETCH_OBJ);
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

                $autobusLine->setAllLineStops(StopsLine::getAllStopsForASingleAutobusLine($autobusLine->getId()));
                $autobusLine->setScheduleForward(SingleSchedule::getAllSchedulesForASingleAutobusLine($autobusLine->getId(), 1));
                $autobusLine->setScheduleBackward(SingleSchedule::getAllSchedulesForASingleAutobusLine($autobusLine->getId(), 0));
                
                //Pronalazi trenutnu vožnji i sprema te podatke
                //AutobusLine::checkIfDriveIsActive($autobusLine, $autobusLine->getScheduleForward(), 1);
                //AutobusLine::checkIfDriveIsActive($autobusLine, $autobusLine->getScheduleBackward(), 0);

                //$autobusLine->activeDrives = [];

                $autobusLine->activeDrives = AutobusLine::checkIfDrivesAreActive($autobusLine, $autobusLine->getScheduleForward(), 1);
                $autobusLine->activeDrives = array_merge($autobusLine->activeDrives, AutobusLine::checkIfDrivesAreActive($autobusLine, $autobusLine->getScheduleBackward(), 0));
                
                return $autobusLine;
            } else {
                return false;
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

        public static function checkIfDrivesAreActive($autobusLine, $schedule, $direction){
            date_default_timezone_set("Europe/Sarajevo");
            $timeNow = date( "H:i:s", time());

            $listOfAllActiveDrives = [];

            foreach ($schedule as $s){
                if($s->start_time < $timeNow && $s->stop_time > $timeNow){
                    $activeDrive = array("startTime" => $s->start_time, "stopTime" => $s->stop_time, "direction" => $direction);

                    array_push($listOfAllActiveDrives, $activeDrive);
                }
            }

            return $listOfAllActiveDrives;
        }

        //Ubacuje novi autobus line sa podacima koji su dani u "NewAutobusLineSchedule"
        public static function insertNewAutobusLine($autobusLine){
            $query = self::$database_instance->getConnection()->prepare("INSERT INTO autobus_line (id, start, stop) VALUES (NULL, ?, ?)");
            $query->execute([$autobusLine->getStart(), $autobusLine->getStop()]);

            return $autobusLineId = self::getLastInsertedId();
        }

        //Edit-a autobusnu liniju sa prosljeđenim podacima
        public static function editAutobusLine($stopsArray, $scheduleArray, $autobusLineId, $autobusLineStart, $autobusLineStop){
            $query = self::$database_instance->getConnection()->prepare("DELETE FROM schedule
                                                        WHERE autobus_line_id = ?");
            $query->execute([$autobusLineId]);

            foreach($scheduleArray as $sa){
                $startTime = $sa["startTime"];
                $stopTime = $sa["stopTime"];
                $numberOfSeats = $sa["numberOfSeats"];
                $direction = $sa["direction"];

                $query = self::$database_instance->getConnection()->prepare("INSERT INTO schedule (id, start_time, stop_time, number_of_seats, direction, autobus_line_id) VALUES (NULL, time(?), time(?), ?, ?, ?)");
                $query->execute([$startTime, $stopTime, intval($numberOfSeats), intval($direction), intval($autobusLineId)]);
            }

            $query = self::$database_instance->getConnection()->prepare("DELETE FROM stops_line
                                                        WHERE autobus_line_id = ?");
            $query->execute([$autobusLineId]);

            $counter = 0;
            foreach($stopsArray as $stopId){
                $query = self::$database_instance->getConnection()->prepare("INSERT INTO stops_line (id, position_order, stops_id, autobus_line_id) VALUES (NULL, ?, ?, ?)");
                $query->execute([$counter, intval($stopId), intval($autobusLineId)]);
                
                $counter++;
            }

            $query = self::$database_instance->getConnection()->prepare("UPDATE autobus_line SET start = ?,stop = ?
                                                                        WHERE id = ?");
            $query->execute([trim($autobusLineStart), trim($autobusLineStop), $autobusLineId]);

            return true;
        }

        //Provjerava dali postoji autobuska linija u bazi
        public static function checkIfAutobusLineExists($autobusLineId){
            $query = self::$database_instance->getConnection()->prepare("SELECT *
                                                                    FROM autobus_line
                                                                    WHERE id = ?");
            $query->execute([$autobusLineId]);
            if(!empty($query->fetch(PDO::FETCH_OBJ))){
                return true;
            } else {
                return false;
            }
        }
    }

?>