<?php

class Account {
    private $_id;
    private $_accountName;
    private $_nameLastname;
    private $_email;
    private $_password;
    private $_phoneNumber;
    private $_admin;

    public function __construct ($accountName, $password, $nameLastname = "", $email = "", $phoneNumber = "", $admin = 0){
        $this->_accountName = $accountName;
        $this->_password = ($password);
    }

    
    // GETTERS
    public function getId(){
        return $this->_id;
    }

    public function getAccountName(){
        return $this->_accountName;
    }

    public function getNameLastname(){
        return $this->_nameLastname;
    }

    public function getEmail(){
        return $this->_email;
    }

    public function getPassword(){
        return $this->_password;
    }

    public function getPhoneNumber(){
        return $this->_phoneNumber;
    }
    //------------------------------

    //SETTERS
    public function setId($id) {
        $this->_id = $id;
    }

    public function setAccountName($accountName) {
        $this->_accountName = $accountName;
    }

    public function setNameLastname($nameLastname) {
        $this->_nameLastname = $nameLastname;
    }

    public function setEmail($email) {
        $this->_email = $email;
    }

    public function setPassword($password) {
        $this->_password = $password;
    }

    public function setPhoneNumber($phoneNumber) {
        $this->_phoneNumber = $phoneNumber;
    }
}