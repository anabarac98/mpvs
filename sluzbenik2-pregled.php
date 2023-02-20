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

    //na tipku spremi obavlja sljedece:
    if (isset($_POST['save_proces'])) {

        $query1 = "UPDATE timovi SET osobe = '".mysqli_real_escape_string($link, $_POST['osobe'])."' WHERE tim = '".mysqli_real_escape_string($link, $_POST['tim'])."' LIMIT 1";
        $query1_run = mysqli_query($link, $query1);

        if ($query1_run) {

            header ("Location: sluzbenik2-t.php");

        }

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

    $p1_uneseni_ostalo = $p1_uneseni - $p1_uneseni_tovovi;
    $p1_odraden_teren_ostalo = $p1_odraden_teren - $p1_odraden_teren_tovovi;
    $p1_neodraden_teren_ostalo = $p1_neodraden_teren - $p1_neodraden_teren_tovovi;


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
                padding: 6px 20px;
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
            
            #rpg {
                border:none;
                width: 100px;
                font-size: 15px;
                padding:0px;
                margin:0px;
            }

            * {
                box-sizing: border-box;
                }

            #myInput {
                background-image: url('https://www.w3schools.com/css/searchicon.png');
                background-position: 10px 10px;
                background-repeat: no-repeat;
                width: 100%;
                font-size: 16px;
                padding: 12px 20px 12px 40px;
                border: 1px solid #ddd;
                margin-bottom: 12px;
                }

            #myTable {
                border-collapse: collapse;
                width: 100%;
                border: 1px solid #ddd;
                font-size: 18px;
                }

            #myTable th, #myTable td {
                text-align: left;
                padding: 12px;
                }

            #myTable tr {
                border-bottom: 1px solid #ddd;
                }

            #myTable tr.header, #myTable tr:hover {
                background-color: #f1f1f1;
                }
            
            .btn-group button {
                color: white; /* White text */
                cursor: pointer; /* Pointer/hand icon */
                float: left; /* Float the buttons side by side */
                font-size: 15px;

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
                width:16.6%;
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
            /* Clear floats (clearfix hack) */
            .btn-group:after {
                content: "";
                clear: both;
                display: table;
                }

            .btn-group button:not(:last-child) {
                border-right: none; /* Prevent double borders */
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

                @media print {
            .noPrint{
                display:none;
            }
            }
            h1{
            color:#f6f6;
            }

            #p {
                margin-left:5px;
                font-weight:bold;
            }

        </style>
	</head>
    <body>

        <!-- Logo i naslov-->
            <table id="zaglavlje" class="noPrint">
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
        <li><a href="sluzbenik2-tim.php">Slanje timova na teren</a></li>
            <li><a href="sluzbenik2-tovovi.php">Slanje timova na teren - tovovi</a></li>
            <li><a href="sluzbenik2.php">Promjena statusa u odrađeno</a></li>
            <li><a class="active" href="sluzbenik2-pregled.php">Pregled</a></li>
            <li><a href="sluzbenik2-t.php">Postavljanje timova</a></li>

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

            echo "<br><p id='p'> Tovovi </p><div class='alert alert-info' role='alert'> Broj unesenih P-1 obrazaca za tovove: ".$p1_uneseni_tovovi."</div>";
            echo "<div class='alert alert-success' role='alert'> Broj odrađenih terena P-1 obrazaca: ".$p1_odraden_teren_tovovi."</div>";
            echo "<div class='alert alert-danger' role='alert'> Broj neodrađenih terena P-1 obrazaca: ".$p1_neodraden_teren_tovovi."</div>";

            echo "<br><p id='p'> Ostale proizvodnje </p><div class='alert alert-info' role='alert'> Broj unesenih P-1 obrazaca za ostale proizvodnje: ".$p1_uneseni_ostalo."</div>";
            echo "<div class='alert alert-success' role='alert'> Broj odrađenih terena P-1 obrazaca: ".$p1_odraden_teren_ostalo."</div>";
            echo "<div class='alert alert-danger' role='alert'> Broj neodrađenih terena P-1 obrazaca: ".$p1_neodraden_teren_ostalo."</div>";
        ?>

    </body>
</html>