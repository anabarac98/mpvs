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
    
    //na logout
    if(array_key_exists("submit1", $_POST)){
 
        header("Location: mpvs.php?logout=1");

    }

    // ukupno
    $sql = "SELECT count(*) FROM obrazac ";
    $result = $link->query($sql);
    while($row = mysqli_fetch_array($result)) {
        $p1_uneseni = $row['count(*)'];
    }
   
    // odradjeno
    $sql1 = "SELECT count(*) FROM obrazac WHERE stanje = 'Odrađen' ";
    $result1 = $link->query($sql1);
    while($row1 = mysqli_fetch_array($result1)) {
        $p1_odraden_teren = $row1['count(*)'];
    }
   
    // neodradjeno
    $sql2 = "SELECT count(*) FROM obrazac WHERE stanje = 'Neodrađen' ";
    $result2 = $link->query($sql2);
    while($row2 = mysqli_fetch_array($result2)) {
        $p1_neodraden_teren = $row2['count(*)'];
    }
   
    $p1 = "Proizvodnja goveđeg mesa - tov junadi";
    $p2 = "Proizvodnja goveđeg mesa - tov junadi iz uvoza";
    $p3 = "Proizvodnja svinjskog mesa - tov svinja";
   
    // ukupno tovovi
    $sql3 = "SELECT count(*) FROM obrazac WHERE proizvodnja = '$p1' or proizvodnja = '$p2' or proizvodnja = '$p3' ";
    $result3 = $link->query($sql3);
    while($row3 = mysqli_fetch_array($result3)) {
        $p1_uneseni_tovovi = $row3['count(*)'];
    }
       
    // odradjeno tovovi
    $sql4 = "SELECT count(*) FROM obrazac WHERE stanje = 'Odrađen' AND (proizvodnja = '$p1' or proizvodnja = '$p2' or proizvodnja = '$p3') ";
    $result4 = $link->query($sql4);
    while($row4 = mysqli_fetch_array($result4)) {
        $p1_odraden_teren_tovovi = $row4['count(*)'];
    }
       
    // neodradjeno tovovi
    $sql5 = "SELECT count(*) FROM obrazac WHERE stanje = 'Neodrađen' AND (proizvodnja = '$p1' or proizvodnja = '$p2' or proizvodnja = '$p3') ";
    $result5 = $link->query($sql5);
    while($row5 = mysqli_fetch_array($result5)) {
        $p1_neodraden_teren_tovovi = $row5['count(*)'];
    }
   
    // ukupno tovovi
    $sql6 = "SELECT count(*) FROM obrazac WHERE stanje = 'Odrađen' AND status_komplet = 'Odrađen' ";
    $result6 = $link->query($sql6);
    while($row6 = mysqli_fetch_array($result6)) {
        $p1_odradenih_ukupno = $row6['count(*)'];
    }
           
    // odradjeno tovovi
    $sql7 = "SELECT count(*) FROM obrazac WHERE stanje = 'Odrađen' AND status_komplet = 'Odrađen' AND (proizvodnja = '$p1' or proizvodnja = '$p2' or proizvodnja = '$p3') ";
    $result7 = $link->query($sql7);
    while($row7 = mysqli_fetch_array($result7)) {
        $p1_odraden_ukupno_tovovi = $row7['count(*)'];
    }

    $p1_uneseni_ostalo = $p1_uneseni - $p1_uneseni_tovovi;
    $p1_odraden_teren_ostalo = $p1_odraden_teren - $p1_odraden_teren_tovovi;
    $p1_neodraden_teren_ostalo = $p1_neodraden_teren - $p1_neodraden_teren_tovovi;
    $p1_odraden_ukupno_ostalo = $p1_odradenih_ukupno - $p1_odraden_ukupno_tovovi;
    $p1_neodradenih_ukupno = $p1_uneseni - $p1_odradenih_ukupno;
    $p1_neodradenih_ukupno_tovovi = $p1_uneseni_tovovi - $p1_odraden_ukupno_tovovi; 
    $p1_neodradenih_ukupno_ostalo = $p1_uneseni_ostalo - $p1_odraden_ukupno_ostalo; 

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

            #rpg {
                margin:30px;
                color: #39514c;
                font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
                border-collapse: separate;
                font-size: 20px;
                width: 900px;
                }


            #msg {
                background-color: red;
				color:black;
                font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
				margin-left:30px;
			    }

            .button {
                background-color: #4CAF50;
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

            .button:hover {
                background-color: green;
                color: white;
                }

            ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
                overflow: hidden;
                background-color: #333;
                text-decoration: none;
                }

            li {
                float: left;
                width:33.3%;
                }

            li a {
                display: block;
                color: white;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
                color: white;
                }

            li a:hover{
                background-color: #111;
                text-decoration: none;
                color: white;
                }

            .active {
                background-color: #04AA6D;
                text-decoration: none;
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
        <ul class="noPrint">
            <li><a href="sluzbenik3.php">KONAČNO ODRAĐEN P-1 (teren + dokumentacija)</a></li>
            <li><a class="active" href="sluzbenik3-pregled.php">Pregled stanja</a></li>

            <form method = "post">
            <?php
                //logout
                if(array_key_exists("id", $_SESSION)) {
                    
                echo "<li>

                    <div class='btn-group'>
                    <button class='button' onclick='window.print();'> Print </button>

                    <input type='hidden' name='submit' value='1'>
                        <button name='submit1' type='submit1' class='button button2'>Log out</button>
                    </li>";
                    
                }else {
                    
                    header("Location: mpvs.php");
        
                }
            ?>

            </form>
        </ul>
        <?php 
            echo "<br><p id='p'> Ukupno </p><div class='alert alert-info' role='alert'> Broj ukupno unesenih P-1 obrazaca: ".$p1_uneseni."</div>";
            echo "<div class='alert alert-success' role='alert'> Broj odrađenih terena P-1 obrazaca: ".$p1_odraden_teren."</div>";
            echo "<div class='alert alert-danger' role='alert'> Broj neodrađenih terena P-1 obrazaca: ".$p1_neodraden_teren."</div>";
            echo "<div class='alert alert-success' role='alert'> Broj konačno odrađenih P-1 obrazaca (Teren + dokumentacija): ".$p1_odradenih_ukupno."</div>";
            echo "<div class='alert alert-danger' role='alert'> Broj konačno neodrađenih P-1 obrazaca (Teren + dokumentacija): ".$p1_neodradenih_ukupno."</div>";

            echo "<br><p id='p'> Tovovi </p><div class='alert alert-info' role='alert'> Broj unesenih P-1 obrazaca za tovove: ".$p1_uneseni_tovovi."</div>";
            echo "<div class='alert alert-success' role='alert'> Broj odrađenih terena P-1 obrazaca: ".$p1_odraden_teren_tovovi."</div>";
            echo "<div class='alert alert-danger' role='alert'> Broj neodrađenih terena P-1 obrazaca: ".$p1_neodraden_teren_tovovi."</div>";
            echo "<div class='alert alert-success' role='alert'> Broj konačno odrađenih P-1 obrazaca (Teren + dokumentacija): ".$p1_odraden_ukupno_tovovi."</div>";
            echo "<div class='alert alert-danger' role='alert'> Broj konačno neodrađenih P-1 obrazaca (Teren + dokumentacija): ".$p1_neodradenih_ukupno_tovovi."</div>";

            echo "<br><p id='p'> Ostale proizvodnje </p><div class='alert alert-info' role='alert'> Broj unesenih P-1 obrazaca za ostale proizvodnje: ".$p1_uneseni_ostalo."</div>";
            echo "<div class='alert alert-success' role='alert'> Broj odrađenih terena P-1 obrazaca: ".$p1_odraden_teren_ostalo."</div>";
            echo "<div class='alert alert-danger' role='alert'> Broj neodrađenih terena P-1 obrazaca: ".$p1_neodraden_teren_ostalo."</div>";
            echo "<div class='alert alert-success' role='alert'> Broj konačno odrađenih P-1 obrazaca (Teren + dokumentacija): ".$p1_odraden_ukupno_ostalo."</div>";
            echo "<div class='alert alert-danger' role='alert'> Broj konačno neodrađenih P-1 obrazaca (Teren + dokumentacija): ".$p1_neodradenih_ukupno_ostalo."</div>";

        ?>

    <br><br>
    </body>
</html>