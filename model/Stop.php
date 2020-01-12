<?php
    class Stop extends Controller{
        private $_id;
        private $_name;
        private $_zone;

        public function _construct($name, $zone){
            $this->_name = $name;
            $this->_zone = $zone;
        }

        //GETTERS

        public function getId(){
            return $this->_id;
        }

        public function getName(){
            return $this->_name;
        }

        public function getZone(){
            return $this->_zone;
        }
        //----------------------------

        //SETTERS

        public function setId($id){
            $this->_id = $id;
        }

        public function setName($name){
            $this->_name = $name;
        }

        public function setZone($zone){
            $this->_zone = $zone;
        }
        //----------------------------
        //CUSTOM

        public static function getAllStops(){
            $query = self::$database_instance->getConnection()->prepare("SELECT id, name, zone 
                                                                        FROM stops 
                                                                        ORDER BY name ASC");
            $query->execute();
            
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        public static function getStopInfoFromStopId($stopId){
            $query = self::$database_instance->getConnection()->prepare("SELECT id, name, zone
                                                                        FROM stops
                                                                        WHERE id = ?");
            $query->execute([$stopId]);
            return $query->fetch(PDO::FETCH_OBJ);
        }
    }

?>