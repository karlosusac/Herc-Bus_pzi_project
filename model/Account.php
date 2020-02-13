<?php

class Account extends Controller{
    private $_id;
    private $_accountName;
    private $_name;
    private $_lastname;
    private $_email;
    private $_password;
    private $_phoneNumber;
    private $_admin;

    public function __construct ($accountName, $password, $name = "", $lastname = "",  $email = "", $phoneNumber = "", $admin = 0){
        $this->_accountName = $accountName;
        $this->_password = $password;
        $this->_name = $name;
        $this->_lastname = $lastname;
        $this->_email = $email;
        $this->_phoneNumber = $phoneNumber;
        $this->_admin = $admin;
    }

    
    // GETTERS
    public function getId(){
        return $this->_id;
    }

    public function getAccountName(){
        return $this->_accountName;
    }

    public function getName(){
        return $this->_name;
    }

    public function getlastname(){
        return $this->_lastname;
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

    public function getAdmin(){
        return $this->_admin;
    }
    //------------------------------

    //SETTERS
    public function setId($id) {
        $this->_id = $id;
    }

    public function setAccountName($accountName) {
        $this->_accountName = $accountName;
    }

    public function setName($name) {
        $this->_name = $name;
    }

    public function setLastname($lastname) {
        $this->_lastname = $lastname;
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

    public function setAdmin($admin) {
        $this->_admin = $admin;
    }

    public static function areEmailAndUsernameOccupied($email, $username){
        $query = self::$database_instance->getConnection()->prepare("SELECT id 
                                                                    FROM account
                                                                    WHERE e_mail = ? OR account_name = ?");
        $query->execute([$email, $username]);
        $results = $query->fetchAll();
        
        if(empty($results)){
            return true;
        } else {
            $isFirstValueMine = false;
            $isSecondValueMine = false;
           

            if(count($results[0]) == 2){
                //var_dump($results);
                if($results[0][0] == Login::decryptSessionId($_SESSION["id"])){
                    $isFirstValueMine = true;
                }

                if($results[0]["id"] == Login::decryptSessionId($_SESSION["id"])){
                    $isSecondValueMine = true;
                }

                if($isFirstValueMine == true && $isSecondValueMine == true){
                    var_dump("True");
                    return true;
                }

            } else {
                if($results[0][0] == Login::decryptSessionId($_SESSION["id"])){
                    //var_dump($results);
                    $isFirstValueMine = true;
                }

                if($isFirstValueMine == true){
                    var_dump("True");
                    return true;
                }
            }

            //return false;
        }
    }
}