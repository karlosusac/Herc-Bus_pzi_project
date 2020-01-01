<?php
    class Stop{
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
    }

?>