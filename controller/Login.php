<?php

class Login extends Controller {
    public static $account;

    public function index () {
        //Ako je postavljen id u session, korisnik nema šta tražiti na login page-u tako da ga šaljemo na Frontpage
        if(isset($_SESSION["id"])){
            header("Location: index.php?controller=Frontpage&method=index");
            die();
        }

        //Ako je u POST-u poslan accountName, dakle poslana je forma za login te se spremamo vertificirati poslane podatke;
        if(isset($_POST["accountName"])){
            $_POST["password"] = str_replace(' ', '', $_POST["password"]);
            try {
                //Kreiramo novog korisnika od poslanih podataka da bi smo ga mogli vertificirati
                $account = new Account($_POST["accountName"], $_POST["password"]);

                //U loginUser metodi provjeravamo dali uopće postoji poslani accountName te dali password odgovara,
                //Ako je sve ok, onda šaljemo user-a na frontpage sa svojim podacima
                self::loginUser($account);

                $this->load("headerAndFooterMain/header", "view");
                $this->load("frontpage", "view", array("accountName" => $account->getAccountName()));
                $this->load("headerAndFooterMain/footer", "view");

            } catch (Exception $exception) {
                //Ako je došlo do neke greške 'vrći user-a nazad na login i display-aj error message
                $this->load("headerAndFooterMain/header", "view");
                $this->load("login", "view", array("error" => $exception->getMessage()));
                $this->load("headerAndFooterMain/footer", "view");
            }
        } else {
            
            //Ako nisu poslani podaci u POST-u, znači da je user tek došao na login page
            $this->load("headerAndFooterMain/header", "view");
            $this->load("login", "view");
            $this->load("headerAndFooterMain/footer", "view");
        }
        
    }

    public static function loginUser ($account){
        //Prvo nam treba id account-a kojeg dohvaćamo iz account_name-a, i provjeravamo dali uneseni password odgovara
        $query = self::$database_instance->getConnection()->prepare("SELECT id
                                                                    FROM account
                                                                    WHERE account_name = ? AND password = ?");
        
        $query->execute([$account->getAccountName(), $account->getPassword()]);
        //Zatim podatke koje smo dohvatili spremamo u varijablu $account
        $account = $query->fetch(PDO::FETCH_OBJ);
        
        if ($account){
            //Ako smo izvukli neke podatke iz baze, znači da account postoji, sada ćemo useru-u dati kriptirani id i spremiti ga u sessiju
            $query = self::$database_instance->getConnection()->prepare("INSERT INTO session_id (id, login_date, account_id) VALUES (NULL, NOW(), ?)");
            $query->execute([$account->id]);

            //Napravili smo novu instancu za 'session_id' koja nam čuva kriptirani id, id korisnika koji je log in-an i timestamp kada je se log-irao
            $query = self::$database_instance->getConnection()->prepare("SELECT id
                                                                        FROM session_id
                                                                        WHERE account_id = ?
                                                                        ORDER BY login_date DESC
                                                                        LIMIT 1");
            $query->execute([$account->id]);
            
            //Sa gore navedenim query-om uzimamo id iz 'session_id' jer ćemo ga koristiti za kriptiranje
            $sessionId = $query->fetch(PDO::FETCH_OBJ);
            //Ovo su nam salt-ovi koje također koristimo za kriptiranje
            $salt = ["Sarma", "Japrak", "Grah", "Mohune", "Pileca Juha", "Grashak"];
            //Sada kriptiramo id iz 'session_id'-a i na njega dodamo random 'čorbu' iz $salt-a te i njega kriptiramo i sve spajamo u jedan string koji nam predstavlja našu kriptirani session ili $token
            $token = md5($sessionId->id). md5($salt[array_rand($salt)]);

            //Sad ubacimo natrag u bazu naš token koji smo napravili i spremimo ga u sessiju
            $query = self::$database_instance->getConnection()->prepare("UPDATE session_id SET token = ? WHERE id = ?");
            $query->execute([$token, $sessionId->id]);

            $_SESSION["id"] = $token;

            return true;
        } else {
            throw new Exception("Incorrect username or password.");
            return false;
        }
    }

    //Statična metoda za dohvaćanje account_id-a iz kriptiranog session id-a ili $token-a
    public static function decryptSessionId(){
        $query = self::$database_instance->getConnection()->prepare("SELECT account_id
                                                            FROM session_id
                                                            WHERE token = ?");
        $query->execute([$_SESSION["id"]]);
        $accountId = $query->fetch(PDO::FETCH_OBJ);
        return $accountId->account_id;
    }

    //Metoda za uništavanje sessije prilikom logout-a
    public static function logout(){
        if(isset($_SESSION["id"])){
            unset($_SESSION["id"]);
            session_destroy();
        }
    }

    //Metoda koja dohvaća account iz session-a
    public static function check_login (){
        
        $id = self::decryptSessionId();

        $query = self::$database_instance->getConnection()->prepare("SELECT *
                                                            FROM account
                                                            WHERE id = ?");
        $query->execute([intval($id)]);
        $user = $query->fetch(PDO::FETCH_OBJ);

        if(!($user)){
            throw new Exception("Account is not loged in.");
        } else {
            Login::$account = new Account(
                $user->account_name,
                $user->password,
                $user->name,
                $user->lastname,
                $user->e_mail,
                $user->phone_number,
                $user->admin
            );
        }

    }
    
}