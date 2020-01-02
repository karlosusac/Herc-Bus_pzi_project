<?php
    class Schedule extends Controller{

        public function index(){

            if(isset($_SESSION["id"])){
                Login::check_login();

                $this->load("headerAndFooterMain/header", "view");
                $this->load("schedule", "view", array("accountName" => Login::$account->getAccountName(), "admin" => Login::$account->getAdmin(), "autobusLine" => self::getAllLines()));
                $this->load("headerAndFooterMain/footer", "view");
            } else {

                $this->load("headerAndFooterMain/header", "view");
                $this->load("schedule", "view", array("autobusLine" => self::getAllLines()));
                $this->load("headerAndFooterMain/footer", "view");
            }
        }

        public function logout(){
            Login::logout();
            header("Location: index.php?controller=Schedule&method=index");
        }

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
                
                $autobusLine->setAllLineStops(Schedule::getAllStopsForASingleAutobusLine($autobusLine->getId()));
                $autobusLine->setScheduleForward(Schedule::getAllSchedulesForASingleAutobusLine($autobusLine->getId(), 1));
                $autobusLine->setScheduleBackward(Schedule::getAllSchedulesForASingleAutobusLine($autobusLine->getId(), 0));
                array_push($autobusLines, $autobusLine);
            }

            return $autobusLines;
        }

        //Dohvati sve stanice od autobusne linije čiji id proslijedimo
        public static function getAllStopsForASingleAutobusLine($autobusLineId){
            $query = self::$database_instance->getConnection()->prepare("SELECT s.name, sl.id
                                                                        FROM stops AS s
                                                                        INNER JOIN stops_line AS sl ON s.id = sl.stops_id
                                                                        WHERE sl.autobus_line_id = ?");
            $query->execute([$autobusLineId]);
            $stops = $query->fetchAll(PDO::FETCH_OBJ);

            return ($stops);
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
    }

?>