<?php

$korisnik = "root";
$lozinka = "";
$host = "localhost";
$bazaPodataka = "bus_ticket_reservation";

try{
    $konekcija = new PDO("mysql:host=$host;dbname=$bazaPodataka", $korisnik, $lozinka, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $konekcija->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    print("Connection enstablished :^)<br><br>");

    /*
    print("Svi account-ovi koji se nalaze u bazi: <br>");
    $gibAccounts = $konekcija->query("SELECT ID, account_name, name_lastname FROM account");
    print("<table><tr><td>ID</td><td>Name and Lastname</td><td>")
    while($row = $gibAccounts->fetch()){
        print($row["name_lastname"]. "<br />");
    }
    */

    print("<table border='1px' align='left'><caption>Svi account-ovi koji se nalaze u bazi:</caption><tr align='center'><th>ID</th><th>ime account-a</th><th>ime i prezime</th><th>email</th><th>broj mobitela</th></tr>");
    $accounts = $konekcija->query("SELECT ID, account_name, name_lastname, e_mail, phone_number FROM account")->fetchAll();
    foreach($accounts as $row){
        print("<tr align='center'><td>". $row["ID"]. "</td><td>". $row["account_name"]. "</td><td>". $row["name_lastname"]. "</td><td>". $row["e_mail"]. "</td><td>". $row["phone_number"]. "</td></tr>"); 
    }
    print("</table><br><br>");

    print("<table border='1px' align='right'><caption>Sve stanice za autobuse:</caption><tr align='center'><th>ID</th><th>ime stanice</th><th>zona</th></tr>");
    $busStops = $konekcija->query("SELECT ID, name, zone FROM stops")->fetchAll();
    foreach($busStops as $row){
        print("<tr align='center'><td>". $row["ID"]. "</td><td>". $row["name"]. "</td><td>". $row["zone"]. "</td><tr>"); 
    }
    print("</table><br><br>");

    print("<table border='1px' align='center'><caption>Sve autobusne linije:</caption><tr align='center'><th>ID</th><th>ime autobusne linije</th></tr>");
    $busLines = $konekcija->query("SELECT * FROM autobus_line")->fetchAll();
    foreach($busLines as $row){
        print("<tr align='center'><td>". $row["ID"]. "</td><td>". $row["start_stop"]. "</td><tr>"); 
    }
    print("</table><br><br>");

    print("<table border='1px' align='left'><caption>Raspored polaska autobusnih linija:</caption><tr align='center'><th>autobusna linija</th><th>ID rasporeda voznje</th><th>početak vožnje</th><th>dolazak</th><th>broj sjelada u autobusu</th><th>smjer</th></tr>");
    $busLines = $konekcija->query("SELECT al.start_stop, s.id, s.start_time, s.stop_time, s.number_of_seats, s.direction FROM schedule AS s INNER JOIN autobus_line AS al ON al.id = s.autobus_line_id;")->fetchAll();
    foreach($busLines as $row){
        print("<tr align='center'><td>". $row["start_stop"]. "</td><td>". $row["id"]. "</td><td>". $row["start_time"]. "</td><td>". $row["stop_time"]. "</td><td>". $row["number_of_seats"]. "</td><td>". $row["direction"]. "</td><tr>"); 
    }
    print("</table><br><br>");

    print("<table border='1px' align='right'><caption>Međutabica stanica i autobusnih linija:</caption><tr align='center'><th>autobusna linija</th><th>ime stanice</th><th>id stanice međutablice</th><th>pozicija stanice u linij</th></tr>");
    $busLines = $konekcija->query("SELECT al.start_stop, s.name, sl.ID, sl.position_order FROM stops_line AS sl INNER JOIN autobus_line AS al ON al.ID = sl.autobus_line_id INNER JOIN stops AS s ON s.ID = sl.stops_id")->fetchAll();
    foreach($busLines as $row){
        print("<tr align='center'><td>". $row["start_stop"]. "</td><td>". $row["name"]. "</td><td>". $row["ID"]. "</td><td>". $row["position_order"]. "</td><tr>"); 
    }
    print("</table><br><br>");

    print("<table border='1px' align='center'><caption>Karta:</caption><tr align='center'><th>ime i prezime</th><th>autobusna linija</th><th>početna stranica</th><th>krajnja stanica</th><th>vrijeme polaska</th><th>vrijeme dolaska</th><th>karta vrijedi za dan</th></tr>");
    $busLines = $konekcija->query("SELECT a.name_lastname,al.start_stop, startPlace.name AS pocetak, stopPlace.name AS kraj, s.start_time, s.stop_time, t.valid_date FROM ticket AS t INNER JOIN account AS a ON a.ID = t.account_id INNER JOIN schedule AS s ON s.ID = t.schedule_id INNER JOIN autobus_line AS al ON al.ID = t.autobusline_id INNER JOIN stops_line AS sl1 ON sl1.ID = t.stops_line_start_id INNER JOIN stops_line AS sl2 ON sl2.ID = t.stops_line_stop_id INNER JOIN stops AS startPlace ON stops_line_start_id = startPlace.id INNER JOIN stops AS stopPlace ON stops_line_stop_id = stopPlace.id ")->fetchAll();
    foreach($busLines as $row){
        print("<tr align='center'><td>". $row["name_lastname"]. "</td><td>". $row["start_stop"]. "</td><td>". $row["pocetak"]. "</td><td>". $row["kraj"]. "</td><td>". $row["start_time"]. "</td><td>". $row["stop_time"]. "</td><td>". $row["valid_date"]. "</td></tr>"); 
    }
    print("</table><br><br>");

    /*
    $stmt = $konekcija->prepare("SELECT ID, account_name, name_lastname FROM account");
    $stmt->execute();
    */
    
    
}catch(exception $e){
    print("Connection failed, error code ->". $e->getMessage());
}


$konekcija = null;
?>