<?php
    class Helpers extends Controller{
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
    }
?>