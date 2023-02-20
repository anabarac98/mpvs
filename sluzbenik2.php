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

        $query1 = "UPDATE obrazac SET stanje = 'Odrađen' WHERE protokol = '".mysqli_real_escape_string($link, $_POST['protokol'])."' LIMIT 1";
        $query1_run = mysqli_query($link, $query1);

        if ($query1_run) {

            header ("Location: sluzbenik2.php");

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
                margin-left:130px;
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

                .btn-group button {
                color: white; /* White text */
                cursor: pointer; /* Pointer/hand icon */
                float: left; /* Float the buttons side by side */
                font-size: 15px;

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
        
        <ul class="noPrint">
            <li><a href="sluzbenik2-tim.php">Slanje timova na teren</a></li>
            <li><a href="sluzbenik2-tovovi.php">Slanje timova na teren - tovovi</a></li>
            <li><a class="active"  href="sluzbenik2.php">Promjena statusa u odrađeno</a></li>
            <li><a href="sluzbenik2-pregled.php">Pregled</a></li>
            <li><a href="sluzbenik2-t.php">Postavljanje timova</a></li>

            <form method = "post">
            <?php
                //logout
                if(array_key_exists("id", $_SESSION)) {
                    
                echo "<li>
                <div class='btn-group'>
                <button class='button' class='noPrint' onclick='window.print();'> Print </button>

                    <input type='hidden' name='submit' value='1'>
                        <button name='submit1' type='submit1' class='button button2'>Log out</button>
                    </li>";
                    
                }else {
                    
                    header("Location: mpvs.php");
        
                }
            ?>

            </form>
        </ul>

        <br>
        <p style="margin-left:10px;font-weight:bold;" class="noPrint"> LISTA P-1 OBRAZACA GDJE NIJE OBAVLJEN TEREN - ZAMJENA U 'ODRAĐEN' </p>
        <br>

        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Pretraži ovdje..." class="noPrint">
        <table style='width:100%'>
            
            <tr class="header" style="background-color:black;color:white;text-align:center;font-size:14px;" }>
                <th style='width:5%'>PROTOKOL</th>
                <th style='width:7.5%'>IME I PREZIME</th>
                <th style='width:6%'>TELEFON</th>
                <th style='width:6.5%'>ULICA</th>
                <th style='width:3.5%'>BROJ</th>
                <th style='width:9%'>OPĆINA/GRAD</th>
                <th style='width:10%'>PROIZVODNJA</th>
                <th style='width:7%'>DATUM POČETKA</th>
                <th style='width:7%'>KRAJNJI ROK ZA SAČINJAVANJE ZAPISNIKA</th>
                <th style='width:7.5%'>DATUM ZAVRŠETKA</th>
                <th style='width:6.5%'>KRAJNJI ROK ZA SAČINJAVANJE ZAPISNIKA</th>
                <th style='width:9%'>ROK ZA KRAJ TOVA</th>
                <th style='width:3.5%'>TEREN</th>
                <th style='width:6%;text-align:center;'>TRENUTNI TIM</th>
                <th style='width:4.5%' class='noPrint'>DODIJELI TIM</th>
                <th></th>
            </tr>

            </table>
            <table id='myTable'>
            <?php

                $n = 1;
                //dohvacanje rpg kojeg je unio sluzbenik 1 ORDER BY kanton DESC, opcina DESC, ulica DESC, broj DESC, prezime DESC, ime DESC
                $sql = "SELECT * FROM obrazac WHERE stanje = 'Neodrađen' AND tim !='' ORDER BY opcina ASC, ulica ASC, broj ASC, prezime ASC, ime ASC";
                $result = $link -> query($sql);
                while($row = $result -> fetch_assoc()){
        
                    if($n % 2 == 0) {
                        $style = "background-color:#dfd3c3;border-bottom:1px solid black;";
                    } else {
                        $style = "background-color:#fde9df;border-bottom:1px solid black";
                    }

                    //dohvacanje zadnjeg protokola

                    $proizvodnja = $row['proizvodnja'];

                    $query1 = "SELECT * FROM rokovi WHERE proizvodnja = '$proizvodnja' LIMIT 1";
    
                    if($result1 = mysqli_query ($link, $query1)) {
                                
                        $row1 = mysqli_fetch_array($result1);
                        $rok_zapisnik = $row1['rok_zapisnik'];
                        $rok_tova = $row1['rok_tova'];

                        $rok_zapisnik = (int) $rok_zapisnik;
                        $rok_tova = (int) $rok_tova;


                        $mysqldate = $row['datum'];
                        $phpdate = strtotime( $mysqldate );
                        $mysqldate = date( 'd.m.Y', $phpdate );

                        $dt = new DateTimeImmutable($mysqldate, new DateTimeZone("Europe/Zagreb"));
                        $dt = $dt->modify("+$rok_zapisnik days");

                        $dtt = new DateTimeImmutable($mysqldate, new DateTimeZone("Europe/Zagreb"));
                        $dtt = $dtt->modify("+$rok_tova days");

                        if (is_null($row['datum_kraj'])) {
                                
                            $dkt = "-";
                        
                        } else {

                            $mysqldatek = $row['datum_kraj'];
                            $phpdatek = strtotime( $mysqldatek );
                            $mysqldatek = date( 'd.m.Y', $phpdatek );
    
                            $dkt = new DateTimeImmutable($mysqldatek, new DateTimeZone("Europe/Zagreb"));
                            $dkt = $dkt->modify("+$rok_zapisnik days"); 
                    
                        }
                    
                    } 

                    echo "<form method ='post'>

                    <tr style='".$style."; font-size:16px;'>
                        <td style='padding:4px;width:4%;'><input style='".$style.";width:100px;border:none;' type='hidden' name='protokol' value='".$row['protokol']."'readonly> ".$row['protokol']." </td>
                        <td style='width:7%;'>".$row['ime']." ".$row['prezime']."</td>
                        <td style='width:6%;'>".$row['telefon']."</td>
                        <td style='width:6.5%'>".$row['ulica']."</td>
                        <td style='width:3%'>".$row['broj']."</td>
                        <td style='width:8%'>".$row['opcina']."</td>
                        <td style='width:10%'>".$row['proizvodnja']."</td>
                        <td style='width:6.5%'>".$mysqldate."</td>";

                        //DATUM POČETKA I ROK ZA ZAPISNIK OD POČETKA
                        if ($row1['rok_zapisnik'] == "-" or $row1['rok_zapisnik'] == "" or $row1['rok_zapisnik'] == "" or $row1['rok_zapisnik'] == "/" ){

                            echo "<td style='width:7%;text-align:center;'> - </td>";

                        } else {
                                
                            echo "<td style='width:7%'>".$dt->format('d.m.Y.')."</td>";

                        }

                        //DATUM ZAVRSETKA I ROK ZA ZAPISNIK OD ZAVRSETKA
                        if (is_null($row['datum_kraj'])) {

                            echo "<td style='width:6.5%';text-align:center;> - </td>
                            <td style='width:6.5%;text-align:center;'> - </td>";
                    
                        } else {
                                                        
                            echo "<td style='padding:4px;text-align:center;width:6.5%'>".$mysqldatek."</td>";
                            echo "<td style='width:6.5%'>".$dkt->format('d.m.Y.')."</td>";
                        
                        }

                        //DATUM ZA KRAJ TOVA
                        if ($row1['rok_tova'] == "-" or $row1['rok_tova'] == "" or $row1['rok_tova'] == "" or $row1['rok_tova'] == "/" ){

                            echo "<td style='width:7.5%;text-align:center;'> - </td>";

                        } else {
                                
                            echo "<td style='width:7.5%'>".$dtt->format('d.m.Y.')."</td>";

                        }
                        echo "<td style='width:4%'>".$row['stanje']."</td>
                        <td style='width:4%'>".$row['tim']."</td>
                        <td style='width:4%'>
                        <input type='hidden' name='submit' value='0'>
                        <button name='save_proces' type='submit' class='button noPrint'> Odrađen </button>
                        </td>
                    </tr>
                    
                    </form>";

                    $n++;
                }

            ?>

        </table>
        <script>

            const searchInput = document.querySelector('#myInput');
            const tableRows = document.querySelector('#myTable').querySelectorAll('tr');

            searchInput.addEventListener('input', (e) => {
            const searchInputValue = e.target.value.toLowerCase();
            tableRows.forEach(row => {
                const doesRowMatch = row.textContent.toLowerCase().includes(searchInputValue);
                if (doesRowMatch) {
                row.style.display = 'table-row';
                } else {
                row.style.display = 'none';
                }
            })
            })
                
        </script>

    </body>
</html>