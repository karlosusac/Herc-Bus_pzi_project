<?php
    class BuyTicket extends Controller{

        public function index(){
            if(!(isset($_SESSION["id"]))){
                $this->load("headerAndFooterMain/header", "view");
                $this->load("login", "view", array("error" => "You need to log in order to buy a ticket."));
                $this->load("headerAndFooterMain/footer", "view");
            } else {
                Login::check_login();
                
                if(isset($_GET["schedule"]) && isset($_GET["destination"]) && isset($_GET["departure"]) && isset($_GET["autobusLine"])){
                    if(self::validateDirections($_GET["destination"], $_GET["departure"], $_GET["schedule"]) == false){
                        header("Location: index.php?controller=BuyTicket&method=index&error=Invalid inputs!");
                        die();

                    } else {                             
                        $temp = Schedule::getAllFromSchedule($_GET["schedule"]);
                        $schedule = new SingleSchedule($temp->start_time, $temp->stop_time, $temp->number_of_seats, $temp->direction, $temp->autobus_line_id);
                        unset($temp);
                        $schedule->setId($_GET["schedule"]);

                        $ticket = new Ticket(Login::decryptSessionId(), $schedule->getId(), $_GET["autobusLine"], $_GET["departure"], $_GET["destination"]);
                        
                        if(isset($_POST["date"])){
                            $date = date("Y-m-d");
                            $currentMonth = date("m", strtotime($date));
                            $nextMonth = date("m", strtotime($date. "+1 month"));
                            if($currentMonth == $nextMonth - 1){
                                $nextDate = date('Y-m-d', strtotime($date." +1 month"));
                            }else{
                                $nextDate = date('Y-m-d', strtotime("last day of next month", strtotime($date)));
                            }

                            $ticket->setValidDate($_POST["date"]);
                            if($ticket->getValidDate() <= $nextDate && ($ticket->getValidDate() >= date("Y-m-d") && $schedule->getStartTime() > date("H:i:s"))){
                                if((self::numOfResearvedTickets($ticket->getAutobusLineId(), $ticket->getValidDate())->count) < ($schedule->getNumberOfSeats())){
                                    if(self::makeTicket($ticket->getAccountId(), $ticket->getScheduleId(), $ticket->getDeparture(), $ticket->getDestination(), $ticket->getAutobusLineId(),  $ticket->getValidDate())){
                                        header("Location: index.php?controller=BuyTicket&method=index&success=Ticket researved!");
                                        die();
                                    } else {
                                        $errorMsg = "Purchase failed.";
                                        header("Location: index.php?controller=BuyTicket&method=index&error=Purchase failed.");
                                        die();
                                    }
                                } else {
                                    header("Location: index.php?controller=BuyTicket&method=index&error=Autobus is full.");
                                    die();
                                }
                            } else {
                                header("Location: index.php?controller=BuyTicket&method=index&error=Invalid date.");
                                die();
                            }
                        }

                        $ticket->setPrice(self::calculatePrice($ticket->getDestination(), $ticket->getDeparture()));

                        $this->load("headerAndFooterMain/header", "view");
                        $this->load("buyTicket", "view", array("accountName" => Login::$account->getAccountName(), "ticket" => $ticket));
                        $this->load("headerAndFooterMain/footer", "view");
                    }

                } elseif(isset($_GET["departure"]) && isset($_GET["destination"]) && isset($_GET["autobusLine"])){
                    
                    if(self::validateAutobusLine($_GET["autobusLine"], $_GET["destination"], $_GET["departure"], self::compareStops($_GET["destination"], $_GET["departure"])) == false){
                        
                        header("Location: index.php?controller=BuyTicket&method=index&error=Invalid autobusline or directions!");
                        die();

                    } else {

                    $schedule = Schedule::getAllSchedulesForASingleAutobusLine($_GET["autobusLine"], self::compareStops($_GET["destination"], $_GET["departure"]));

                    $this->load("headerAndFooterMain/header", "view");
                    $this->load("buyTicket", "view", array("accountName" => Login::$account->getAccountName(), "schedule" => $schedule));
                    $this->load("headerAndFooterMain/footer", "view");
                    die();

                     }

                } elseif(isset($_GET["destination"]) && isset($_GET["autobusLine"])){
                    if(self::validateStop($_GET["destination"])){
                        $stops = self::getRestOfStops($_GET["autobusLine"], $_GET["destination"]);

                        $this->load("headerAndFooterMain/header", "view");
                        $this->load("buyTicket", "view", array("accountName" => Login::$account->getAccountName(), "stops" => $stops));
                        $this->load("headerAndFooterMain/footer", "view");
                        die();
                    }
                    
                    //HERE
                } elseif(isset($_GET["autobusLine"])){
                    $stops = Schedule::getAllStopsForASingleAutobusLine($_GET["autobusLine"]);

                    $this->load("headerAndFooterMain/header", "view");
                    $this->load("buyTicket", "view", array("accountName" => Login::$account->getAccountName(), "stops" => $stops));
                    $this->load("headerAndFooterMain/footer", "view");
                    die();

                } else {
                    $this->load("headerAndFooterMain/header", "view");
                    $this->load("buyTicket", "view", array("accountName" => Login::$account->getAccountName(), "autobusLine" => self::getAllLines()));
                    $this->load("headerAndFooterMain/footer", "view");
                    die();
                }
            }
        }

        public static function getAllLines(){
            $query = self::$database_instance->getConnection()->prepare("SELECT *
                                                                        FROM autobus_line");
            $query->execute();
            
            $autobusLines = $query->fetchAll(PDO::FETCH_OBJ);

            foreach ($autobusLines as $autobusLine){
                $autobusLine->stops = Schedule::getAllStopsForASingleAutobusLine($autobusLine->ID);
                $autobusLine->scheduleForward = Schedule::getAllSchedulesForASingleAutobusLine($autobusLine->ID, 1);
                $autobusLine->scheduleBackwards = Schedule::getAllSchedulesForASingleAutobusLine($autobusLine->ID, 0);
            }

            return $autobusLines;
            
        }

        public static function getRestOfStops($autobusLine, $stopId){
            $query = self::$database_instance->getConnection()->prepare("SELECT s.name, s.zone, sl.position_order, sl.id
                                                                        FROM stops AS s
                                                                        INNER JOIN stops_line AS sl ON s.id = sl.stops_id
                                                                        WHERE sl.autobus_line_id = ? AND sl.id <> ?
                                                                        ORDER BY sl.position_order ASC");
            $query->execute([$autobusLine, $stopId]);
            
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        public static function compareStops($stop1Id, $stop2Id){
            $stop1 = self::getStopInfo($stop1Id);
            $stop2 = self::getStopInfo($stop2Id);

            if($stop1->position_order > $stop2->position_order){
                return 1;
            } else {
                return 0;
            }
        }

        public static function getStopInfo($stopsLineId){
            $query = self::$database_instance->getConnection()->prepare("SELECT s.name, s.zone, sl.position_order
                                                                        FROM stops AS s
                                                                        INNER JOIN stops_line AS sl ON s.id = sl.stops_id
                                                                        WHERE sl.id = ?");
            $query->execute([$stopsLineId]);
            return $query->fetch(PDO::FETCH_OBJ);
        }

        public static function validateDirections($dir1, $dir2, $scheduleId){
            $direction = self::compareStops($dir1, $dir2);

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

        public static function validateAutobusLine($autobusLine, $dir1, $dir2, $direction){
            $query = self::$database_instance->getConnection()->prepare("SELECT sl.id, sl.position_order
                                                                        FROM stops_line AS sl
                                                                        INNER JOIN autobus_line as al ON al.id = sl.autobus_line_id
                                                                        WHERE al.id = ?");
            $query->execute([$autobusLine]);
            $autobusLineStops = $query->fetchAll(PDO::FETCH_OBJ);

            foreach ($autobusLineStops as $autobusLineStop){
                if($autobusLineStop->id == $dir1){
                    $destination = $autobusLineStop;
                }

                if($autobusLineStop->id == $dir2){
                    $departure = $autobusLineStop;
                }
            }

            if(isset($destination) && isset($departure)){
                if($direction == 0){
                    if(intval($destination->position_order) < intval($departure->position_order)){
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    if(intval($destination->position_order) > intval($departure->position_order)){
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }

        }

        public static function validateStop($stopId){
            $query = self::$database_instance->getConnection()->prepare("SELECT id
                                                                        FROM stops_line
                                                                        WHERE id = ?");
            $query->execute([$stopId]);

            if(!empty($query->fetch(PDO::FETCH_OBJ))){
                return true;
            } else {
                return false;
            }
        }

        public static function makeTicket($accountId, $scheduleid, $departure, $destination, $autobusLineId, $date){

            $query = self::$database_instance->getConnection()->prepare("INSERT INTO ticket (id, purchased, account_id, schedule_id, autobusline_id, departure, destination, valid_date) VALUES (NULL, NOW(), ?, ?, ?, ?, ?, ?)");
            $query->execute([$accountId, $scheduleid, $autobusLineId, $departure, $destination, $date]);

            return true;
        }

        public static function calculatePrice($destinationId, $departureId){
            $destination = self::getStopInfo($destinationId);
            $departure = self::getStopInfo($departureId);

            $destinationZone = $destination->zone;
            $departureZone = $departure->zone;

            if($destinationZone > $departureZone){
                return (abs(intval($destinationZone) - intval($departureZone)) + 1);
            } elseif($destinationZone == $departureZone){
                return 1;
            } else {
                return (abs(intval($departureZone) - intval($destinationZone)) + 1);
            }
        }

        public static function numOfResearvedTickets($autobusLine, $validDate){
            $query = self::$database_instance->getConnection()->prepare("SELECT COUNT(*) AS count
                                                                        FROM ticket
                                                                        WHERE account_id = ? AND autobusline_id = ? AND valid_date = ?");
            $query->execute([Login::decryptSessionId(), intval($autobusLine), $validDate]);
            return $query->fetch(PDO::FETCH_OBJ);
        }
    }

?>