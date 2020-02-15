<?php
    class AddAdminAccount extends Controller{
        
        public function index(){
            if(isset($_SESSION["id"])){
                Login::check_login();

                if(isset($_SESSION["id"]) && Login::$account->getAdmin() == 1){

                    if(isset($_POST["accountName"])){
                        $_POST["password"] = str_replace(' ', '', $_POST["password"]);
                        $_POST["conPassword"] = str_replace(' ', '', $_POST["conPassword"]);
                        if($_POST["password"] != $_POST["conPassword"] || $_POST["password"] == ""){
                            header("Location: index.php?controller=addAdminAccount&method=index&error=Passwords do not match");
                            die();
                        } 
                        //Kreiraj novi account od unesenih podataka
                        try{
                            $account = new Account(
                                $_POST["accountName"],
                                $_POST["password"],
                                $_POST["name"],
                                $_POST["lastname"],
                                $_POST["email"],
                                $_POST["phoneNumber"]
                            );
                            
                            //Pokušaj ga spremiti u bazu
                            self::registerAdminAccount($account);
                            
                            //Prilikom uspiješnog kreiranja account-a, prosljeđujemo korisnika na profil
                        header("Location: index.php?controller=Profile&method=index&success=Successully added an admin account");

                        } catch (Exception $exception){
                            //Ako dođe do nekog error-a onda ga vrći na profile page sa tim error-om
                            header("Location: index.php?controller=Profile&method=index&error=Could not add an admin account");
                        }
                    
                    //Ako je korisnik tek ušao na register page onda će ga poslati ovdije
                    } else {
                        $this->load("headerAndFooterMain/header", "view");
                        $this->load("newAdminAccount", "view", array("account" => Login::$account));
                        $this->load("headerAndFooterMain/footer", "view");
                        die();
                    }
                } else {
                    header("Location: index.php?controller=Frontpage&method=index");
                }
            } else {
                header("Location: index.php?controller=Frontpage&method=index");
            }
        }

        //Query koji gleda dali ima već postoji u bazi account ili email od podataka koji su se proslijedili, ako ne spremi ga u bazu
        public function registerAdminAccount($account){
            $query = self::$database_instance->getConnection()->prepare("SELECT account_name, e_mail
                                                                                FROM account
                                                                                WHERE account_name LIKE ? OR e_mail LIKE ?");
                $query->execute([$_POST["accountName"], $_POST["email"]]);
                $results = $query->fetchAll(PDO::FETCH_OBJ);

                if(empty($results)){
                    $query = self::$database_instance->getConnection()->prepare("INSERT INTO account (id, account_name, name, lastname, e_mail, password, phone_number, admin) VALUES (NULL, ?, ?, ?, ?, ?, ?, 1)");
                    $query->execute([$account->getAccountName(), $account->getName(), $account->getlastname(), $account->getEmail(),$account->getPassword(), $account->getPhoneNumber()]);
                    return true;

                }else{
                    throw new Exception("Username or email already taken.");
                    return false;
                }   
        }
    }
?>