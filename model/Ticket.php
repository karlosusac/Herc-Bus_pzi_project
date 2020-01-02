<?php
    class Ticket{
        private $_id;
        private $_accountId;
        private $_scheduleId;
        private $_autobusLineId;
        private $_departure;
        private $_destination;
        private $_validDate;
        private $_purchased;
        private $_price;

        public function __construct($accountId, $scheduleId, $autobusLineId, $departure, $destination){
            $this->_accountId = $accountId;
            $this->_scheduleId = $scheduleId;
            $this->_autobusLineId = $autobusLineId;
            $this->_departure = $departure;
            $this->_destination = $destination;
        }

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

        public function getDeparture(){
            return $this->_departure;
        }

        public function getDestination(){
            return $this->_destination;
        }

        public function getValidDate(){
            return $this->_validDate;
        }

        public function getPurchased(){
            return $this->_purchased;
        }

        public function getPrice(){
            return $this->_price;
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

        public function setDeparture($departure){
            $this->_departure = $departure;
        }

        public function setDestination($destination){
            $this->_destination = $destination;
        }
        
        public function setValidDate($validDate){
            $this->_validDate = $validDate;
        }

        public function setPurchased($purchased){
            $this->_purchased = $purchased;
        }

        public function setPrice($price){
            $this->_price = $price;
        }
    }
?>