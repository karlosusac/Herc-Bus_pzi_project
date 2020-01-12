<?php
    class SingleSchedule extends Controller{
        private $_id;
        private $_startTime;
        private $_stopTime;
        private $_numberOfSeats;
        private $_direction;
        private $_autobusLineId;
    

        public function __construct ($startTime, $stopTime, $numberOfSeats, $direction, $autobusLineId){
            $this->_startTime = $startTime;
            $this->_stopTime = $stopTime;
            $this->_numberOfSeats = $numberOfSeats;
            $this->_direction = $direction;
            $this->_autobusLineId = $autobusLineId;
        }

        // GETTERS
        public function getId(){
            return $this->_id;
        }

        public function getStartTime(){
            return $this->_startTime;
        }

        public function getStopTime(){
            return $this->__stopTime;
        }

        public function getNumberOfSeats(){
            return $this->_numberOfSeats;
        }

        public function getDirection(){
            return $this->_direction;
        }

        public function getAutobusLineId(){
            return $this->_password;
        }
        //------------------------------

        //SETTERS
        public function setId($id) {
            $this->_id = $id;
        }

        public function setStartTime($startTime) {
            $this->_startTime = $startTime;
        }

        public function setStopTime($stopTime) {
            $this->_stopTime = $stopTime;
        }

        public function setNumberOfSeats($numberOfSeats) {
            $this->_numberOfSeats = $numberOfSeats;
        }

        public function setDirection($numberOfSeats) {
            $this->_numberOfSeats = $numberOfSeats;
        }

        public function setAutobusLineId($autobusLineId) {
            $this->_autobusLineId = $autobusLineId;
        }

        //CUSTOM

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

        //Dohvati sav raspored vožnji (schedule) od autobusne linije čiji id proslijedimo i od smijera kojeg proslijedimo
        public static function getAllSchedulesForASingleAutobusLine($id, $direction){
            $query = self::$database_instance->getConnection()->prepare("SELECT *
                                                                        FROM schedule
                                                                        WHERE autobus_line_id = ? AND direction = ?
                                                                        ORDER BY start_time ASC");
            $query->execute([$id, $direction]);
            $schedule = $query->fetchAll(PDO::FETCH_OBJ);

            return ($schedule);                                                    
        }

        //Dohvaća sve iz jednog rasporeda vožnje za koji id mi proslijedimo
        public static function getAllFromSchedule($scheduleId){
            $query = self::$database_instance->getConnection()->prepare("SELECT *
                                                                        FROM schedule
                                                                        WHERE id = ?");
            $query->execute([$scheduleId]);
            return $query->fetch(PDO::FETCH_OBJ);
        }

        //Validificira da unesena vožnja postoji za unesene stanice
        public static function validateSchedule($dir1, $dir2, $scheduleId){
            $direction = StopsLine::compareStops($dir1, $dir2);

            $query = self::$database_instance->getConnection()->prepare("SELECT start_time
                                                                        FROM schedule
                                                                        WHERE id = ?");
            $query->execute([$scheduleId]);
            $schedule = $query->fetch();

            $query = self::$database_instance->getConnection()->prepare("SELECT sc.start_time
                                                                        FROM schedule AS sc
                                                                        INNER JOIN autobus_line AS al ON al.id = sc.autobus_line_id
                                                                        INNER JOIN stops_line AS sl ON al.ID = sl.autobus_line_id 
                                                                        WHERE (sc.direction LIKE ?) AND (sl.id LIKE ?)");
            $query->execute([$direction, $dir1]);
            $scheduleTimes = $query->fetchAll();

            if(in_array($schedule, $scheduleTimes)){
                return true;
            } else {
                return false;
            }
        }

        public static function insertNewAutobusSchedule($autobusLine){
            foreach ($autobusLine->getScheduleForward() as $schf){
                $query = self::$database_instance->getConnection()->prepare("INSERT INTO schedule (id, start_time, stop_time, number_of_seats, direction, autobus_line_id) VALUES (NULL, ?, ?, ?, ?, ?)");
                $query->execute([$schf["startTime"], $schf["stopTime"], $schf["numberOfSeats"], $schf["direction"], $autobusLine->getId()]);
            }
        }

    }   


?>