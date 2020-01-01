<?php
    class AutobusLine{
        private $_id;
        private $_start;
        private $_stop;

        public $_stops;
        public $_stopsLine;
        public $_scheduleForward;
        public $_scheduleBackward;

        public function __construct($start, $stop){
            $this->_start = $start;
            $this->_stop = $stop;

            $this->_stops = new ArrayObject();
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

        public function getStops(){
            return $this->_stops;
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

        public function setStops($stops){
            $this->_stops = $stops;
        }

        public function setScheduleForward($sf){
            $this->_scheduleForward = $sf;
        }

        public function setScheduleBackward($sb){
            $this->_scheduleBackward = $sb;
        }
        //----------------------------
    }

?>