<?php

    session_start();

    $msg= "";
    $najveci = "";

    //uključivanje kolačića i prijave
    if(array_key_exists("id", $_COOKIE)) {
            
        $_SESSION['id']=$_COOKIE['id'];

    }
        
    //povezivanje na bazu
    $link = mysqli_connect("localhost", "root", "", "mpvs");
        
    if (mysqli_connect_error()) {
            
        die("There was an error connecting to the database");
            
    }

    if(array_key_exists("id", $_SESSION)) {
                
        $date = date('Y-m-d');
        //dohvacanje rpg kojeg je unio sluzbenik 1
        $sql = "SELECT * FROM rpg_proces ORDER BY id DESC LIMIT 1";
        $row = mysqli_fetch_array(mysqli_query($link, $sql));
        $rpg_proces = $row['rpg_proces'];

        $jednako = "x";

        //dohvacanje rpg kojeg je unio sluzbenik 1
        $sql1 = "SELECT * FROM vlasnik";
        $result = $link -> query($sql1);
        while($row = $result -> fetch_assoc()){

                if ($rpg_proces==$row['rpg']) {

                    $rpg = $row['rpg'];
                    $jednako = "true";
                    break;

                } else {

                    $jednako = "x";

                }
        
        }

    }   

    //na logout
    if(array_key_exists("submit1", $_POST)){
 
        $query = "DELETE FROM rpg_proces";
        $query_run = mysqli_query($link, $query);
        header("Location: mpvs.php?logout=1");
            
    }

    if (isset($_POST['update'])) {

        if ($_POST['protokol'] == "" or $_POST['rpg'] == "" or $_POST['rk'] == "" or $_POST['ime'] == "" or $_POST['prezime'] == "" or $_POST['ulica'] == "" or $_POST['broj']== "" or $_POST['opcina'] == "" or $_POST['proizvodnja'] == "" or $_POST['telefon'] == ""  ) { 
 
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
                    $query1 = "UPDATE vlasnik SET rk = '".mysqli_real_escape_string($link, $_POST['rk'])."', ime = '".mysqli_real_escape_string($link, $_POST['ime'])."',prezime = '".mysqli_real_escape_string($link, $_POST['prezime'])."',ulica = '".mysqli_real_escape_string($link, $_POST['ulica'])."',broj =  '".mysqli_real_escape_string($link, $_POST['broj'])."',opcina = '".mysqli_real_escape_string($link, $_POST['opcina'])."', telefon = '".mysqli_real_escape_string($link, $_POST['telefon'])."' WHERE rpg = $rpg LIMIT 1 ";
                    $query1_run = mysqli_query($link, $query1);

                    //spremanje podataka o p1 obrascu u tablicu obrazac
                    $query = "INSERT INTO obrazac (protokol, rpg, rk, ime, prezime, ulica, broj, opcina, telefon, proizvodnja, datum, stanje, status_komplet) VALUES ('".mysqli_real_escape_string($link, $_POST['protokol'])."', '".mysqli_real_escape_string($link, $_POST['rpg'])."', '".mysqli_real_escape_string($link, $_POST['rk'])."', '".mysqli_real_escape_string($link, $_POST['ime'])."', '".mysqli_real_escape_string($link, $_POST['prezime'])."', '".mysqli_real_escape_string($link, $_POST['ulica'])."', '".mysqli_real_escape_string($link, $_POST['broj'])."', '".mysqli_real_escape_string($link, $_POST['opcina'])."', '".mysqli_real_escape_string($link, $_POST['telefon'])."', '".mysqli_real_escape_string($link, $_POST['proizvodnja'])."', '".mysqli_real_escape_string($link, $_POST['datum'])."', 'Neodrađen', 'Neodrađen') LIMIT 1";
                    $query_run = mysqli_query($link, $query);
                        
                if ($query_run) {

                    $_SESSION['status'] = "Inserted Sucesfully";
                    header ("Location: sluzbenik1-usp.php");

                }

            }
        }

    }


    if (isset($_POST['insert'])) {

        if ($_POST['protokol'] == "" or $_POST['rpg'] == "" or $_POST['rk'] == "" or $_POST['ime'] == "" or $_POST['prezime'] == "" or $_POST['ulica'] == "" or $_POST['broj']== "" or $_POST['opcina'] == "" or  $_POST['proizvodnja'] == "" or $_POST['telefon'] == "") { 
 
            echo "<div class='alert alert-danger' role='alert'>Molimo unesite sve podatke.</div>";

        } else {

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
                $query = "INSERT INTO obrazac (protokol, rpg, rk, ime, prezime, ulica, broj, opcina, telefon, proizvodnja, datum, stanje, status_komplet) VALUES ('".mysqli_real_escape_string($link, $_POST['protokol'])."', '".mysqli_real_escape_string($link, $_POST['rpg'])."', '".mysqli_real_escape_string($link, $_POST['rk'])."', '".mysqli_real_escape_string($link, $_POST['ime'])."', '".mysqli_real_escape_string($link, $_POST['prezime'])."', '".mysqli_real_escape_string($link, $_POST['ulica'])."', '".mysqli_real_escape_string($link, $_POST['broj'])."', '".mysqli_real_escape_string($link, $_POST['opcina'])."', '".mysqli_real_escape_string($link, $_POST['telefon'])."', '".mysqli_real_escape_string($link, $_POST['proizvodnja'])."', '".mysqli_real_escape_string($link, $_POST['datum'])."', 'Neodrađen', 'Neodrađen') LIMIT 1";
                $query_run = mysqli_query($link, $query);
                            
                if ($query_run) {

                    $_SESSION['status'] = "Inserted Sucesfully";
                    header ("Location: sluzbenik1-usp.php");

                }
            }
        }

    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
  
        <title>MPVŠ</title> 
        <meta charset="UTF-8">
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

        <style type="text/css">

            body {
				 background: none;
                 background: url(pozadina.jpg) no-repeat center center fixed; 
				  -webkit-background-size: cover;
				  -moz-background-size: cover;
				  -o-background-size: cover;
				  background-size: cover;
				}

            #logo {
                width: 80px;
                height: 90px;
                }

            #zaglavlje{
                margin:3px;
                margin-left: 10px;
                }
				
            #naslov {
                margin-left:10px;
                margin-top:15px;
                margin-bottom:15px;
                text-align:left;
                font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
                font-size:35px;
                color:#39514c;
                }
            
            #navbar {
                background-color: #39514c;
                font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
                color:#39514c;
                }

            #rpg {
                margin:30px;
                color: #39514c;
                font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
                border-collapse: separate;
                font-size: 20px;
                width: 900px;
                }

            .text {
                padding-top:8px;
                padding-left:30px;
            }

            .textarea {
                width:420px;
                margin-top:10px;
                margin-left:30px;
                background-color: #7fa986;
                color:white;
                font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
                }

            .select{
                width:420px;
                height:30px;
                font-size:18px;
                margin-top:10px;
                margin-left:30px;
                background-color: #7fa986;
                color:white;
                font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
                }

            #msg {
                background-color: red;
				color:black;
                font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
				margin-left:30px;
			    }

            .button2  {
                background-color: #7fa986;
                border: none;
                color: white;
                padding: 10px 24px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px; 
                cursor: pointer;
                border-radius: 4px;
                color: white; 
                }

            .button2:hover {
                background-color: #709f78;
                color: white;
                }
                
            #nzv {
                color:White;
                font-size:27px;
                padding-top:7px;
                padding-bottom:0px;
                }

            .button {
                margin-top: 20px;
                margin-left:310px;
                background-color: #4CAF50;
                border: none;
                color: white;
                padding: 10px 24px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                cursor: pointer;
                border-radius: 4px;
                color: white; 
                }

            .button:hover {
                background-color: green;
                color: white;
                }
        </style>
	</head>
    <body>

        <!-- Logo i naslov-->
            <table id="zaglavlje">
            <tr>
                <td>
                     <img src="logo.png" id="logo">
                </td>
                    
                <td>
                     <p id="naslov"> Ministarstvo poljoprivrede, vodoprivrede i šumarstva</p>
                </td>
            </tr>

        </table>
        
        <!--Navigacijska traka -->
        <nav class="navbar navbar-toggleable-md navbar-light bg-faded" id="navbar">
        
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto nav justify-content-center">
                    <p id="nzv"> UNOS PODATAKA </p>
                </ul>

                <form method="post">
                <?php

                    //logout
                    if(array_key_exists("id", $_SESSION)) {
                    
                        echo "<li>
                        <input type='hidden' name='submit' value='1'>
                            <button name='submit1' type='submit1' class='button button2'>Log out</button>
                        </li>";

                    }else {
                    
                    header("Location: mpvs.php");
                    
                    }
                ?>

                </form>
            </div>
        </nav>

        <!-- Forma za unos podataka -->

        <?php

                    if ($jednako == "true") {

                        //ako postoji korisnik s tim rpgom ispisuje njegove podatke:
                        $sql2 = "SELECT * FROM vlasnik WHERE rpg = $rpg LIMIT 1";
                        $row2 = mysqli_fetch_array(mysqli_query($link, $sql2));

                        echo "<form method='post'>
                        
                        <table>
                        <tr> <td class='text'> Broj protokola: </td><td> <input type='text' name='protokol' class='textarea'></td></tr>
                        <tr> <td class='text'> RPG: </td><td> <input type='text' name='rpg' class='textarea' value='".$row2['rpg']."' readonly></td></tr>
                        <tr> <td class='text'> RK: </td><td> <input type='text' name='rk' class='textarea' value='".$row2['rk']."'></td></tr>
                        <tr> <td class='text'> Ime: </td><td> <input type='text' name='ime' class='textarea' value='".$row2['ime']."'></td></tr>
                        <tr> <td class='text'> Prezime: </td><td> <input type='text' name='prezime' class='textarea' value='".$row2['prezime']."'></td></tr>
                        <tr> <td class='text'> Ulica: </td><td> <input type='text' name='ulica' class='textarea' value='".$row2['ulica']."'></td></tr>
                        <tr> <td class='text'> Broj: </td><td> <input type='text' name='broj' class='textarea' value='".$row2['broj']."'></td></tr>
                        <tr> <td class='text'> Općina/Grad: </td><td> <input type='text' name='opcina' class='textarea' value='".$row2['opcina']."'></td></tr>
                        <tr> <td class='text'> Telefon: </td><td> <input type='text' name='telefon' class='textarea' value='".$row2['telefon']."'></td></tr>
                        ";

                        echo "<tr> <td class='text'> Vrsta proizvodnje: 
                        </td><td>
                            <select name='proizvodnja' class='select'>";

                            $sql3 = "SELECT * FROM rokovi";
                            $result = $link -> query($sql3);
                            while($row3 = $result -> fetch_assoc()){
                                
                                echo"<option value='".$row3['proizvodnja']."'>".$row3['proizvodnja']."</option>";
                            }
                            
                            echo "</select>
                        </td></tr>

                        <tr> <td class='text'> Datum: </td><td> <input type='date' name='datum' class='textarea' value='$date'></td></tr>
                        </table>

                        <input type='hidden' name='submit' value='0'>
                        <button name='update' type='submit' class='button'> Potvrdi </button>

                        </form>";

                    }else {

                        echo "<div class='alert alert-danger' role='alert'>Korisnik sa RPG-om koji ste unijeli ne postoji u bazi. Molimo unesite njegove podatke.</div>";

                        echo "<form method='post'>

                        <table>
                        <tr> <td class='text'> Broj protokola: </td><td> <input type='text' name='protokol' class='textarea'></td></tr>
                        <tr> <td class='text'> RPG: </td><td> <input type='text' name='rpg' class='textarea' value='$rpg_proces' readonly></td></tr>
                        <tr> <td class='text'> RK: </td><td> <input type='text' name='rk' class='textarea'></td></tr>
                        <tr> <td class='text'> Ime: </td><td> <input type='text' name='ime' class='textarea'></td></tr>
                        <tr> <td class='text'> Prezime: </td><td> <input type='text' name='prezime' class='textarea'></td></tr>
                        <tr> <td class='text'> Ulica: </td><td> <input type='text' name='ulica' class='textarea'></td></tr>
                        <tr> <td class='text'> Broj: </td><td> <input type='text' name='broj' class='textarea'></td></tr>
                        <tr> <td class='text'> Općina/Grad: </td><td> <input type='text' name='opcina' class='textarea'></td></tr>
                        <tr> <td class='text'> Telefon: </td><td> <input type='text' name='telefon' class='textarea'></td></tr>";


                        echo "<tr> <td class='text'> Vrsta proizvodnje: 
                        </td><td>
                            <select name='proizvodnja' class='select'>";

                            $sql3 = "SELECT * FROM rokovi";
                            $result = $link -> query($sql3);
                            while($row3 = $result -> fetch_assoc()){
                                
                                echo"<option value='".$row3['proizvodnja']."'>".$row3['proizvodnja']."</option>";
                            }
                            
                            echo "</select> 
                        </td></tr>
                        <tr> <td class='text'> Datum: </td><td> <input type='date' name='datum' class='textarea' value='$date'></td></tr>
                        </table>

                        <input type='hidden' name='submit' value='0'>
                        <button name='insert' type='submit' class='button'> Potvrdi </button>

                        </form>";
                    }
        ?>

    </body>
</html>