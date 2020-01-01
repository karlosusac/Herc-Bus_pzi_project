<?php
    class Ticket{
        private $_id;
        private $_accountId;
        private $_scheduleId;
        private $_autobusLineId;
        private $_stopsLineStartId;
        private $_stopsLineStopId;
        private $_validDate;
        private $_purchased;

        //GETTERS

        public function getId(){
            return $this->_id;
        }

        public function getAccountId(){
            return $this->_accountId;
        }

        public function getScheduleId(){
            return $this->_scheduleId;
        }

        public function getAutobusLineId(){
            return $this->_autobusLineId;
        }

        public function getStopsLineStartId(){
            return $this->_stopsLineStartId;
        }

        public function getStopsLineStopId(){
            return $this->_stopsLineStopId;
        }

        public function getValidDate(){
            return $this->_validDate;
        }

        public function getPurchased(){
            return $this->_purchased;
        }
        //----------------------------

        //SETTERS

        public function setId($id){
            $this->_id = $id;
        }

        public function setAccountId($accountId){
            $this->_accountId = $accountId;
        }

        public function setScheduleId($scheduleId){
            $this->_scheduleId = $scheduleId;
        }

        public function setAutobusLineId($autobusLineId){
            $this->_autobusLineId = $autobusLineId;
        }

        public function setStopsLineStartId($stopsLineStartId){
            $this->_stopsLineStartId = $stopsLineStartId;
        }

        public function setStopsLineStopId($stopsLineStopId){
            $this->_stopsLineStopId = $stopsLineStopId;
        }
        
        public function setValidDate($validDate){
            $this->_validDate = $validDate;
        }

        public function setPurchased($purchased){
            $this->_purchased = $purchased;
        }
    }
?>