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

        $tim = mysqli_real_escape_string($link, $_POST['timovi'])." ";
        $query1 = "UPDATE obrazac SET tim = '$tim' WHERE protokol = '".mysqli_real_escape_string($link, $_POST['protokol'])."' ";
        $query1_run = mysqli_query($link, $query1);

        if ($query1_run) {

            header ("Location: sluzbenik2-tim.php");

        }

    }

    if (isset($_POST['zamijeni'])) {

        $tim = mysqli_real_escape_string($link, $_POST['timm'])." ";
        $query1 = "UPDATE obrazac SET tim = '".mysqli_real_escape_string($link, $_POST['timm'])."' WHERE protokol = '".mysqli_real_escape_string($link, $_POST['protokol'])."' ";
        $query1_run = mysqli_query($link, $query1);

        if ($query1_run) {

            header ("Location: sluzbenik2-tim.php");

        }

    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
  
        <title>MPVŠ</title> 
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                margin-left:0px;
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

            li a:hover {
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
        
        <!-- Navbar -->
        <ul class="noPrint">
            <li><a class="active" href="sluzbenik2-tim.php">Slanje timova na teren</a></li>
            <li><a href="sluzbenik2-tovovi.php">Slanje timova na teren - tovovi</a></li>
            <li><a href="sluzbenik2.php">Promjena statusa u odrađeno</a></li>
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
        <p style="margin-left:10px;font-weight:bold;" class="noPrint"> LISTA P-1 OBRAZACA GDJE NIJE OBAVLJEN TEREN </p>
        <br>

        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Pretraži ovdje..." class="noPrint">
        <br><br>
        <table style='width:100%'>
            
            <tr class="header" style="background-color:black;color:white;text-align:center;font-size:14px;" }>
                <th style='width:6%'>BROJ PROTOKOLA</th>
                <th style='width:9.5%'>IME I PREZIME</th>
                <th style='width:7%'>TELEFON</th>
                <th style='width:6.5%'>ULICA</th>
                <th style='width:2.5%'>BROJ</th>
                <th style='width:10%'>OPĆINA/GRAD</th>
                <th style='width:20%'>PROIZVODNJA</th>
                <th style='width:6.5%'>DATUM PODNOŠENJA</th>
                <th style='width:7%'>KRAJNJI ROK ZA SAČINJAVANJE ZAPISNIKA</th>
                <th style='width:5%'>TEREN</th>
                <th style='width:4%;text-align:center;'>TRENUTNI TIM</th>
                <th style='width:4.5%' class='noPrint'>DODIJELI TIM</th>
                <th></th>
            </tr>

            </table>
            <table id='myTable'>
            <?php

                $n = 1;
                //dohvacanje rpg kojeg je unio sluzbenik 1 ORDER BY kanton DESC, opcina DESC, ulica DESC, broj DESC, prezime DESC, ime DESC
                $sql = "SELECT * FROM obrazac WHERE stanje = 'Neodrađen' ORDER BY opcina ASC, ulica ASC, broj ASC, prezime ASC, ime ASC";
                $result = $link -> query($sql);
                while($row = $result -> fetch_assoc()){
        
                    if($n % 2 == 0) {
                        $style = "background-color:#dfd3c3;border-bottom:1px solid black;";
                    } else {
                        $style = "background-color:#fde9df;border-bottom:1px solid black";
                    }

                    $proizvodnja = $row['proizvodnja'];
 
                    if ($proizvodnja == 'Proizvodnja goveđeg mesa - tov junadi' or $proizvodnja == 'Proizvodnja goveđeg mesa - tov junadi iz uvoza' or $proizvodnja == 'Proizvodnja svinjskog mesa - tov svinja' ){
                        
                        //ne ispisuj nista.

                    }else {

                        $query1 = "SELECT * FROM rokovi WHERE proizvodnja = '$proizvodnja' LIMIT 1";
    
                        if($result1 = mysqli_query ($link, $query1)) {
                                    
                            $row1 = mysqli_fetch_array($result1);
                            $rok_zapisnik = $row1['rok_zapisnik'];
    
                            $rok_zapisnik = (int) $rok_zapisnik;
    
                            $mysqldate = $row['datum'];
                            $phpdate = strtotime( $mysqldate );
                            $mysqldate = date( 'd.m.Y', $phpdate );
    
                            $dt = new DateTimeImmutable($mysqldate, new DateTimeZone("Europe/Zagreb"));
                            $dt = $dt->modify("+$rok_zapisnik days");
                        
                        } 

                        echo "<form method ='post'>

                        <tr style='".$style."; font-size:16px;'>
                            <td style='padding:4px;width:6%;'><input style='".$style.";width:7%;border:none;' type='hidden' name='protokol' value='".$row['protokol']."'readonly> ".$row['protokol']." </td>
                            <td style='padding:4px;width:9.5%;'>".$row['ime']." ".$row['prezime']."</td>
                            <td style='padding:4px;width:7%;'>".$row['telefon']."</td>
                            <td style='padding:4px;width:6.5%;'>".$row['ulica']."<input style='".$style.";border:none;width:10px;font-size:16px;' type='hidden' name='ulica' value='".$row['ulica']."'readonly> </td>
                            <td style='padding:4px;width:2%;''>".$row['broj']."</td>
                            <td style='padding:4px;width:10%;'>".$row['opcina']."<input style='".$style.";border:none;font-size:16px;width:13%;' type='hidden' name='opcina' value='".$row['opcina']."'readonly> </td>
                            <td style='padding:4px;width:20%;'>".$row['proizvodnja']."</td>
                            <td style='padding:4px;width:6.5%'>".$mysqldate."</td>";
                            if ($row1['rok_zapisnik'] == "-" or $row1['rok_zapisnik'] == "" or $row1['rok_zapisnik'] == "" or $row1['rok_zapisnik'] == "/" ){

                                echo "<td style='width:7%'> - </td>";
    
                            } else {
                                    
                                echo "<td style='width:7%'>".$dt->format('d.m.Y.')."</td>";
    
                            }
                            

                            echo "<td style='width:5%;padding:4px;text-align:center;'>".$row['stanje']."</td>
                            <td style='width:5%;padding:4px;text-align:center;'>".$row['tim']."</td>";


                            if($row['tim']=="") {
                            echo "<td class='noPrint'>
                            <select name='timovi' class='form-control' style='width:100px;align:center;'>";

                                $sql3 = "SELECT * FROM timovi";
                                $result3 = $link -> query($sql3);
                                while($row3 = $result3 -> fetch_assoc()){
                                    
                                    echo"<option value='".$row3['tim']."'>".$row3['tim']."</option>";
                                }
                                
                            echo "</select>
                            </td>";

                            echo "<td style='width:20px;padding:4px;'>
                            <input type='hidden' name='submit' value='0'>
                            <button name='save_proces' type='submit' class='button noPrint'> Dodjeli tim</button>
                            </td>";

                            } else {
                                
                                echo "<td class='noPrint'>
                                <select name='timovi' class='form-control' style='width:100px;align:center;'>";
        
                                    $sql3 = "SELECT * FROM timovi";
                                    $result3 = $link -> query($sql3);
                                    while($row3 = $result3 -> fetch_assoc()){
                                        
                                        echo"<option value='".$row3['tim']."'>".$row3['tim']."</option>";
                                    }
                                    
                                echo "</select>
                                </td>";
        
                                echo "<td style='width:20px;padding:4px;'>
                                <input type='hidden' name='submit' value='0'>
                                <button name='save_proces' type='submit' class='button noPrint'> Dodjeli tim</button>
                                </td>";


                            }

                        echo "</tr>
                        
                        </form>";
                    }

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
                row.style.display = 'table-th';
                } else {
                row.style.display = 'none';
                }
            })
            })
                
        </script>

    </body>
</html>