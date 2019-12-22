<?php

session_start();

class Login extends Controller {
    public static $user;

    public function index () {
        if(isset($_POST["loginAccountName"])){
            try {
                $user = new Account($_POST["loginAccountName"], $_POST["loginPassword"]);
                self::loginUser($user);
                print("Login successful!!!");
            } catch (Exception $e) {
                $this->load(
                    "login", 
                    "view", 
                    array("error" => $e->getMessage())
                );
            }
        } else {
            $this->load("login", "view");
        }
        
    }

    public static function loginUser ($user){
        //Get account_id from given accountName and Password if it exists
        $query = self::$database_instance->getConnection()->prepare("SELECT id
                                                                    FROM account
                                                                    WHERE account_name = ? AND password = ?");
        
        $query->execute([$user->getAccountName(), $user->getPassword()]);
        //We save account id as an object in a user variable(if it exists)
        $user = $query->fetch(PDO::FETCH_OBJ);
        
        if ($user){
            //If user exists we will create new session_id and assign it it's unique id and timestamp
            $query = self::$database_instance->getConnection()->prepare("INSERT INTO session_id (id, login_date, account_id) VALUES (NULL, NOW(), ?)");
            $query->execute([$user->id]);

            //We need to take latest session_id id from the database so we can assign it it's unique token
            $query = self::$database_instance->getConnection()->prepare("SELECT id
                                                                        FROM session_id
                                                                        WHERE account_id = ?
                                                                        ORDER BY login_date DESC
                                                                        LIMIT 1");
            $query->execute([$user->id]);
            
            //We got the id now we make token out of the one of the values from the salt array and it's id
            $sessionId = $query->fetch(PDO::FETCH_OBJ);
            $salt = ["Sarma", "Japrak", "Grah", "Mohune", "Pileca Juha", "Grashak"];
            $token = md5($sessionId->id). md5($salt[array_rand($salt)]);

            //Updateing session_id row with the token
            $query = self::$database_instance->getConnection()->prepare("UPDATE session_id SET token = ? WHERE id = ?");
            $query->execute([$token, $sessionId->id]);


            $_SESSION["id"] = $token;

            return true;
        } else {
            throw new Exception("Error, entered values are incorrect.");
            return false;
        }
    }

    public static function decryptSessionId(){
        $query = self::$database_instance->getConnection()->prepare("SELECT account_id
                                                            FROM session_id
                                                            WHERE token = ?");
        $query->execute([$_SESSION["id"]]);
        $accountId = $query->fetch(PDO::FETCH_OBJ);
        return $accountId->account_id;
    }

    public static function logout(){
        unset($_SESSION["id"]);
        session_destroy();
    }

    public static function check_login (){
        $id = intval($_SESSION['id']);
        
        //STARTED, NEEDS TO BE FINISHED
        $query = $database_instance->getConnection()->prepare("SELECT *
                                                            FROM account
                                                            WHERE id = ?");
        $query->execute();
        //-------

        $sql = "SELECT * FROM korisnik";
        $sql += " WHERE id=" . $id;

        $konekcija = self::$baza->getConnection();
        $rezultat = $konekcija->query($sql);
        $objekt = $rezultat->fetch();

        if (count($objekt) == 0) {
            throw new Exception("Nastala je pogreška: Korisnik nije prijavljen.");
        } else {
            self::$user = new Account(
                $objekt["korisnickoime"],
                $objekt["lozinka"],
                $objekt["id"],
                $objekt["ime"],
                $objekt["prezime"],
                $objekt["email"]
            );
        }
    }
    
}