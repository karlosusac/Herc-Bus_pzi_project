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
                                                                    WHERE e_mail = ?");
        $query->execute([$email]);
        $id1 = $query->fetch(PDO::FETCH_OBJ);

        $query = self::$database_instance->getConnection()->prepare("SELECT id 
                                                                    FROM account
                                                                    WHERE account_name = ?");
        $query->execute([$username]);
        $id2 = $query->fetch(PDO::FETCH_OBJ);
        
        if(empty($id1->id) && empty($id2->id)){
            var_dump("Prošlo bez problema");
            die();
            return true;

        } else {
            $isFirstValueMine = false;
            $isSecondValueMine = false;
           

            if(!empty($id1->id) && !empty($id2->id)){
                if($id1->id == Login::decryptSessionId($_SESSION["id"])){
                    $isFirstValueMine = true;
                }

                if($id2->id == Login::decryptSessionId($_SESSION["id"])){
                    $isSecondValueMine = true;
                }

                if($isFirstValueMine == true && $isSecondValueMine == true){
                    
                    return true;
                }

            } else {
                if(!empty($id1->id) && empty($id2->id)){
                    if($id1->id == Login::decryptSessionId($_SESSION["id"])){
                        $isFirstValueMine = true;
                    }
                } else {
                    if($id2->id == Login::decryptSessionId($_SESSION["id"])){
                        $isFirstValueMine = true;
                    }
                }

                if($isFirstValueMine == true){
                    
                    return true;
                }
            }

            return false;
        }
    }
    public static function updateAccountInfo($username, $firstName, $lastName, $email, $phoneNumber){
        $id = Login::decryptSessionId();

        $query = self::$database_instance->getConnection()->prepare("UPDATE account SET account_name = ?, name = ?, lastname = ?, e_mail = ?, phone_number = ? 
                                                                    WHERE id = ?");
        $query->execute([$username, $firstName, $lastName, $email, $phoneNumber, intval($id)]);

        return true;
    }

    public function updateAccountPassword($password){
        $id = Login::decryptSessionId();

        $query = self::$database_instance->getConnection()->prepare("UPDATE account SET password = ?
                                                                    WHERE id = ?");
        $query->execute([$password, intval($id)]);
        return true;
    }
}