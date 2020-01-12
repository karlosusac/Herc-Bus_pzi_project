<?php 
    class StopsLine extends Controller{
        private $_id;
        private $_positionOrder;
        private $_stopsId;
        private $_autobusLineId;

        private $_stopName;

        public function __construct($positionOrder = "", $stopsId = "", $autobusLineId = ""){
            $this->_positionOrder = $positionOrder;
            $this->_stopsId = $stopsId;
            $this->_autobusLineId = $autobusLineId;
        }

        //GETTERS

        public function getId(){
            return $this->_id;
        }

        public function getPositionOrder(){
            return $this->_positionOrder;
        }

        public function getStopsId(){
            return $this->_stopsId;
        }

        public function getAutobusLineId(){
            return $this->_autobusLineId;
        }

        public function getStopName(){
            return $this->_stopName;
        }
        //--------------------------------

        //SETTERS

        public function setId($id){
            $this->_id = $id;
        }

        public function setPositionOrder($positionOrder){
            $this->_positionOrder = $positionOrder;
        }

        public function setStopsId($stopsId){
            $this->_stopsId = $stopsId;
        }

        public function setAutobusLineId($autobusLineId){
            $this->_autobusLineId = $autobusLineId;
        }

        public function setStopName($stopName){
            return $this->_stopName = $stopName;
        }

        //CUSTOM

        //Dohvati sve stanice od autobusne linije čiji id proslijedimo
        public static function getAllStopsForASingleAutobusLine($autobusLineId){
            $query = self::$database_instance->getConnection()->prepare("SELECT s.name, sl.id, position_order, s.id AS sid
                                                                        FROM stops AS s
                                                                        INNER JOIN stops_line AS sl ON s.id = sl.stops_id
                                                                        WHERE sl.autobus_line_id = ?");
            $query->execute([$autobusLineId]);
            $stops = $query->fetchAll(PDO::FETCH_OBJ);

            return ($stops);
        }

        public static function getAllStopsForASingleAutobusLineOrderedByPositionOrder($autobusLineId){
            $query = self::$database_instance->getConnection()->prepare("SELECT s.name, sl.id, position_order, s.id AS stop_id
                                                                        FROM stops AS s
                                                                        INNER JOIN stops_line AS sl ON s.id = sl.stops_id
                                                                        WHERE sl.autobus_line_id = ?
                                                                        ORDER BY position_order");
            $query->execute([$autobusLineId]);
            $stops = $query->fetchAll(PDO::FETCH_OBJ);

            return ($stops);
        }

        //Vraća niz stanica koje nisu odabrane, koristi se za odabir mjesta polaska (departure) kod kupnje ticket-a
        public static function getRestOfStops($autobusLine, $stopId){
            $query = self::$database_instance->getConnection()->prepare("SELECT s.name, s.zone, sl.position_order, sl.id
                                                                        FROM stops AS s
                                                                        INNER JOIN stops_line AS sl ON s.id = sl.stops_id
                                                                        WHERE sl.autobus_line_id = ? AND sl.id <> ?
                                                                        ORDER BY sl.position_order ASC");
            $query->execute([$autobusLine, $stopId]);
            
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        //Vraća smjer vožnje ovisno o unesenim stanicama
        public static function compareStops($stop1Id, $stop2Id){
            $stop1 = StopsLine::getStopInfo($stop1Id);
            $stop2 = StopsLine::getStopInfo($stop2Id);

            if($stop1->position_order > $stop2->position_order){
                return 1;
            } else {
                return 0;
            }
        }

        //Vraća podatke pojedine stanice
        public static function getStopInfo($stopsLineId){
            $query = self::$database_instance->getConnection()->prepare("SELECT s.name, s.zone, sl.position_order
                                                                        FROM stops AS s
                                                                        INNER JOIN stops_line AS sl ON s.id = sl.stops_id
                                                                        WHERE sl.id = ?");
            $query->execute([$stopsLineId]);
            return $query->fetch(PDO::FETCH_OBJ);
        }

        //Potvrđuje da stanica postoji, (jer se vrijednost može mjenjati iz url-a)
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

        public static function insertNewAutobusLineStops($autobusLine){
            $position_order = 0;
            
            foreach ($autobusLine->getAllLineStops() as $als){
                $query = self::$database_instance->getConnection()->prepare("INSERT INTO stops_line (id, position_order, stops_id, autobus_line_id) VALUES (NULL, ?, ?, ?)");
                $query->execute([$position_order, $als[0], $autobusLine->getId()]);
                
                $position_order++;

            }
        }

        public static function test(){

        }
    }

?>