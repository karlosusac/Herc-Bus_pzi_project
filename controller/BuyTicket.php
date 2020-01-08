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
                    if(SingleSchedule::validateSchedule($_GET["destination"], $_GET["departure"], $_GET["schedule"]) == false){
                        header("Location: index.php?controller=BuyTicket&method=index&error=Invalid inputs!");
                        die();

                    } else {                             
                        $temp = SingleSchedule::getAllFromSchedule($_GET["schedule"]);
                        $schedule = new SingleSchedule($temp->start_time, $temp->stop_time, $temp->number_of_seats, $temp->direction, $temp->autobus_line_id);
                        unset($temp);
                        $schedule->setId($_GET["schedule"]);

                        $ticket = new Ticket(Login::decryptSessionId(), $schedule->getId(), $_GET["autobusLine"], $_GET["departure"], $_GET["destination"]);
                        
                        if(isset($_POST["date"])){
                            $dateNow = date("Y-m-d");
                            $nextDate = date('Y-m-d', strtotime("last day of +2 month", strtotime($dateNow)));
                            
                            $date = $_POST["date"];
                            $time = $schedule->getStartTime();
                            $ticket->setValidDate(date('Y-m-d H:i:s', strtotime("$date $time")));

                            if($ticket->getValidDate() <= $nextDate && $ticket->getValidDate() >= date("Y-m-d H:i:s")){
                                if((self::numOfResearvedTickets($ticket->getAutobusLineId(), $ticket->getValidDate(), $ticket->getScheduleId())->count) < ($schedule->getNumberOfSeats())){
                                    if(self::makeTicket($ticket->getAccountId(), $ticket->getScheduleId(), $ticket->getDeparture(), $ticket->getDestination(), $ticket->getAutobusLineId(),  $ticket->getValidDate())){
                                        header("Location: index.php?controller=BuyTicket&method=index&success=Ticket researved!");
                                        die();
                                    } else {
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
                    
                    if(self::validateAutobusLine($_GET["autobusLine"], $_GET["destination"], $_GET["departure"], StopsLine::compareStops($_GET["destination"], $_GET["departure"])) == false){
                        
                        header("Location: index.php?controller=BuyTicket&method=index&error=Invalid autobusline or directions!");
                        die();

                    } else {

                    $schedule = SingleSchedule::getAllSchedulesForASingleAutobusLine($_GET["autobusLine"], StopsLine::compareStops($_GET["destination"], $_GET["departure"]));

                    $this->load("headerAndFooterMain/header", "view");
                    $this->load("buyTicket", "view", array("accountName" => Login::$account->getAccountName(), "schedule" => $schedule));
                    $this->load("headerAndFooterMain/footer", "view");
                    die();

                     }

                } elseif(isset($_GET["destination"]) && isset($_GET["autobusLine"])){
                    if(StopsLine::validateStop($_GET["destination"])){
                        $stops = StopsLine::getRestOfStops($_GET["autobusLine"], $_GET["destination"]);

                        $this->load("headerAndFooterMain/header", "view");
                        $this->load("buyTicket", "view", array("accountName" => Login::$account->getAccountName(), "stops" => $stops));
                        $this->load("headerAndFooterMain/footer", "view");
                        die();
                    }
                    
                } elseif(isset($_GET["autobusLine"])){
                    $stops = StopsLine::getAllStopsForASingleAutobusLine($_GET["autobusLine"]);

                    $this->load("headerAndFooterMain/header", "view");
                    $this->load("buyTicket", "view", array("accountName" => Login::$account->getAccountName(), "stops" => $stops));
                    $this->load("headerAndFooterMain/footer", "view");
                    die();

                } else {
                    $this->load("headerAndFooterMain/header", "view");
                    $this->load("buyTicket", "view", array("accountName" => Login::$account->getAccountName(), "autobusLine" => AutobusLine::getAllLines()));
                    $this->load("headerAndFooterMain/footer", "view");
                    die();
                }
            }
        }

        //Potvrđuje da su uneseni podaci korektni, da unesena autobusna linija ima u sebi obje stanice, zatim ovisno o
        //smjeru potvrđuje da su stanice korektno postavljenje (da su je jeda ispred ili iza druge, ovisno o smjeru vožnje)
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

        //Query za spremanje ticket-a
        public static function makeTicket($accountId, $scheduleid, $departure, $destination, $autobusLineId, $date){

            $query = self::$database_instance->getConnection()->prepare("INSERT INTO ticket (id, purchased, account_id, schedule_id, autobusline_id, departure, destination, valid_date) VALUES (NULL, NOW(), ?, ?, ?, ?, ?, ?)");
            $query->execute([$accountId, $scheduleid, $autobusLineId, $departure, $destination, $date]);

            return true;
        }

        //Računa cijenu iz zona za prosljeđene stanice
        public static function calculatePrice($destinationId, $departureId){
            $destination = StopsLine::getStopInfo($destinationId);
            $departure = StopsLine::getStopInfo($departureId);

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

        //Vraća broj rezerviranih karta za unsenu vožnju i za uneseni dan
        public static function numOfResearvedTickets($autobusLine, $validDate, $schedule){
            $query = self::$database_instance->getConnection()->prepare("SELECT COUNT(*) AS count
                                                                        FROM ticket
                                                                        WHERE autobusline_id = ? AND valid_date = date(?) AND schedule_id = ?");
            $query->execute([intval($autobusLine), $validDate, intval($schedule)]);
            return $query->fetch(PDO::FETCH_OBJ);
        }
    }

?>