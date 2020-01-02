<?php 
    class StopsLine{
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
    }

?>