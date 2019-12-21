<?php

session_start();

class Login extends Controller {
    public static $user;

    public function index () {
        if(isset($_POST["korisnickoime"])){
            try {
                $user = new Account($_POST["korisnickoime"], $_POST["lozinka"]);
                self::prijava($user);
                print("Uspješna prijava");
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

    public static function prijava ($user){
        $sql  = "SELECT id FROM korisnik";
        $sql .= " WHERE korisnickoIme='" . $user->getKorisnickoIme() . "'";
        $sql .= " AND lozinka='" . $user->getLozinka() . "'";

        $_connection = self::$database_instance->getConnection();
        $rezultat = $_connection->query($sql);

        $user = $rezultat->fetch();
        if ($user){
            $_SESSION["id"] = $user["id"];
            return true;
        } else {
            throw new Exception("Nastala je greška, korisnički podaci su neispravni.");
            return false;
        }
    }

    public static function logout(){
        unset($_SESSION["id"]);
        session_destroy();
    }

    public static function check_login (){
        $id = intval($_SESSION['id']);
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