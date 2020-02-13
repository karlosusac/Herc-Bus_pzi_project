<?php
    class Register extends Controller{

        public function index(){
            //Ako je postavljen id u session, korisnik nema šta tražiti na register page-u tako da ga šaljemo na Frontpage
            if(isset($_SESSION["id"])){
                header("Location: index.php?controller=Frontpage&method=index");
                die();
            }

            //Ako su podaci poslani ali ako se polje za unos password-a razlikuje jedno od drugog ili ako je prazno vrati ga na register page, sa error-om
            if(isset($_POST["accountName"])){
                $_POST["password"] = str_replace(' ', '', $_POST["password"]);
                $_POST["conPassword"] = str_replace(' ', '', $_POST["conPassword"]);
                if($_POST["password"] != $_POST["conPassword"] || $_POST["password"] == ""){
                    $this->load("headerAndFooterMain/header", "view");
                    $this->load("register", "view", array("error" => "Passwords do not match."));
                    $this->load("headerAndFooterMain/footer", "view");
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
                    self::registerUser($account);
                    
                    //Zatim spremamo id u sessiju unesenog user-a
                    Login::loginUser($account);

                    //Te ga na kraju šaljemo na frontpage, sa korisničkim podacima
                    $this->load("headerAndFooterMain/header", "view");
                    $this->load("frontpage", "view", array("accountName" => $account->getAccountName(), "account" => Login::$account));
                    $this->load("headerAndFooterMain/footer", "view");

                } catch (Exception $exception){
                    //Ako dođe do nekog error-a onda ga vrći na register page sa tim error-om
                    $this->load("headerAndFooterMain/header", "view");
                    $this->load("register", "view", array("error" => $exception->getMessage()));
                    $this->load("headerAndFooterMain/footer", "view");
                }
            
            //Ako je korisnik tek ušao na register page onda će ga poslati ovdije
            } else {
                $this->load("headerAndFooterMain/header", "view");
                $this->load("register", "view");
                $this->load("headerAndFooterMain/footer", "view");
            }
        }

        //Query koji gleda dali ima već postoji u bazi account ili email od podataka koji su se proslijedili, ako ne spremi ga u bazu
        public function registerUser($account){
            $query = self::$database_instance->getConnection()->prepare("SELECT account_name, e_mail
                                                                                FROM account
                                                                                WHERE account_name LIKE ? OR e_mail LIKE ?");
                $query->execute([$_POST["accountName"], $_POST["email"]]);
                $results = $query->fetchAll(PDO::FETCH_OBJ);

                if(empty($results)){
                    $query = self::$database_instance->getConnection()->prepare("INSERT INTO account (id, account_name, name, lastname, e_mail, password, phone_number, admin) VALUES (NULL, ?, ?, ?, ?, ?, ?, 0)");
                    $query->execute([$account->getAccountName(), $account->getName(), $account->getlastname(), $account->getEmail(),$account->getPassword(), $account->getPhoneNumber()]);
                    return true;

                }else{
                    throw new Exception("Username or email already taken.");
                    return false;
                }   
        }
    }


?>