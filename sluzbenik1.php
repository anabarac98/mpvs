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

    //prilikom ucitavanja stranice obavlja sljedece:
    if(array_key_exists("id", $_SESSION)) {
                
        $date = date('Y-m-d');
    }   
    
    //na logout
    if(array_key_exists("submit1", $_POST)){
 
        $query = "DELETE FROM rpg_proces";
        $query_run = mysqli_query($link, $query);
        header("Location: mpvs.php?logout=1");

    }

    //na tipku spremi (rpg) obavlja sljedece:
    if (isset($_POST['save_proces'])) {

        $rpg_proces = $_POST['rpg_proces'];

        $query = "INSERT INTO rpg_proces (rpg_proces) VALUES ('$rpg_proces')";
        $query_run = mysqli_query($link, $query);

        if ($query_run) {

            $_SESSION['status'] = "Inserted Sucesfully";
            header ("Location: sluzbenik1-unos.php");

        }

    }

    $date = date('Y-m-d');

    //na tipku spremi (kraj tova) obavlja sljedece:
    if (isset($_POST['save'])) {

        $protokol = $_POST['protokol'];
        if ($protokol == ""){
        
            $msg = "Molimo unesite protokol";

        } else {

            $sql1 = "SELECT * FROM obrazac";
            $result = $link -> query($sql1);
            while($row = $result -> fetch_assoc()){
    
                if ($protokol == $row['protokol']) {

                    $query1 = "UPDATE obrazac SET datum_kraj = '".mysqli_real_escape_string($link, $_POST['datum'])."' WHERE protokol = '".mysqli_real_escape_string($link, $_POST['protokol'])."' ";
                    $query1_run = mysqli_query($link, $query1);
            
                    if ($query1_run) {
            
                        header ("Location: sluzbenik1.php");
            
                    }

                    break;
    
                } else {
    
                    $msg = "Uneseni protokol ne postoji u bazi.";
    
                }
            }
        }
    }


    // SQL query to find total count
    $sql = "SELECT count(*) FROM obrazac ";
    $result = $link->query($sql);
    
    // Display data on web page
    while($row = mysqli_fetch_array($result)) {
        $p1_uneseni = $row['count(*)'];
    }

    if (isset($_POST['insert'])) {

        if ($_POST['protokoll'] == "" or $_POST['ime'] == "" or $_POST['prezime'] == "" or $_POST['ulica'] == "" or $_POST['broj']== "" or $_POST['opcina'] == "" or  $_POST['proizvodnja'] == "" or $_POST['telefon'] == "") { 
 
            echo "<div class='alert alert-danger' role='alert'>Molimo unesite sve podatke.</div>";

        } else {

            $sql1 = "SELECT * FROM obrazac";
            $result = $link -> query($sql1);
            $var = "y";
            
            while($row = $result -> fetch_assoc()){

                if ($_POST['protokoll']==$row['protokol']) {

                    echo "<div class='alert alert-danger' role='alert'> Uneseni protokol već postoji.</div>";
                    $var = "n";
                    break;

                } else {

                    $var = "y";

                }
        
            }

            if ($var == "y") {

                //spremanje podataka o p1 obrascu u tablicu obrazac
                $query = "INSERT INTO obrazac (protokol, ime, prezime, ulica, broj, opcina, telefon, proizvodnja, datum, stanje, status_komplet) VALUES ('".mysqli_real_escape_string($link, $_POST['protokoll'])."', '".mysqli_real_escape_string($link, $_POST['ime'])."', '".mysqli_real_escape_string($link, $_POST['prezime'])."', '".mysqli_real_escape_string($link, $_POST['ulica'])."', '".mysqli_real_escape_string($link, $_POST['broj'])."', '".mysqli_real_escape_string($link, $_POST['opcina'])."', '".mysqli_real_escape_string($link, $_POST['telefon'])."', '".mysqli_real_escape_string($link, $_POST['proizvodnja'])."', '".mysqli_real_escape_string($link, $_POST['datumm'])."', 'Neodrađen', 'Neodrađen') LIMIT 1";
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

            #zaglavlje {
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

            .textarea {
                width:400px;
                margin-top:0px;
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
                margin-left:30px;
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

            .select {
                width:420px;
                height:30px;
                font-size:18px;
                margin-top:10px;
                margin-left:30px;
                background-color: #7fa986;
                color:white;
                font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
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

        <?php 
            echo "<div class='alert alert-info' role='alert'> Broj unesenih P-1 obrazaca: ".$p1_uneseni."</div>";
            if ($msg == "") {
            }else {
                echo "<div class='alert alert-danger' role='alert'>".$msg."</div>";
            }
        ?>
        
        <form method = 'post'>
            <table>
                <tr><p id="rpg"> Molimo unesite RPG korisnika za novi P-1 obrazac:  </p></tr>
                <tr><input type='text' class='textarea' name='rpg_proces'> </tr>
                <tr>
                    <input type='hidden' name='submit' value='0'>
                    <button name='save_proces' type='submit' class='button'> Potvrdi </button>
                </tr>
            </table>
        </from>

        <br><hr>

        <form method = 'post'>
            <table>
                <tr><p id="rpg"> Molimo unesite podatke za završetak tova: </p></tr>
                <tr><td><p id='p'> Broj protokola: </p></td><td><input type='text' class='textarea' name='protokol'></td></tr>
                <tr><td id='p'> Datum: </td><td> <input type='date' name='datum' class='textarea' value="<?php echo $date ?>"></td>
                <td>
                    <input type='hidden' name='submit' value='1'>
                    <button name='save' type='submit' class='button'> Potvrdi </button>
                </td>
                </tr>
            </table>

        </from>

        <hr>
        <form method='post'>

        <tr><p id="rpg"> Molimo unesite podatke za P-1 obrazac (korisnici bez RPG-a): </p></tr>

                        <table>
                        <tr> <td class='text'> Broj protokola: </td><td> <input type='text' name='protokoll' class='textarea'></td></tr>
                        <tr> <td class='text'> Ime: </td><td> <input type='text' name='ime' class='textarea'></td></tr>
                        <tr> <td class='text'> Prezime: </td><td> <input type='text' name='prezime' class='textarea'></td></tr>
                        <tr> <td class='text'> Ulica: </td><td> <input type='text' name='ulica' class='textarea'></td></tr>
                        <tr> <td class='text'> Broj: </td><td> <input type='text' name='broj' class='textarea'></td></tr>
                        <tr> <td class='text'> Općina/Grad: </td><td> <input type='text' name='opcina' class='textarea'></td></tr>
                        <tr> <td class='text'> Telefon: </td><td> <input type='text' name='telefon' class='textarea'></td></tr>
                        <tr><td id='p'> Datum: </td><td> <input type='date' name='datumm' class='textarea' value="<?php echo $date ?>"></td>


                        <tr> <td class='text'> Vrsta proizvodnje: 
                        </td><td>
                            <select name='proizvodnja' class='select'>";

                            <?php
                            $sql3 = "SELECT * FROM rokovi";
                            $result = $link -> query($sql3);
                            while($row3 = $result -> fetch_assoc()){
                                
                                echo"<option class='text' value='".$row3['proizvodnja']."'>".$row3['proizvodnja']."</option>";
                            }
                            ?>

                        </select> 
                        </td></tr>
                        </table>

                        <input type='hidden' name='submit' value='0'>
                        <button name='insert' type='submit' class='button'> Potvrdi </button>

                        </form>

    </body>
</html>