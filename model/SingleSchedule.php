<?php
    class SingleSchedule{
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
    }   


?>