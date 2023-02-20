<?php

    session_start();
    $link = mysqli_connect("localhost", "root", "", "mpvs");

    $rpg = $_POST['rpg'];

    if(isset($_POST['insert'])){

        if ($_POST['protokol'] == "" or $_POST['rpg'] == "" or $_POST['rk'] == "" or $_POST['ime'] == "" or $_POST['prezime'] == "" or $_POST['ulica'] == "" or $_POST['broj']== "" or $_POST['opcina'] == "" or $_POST['telefon'] == ""  ) { 
    
            echo "<div class='alert alert-danger' role='alert'>Molimo unesite sve podatke.</div>";
    
        } else {
    
            //dohvacanje rpg kojeg je unio sluzbenik 1
    
            $sql1 = "SELECT * FROM obrazac";
            $result = $link -> query($sql1);
            $var = "y";
            while($row = $result -> fetch_assoc()){
    
                if ($_POST['protokol']==$row['protokol']) {
    
                    echo "<div class='alert alert-danger' role='alert'> Uneseni protokol već postoji.</div>";
                    $var = "n";
                    break;
    
                } else {
    
                    $var = "y";
    
                }
    
            }
    
            if ($var == "y") {
    
                //brisanje sve iz rpg procesa
                $query2 = "DELETE FROM rpg_proces";
                $query_run2 = mysqli_query($link, $query2);
    
                //spremanje podataka o vlasniku u tablicu vlasnik
                $query1 = "INSERT INTO vlasnik (rpg, rk, ime, prezime, ulica, broj, opcina, telefon) VALUES ('".mysqli_real_escape_string($link, $_POST['rpg'])."', '".mysqli_real_escape_string($link, $_POST['rk'])."','".mysqli_real_escape_string($link, $_POST['ime'])."', '".mysqli_real_escape_string($link, $_POST['prezime'])."', '".mysqli_real_escape_string($link, $_POST['ulica'])."', '".mysqli_real_escape_string($link, $_POST['broj'])."', '".mysqli_real_escape_string($link, $_POST['opcina'])."', '".mysqli_real_escape_string($link, $_POST['telefon'])."') LIMIT 1";
                $query_run1 = mysqli_query($link, $query1);
    
                //spremanje podataka o p1 obrascu u tablicu obrazac
                $query = "INSERT INTO obrazac (protokol, rpg, rk, ime, prezime, ulica, broj, opcina, telefon, datum, stanje, status_komplet) VALUES ('".mysqli_real_escape_string($link, $_POST['protokol'])."', '".mysqli_real_escape_string($link, $_POST['rpg'])."', '".mysqli_real_escape_string($link, $_POST['rk'])."', '".mysqli_real_escape_string($link, $_POST['ime'])."', '".mysqli_real_escape_string($link, $_POST['prezime'])."', '".mysqli_real_escape_string($link, $_POST['ulica'])."', '".mysqli_real_escape_string($link, $_POST['broj'])."', '".mysqli_real_escape_string($link, $_POST['opcina'])."', '".mysqli_real_escape_string($link, $_POST['telefon'])."', '".mysqli_real_escape_string($link, $_POST['datum'])."', 'Neodrađen', 'Neodrađen') LIMIT 1";
                $query_run = mysqli_query($link, $query);

                    
        
                $protokol = $_POST['protokol'];
                $proizvodnje = $_POST['proizvodnje']; 

                foreach($proizvodnje as $hobrow){
                
                    echo $hobrow;

                    $query3 = "INSERT INTO proizvodnje (protokol, proizvodnja) VALUES ('$protokol', '$hobrow')";
                    $query_run3 = mysqli_query($link, $query3);

                    if ($query_run3) {

                        $_SESSION['status'] = "Inserted Sucesfully";
                        header ("Location: sluzbenik1-usp.php");
            
                    }
        
                }   

            }
        }
    
    }
?>