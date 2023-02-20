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

        $query1 = "UPDATE rokovi SET proizvodnja = '".mysqli_real_escape_string($link, $_POST['proizvodnja'])."', rok  = '".mysqli_real_escape_string($link, $_POST['rok'])."', rok_zapisnik  = '".mysqli_real_escape_string($link, $_POST['rok_zapisnik'])."', rok_tova  = '".mysqli_real_escape_string($link, $_POST['rok_tova'])."' WHERE id = '".mysqli_real_escape_string($link, $_POST['id'])."' LIMIT 1";
        $query1_run = mysqli_query($link, $query1);

        if ($query1_run) {

            header ("Location: admin-proizvodnje.php");

        }

    }

    //na tipku spremi obavlja sljedece:
    if (isset($_POST['dodaj'])) {

        $query1 = "INSERT INTO rokovi (proizvodnja, rok, rok_zapisnik, rok_tova) VALUES ('".mysqli_real_escape_string($link, $_POST['proizvodnja'])."','".mysqli_real_escape_string($link, $_POST['rok'])."', '".mysqli_real_escape_string($link, $_POST['rok_zapisnik'])."', '".mysqli_real_escape_string($link, $_POST['rok_tova'])."') LIMIT 1";
        $query1_run = mysqli_query($link, $query1);
    
        if ($query1_run) {
    
            header ("Location: admin-proizvodnje.php");
    
        }
    
    }    

    //brisanje
    if (isset($_POST['delete'])) {

        $query = "DELETE FROM rokovi WHERE id = '".mysqli_real_escape_string($link, $_POST['id'])."' LIMIT 1";
        $query_run = mysqli_query($link, $query);
    
        if ($query_run) {
    
            header ("Location: admin-proizvodnje.php");
    
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
        
        <!--Navigacijska traka -->
        <ul>
            <li><a href="admin.php"> Ukupan pregled</a></li>
            <li><a class="active" href="admin-proizvodnje.php">Proizvodnje</a></li>
            <li><a href="sluzbenik1.php">Unos</a></li>
            <li><a href="sluzbenik2.php">Slanje na teren</a></li>
            <li><a href="sluzbenik3.php"> Promjena statusa u odrađeno</a></li>

            <form method = "post">
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
        </ul>

        <br>
        <p style="margin-left:10px;font-weight:bold;" class="noPrint"> UREDI ILI OBRIŠI POSTOJEĆE PROIZVODNJE I ROKOVE</p>
        <br>

        <table id="myTable">
            
            <tr class="header" style="background-color:black;color:white;text-align:center;font-size:15px;" }>
                <th style='width:50%;'>PROIZVODNJA</th>
                <th style='width:12%;'>KRAJNJI ROK</th>
                <th style='width:12%;'>ROK ZA SAČINJAVANJE ZAPISNIKA</th>
                <th style='width:12%;'>ROK ZA KRAJ TOVA</th>
                <th style='width:12%;'></th>
            </tr>

            <?php

                $n = 1;
                //dohvacanje rpg kojeg je unio sluzbenik 1 ORDER BY kanton DESC, opcina DESC, ulica DESC, broj DESC, prezime DESC, ime DESC
                $sql = "SELECT * FROM rokovi ";
                $result = $link -> query($sql);
                while($row = $result -> fetch_assoc()){

                    if($n % 2 == 0) {
                        $style = "background-color:#dfd3c3;border-bottom:1px solid black;";
                    } else {
                        $style = "background-color:#fde9df;border-bottom:1px solid black";
                    }

                    echo "<form method ='post'>

                    <tr style='$style;font-size:16px;' >
                        <input type='hidden' name='id' value='".$row['id']."'>
                        <td style='$style;padding:4px;width:50%;'><input type='text' style='$style;border:none;width:100%;' name='proizvodnja' value='".$row['proizvodnja']."'> </td>
                        <td style='$style;padding:4px;width:12%;'><input type='text' style='$style;border:none;' name='rok' value='".$row['rok']."'> </td>
                        <td style='$style;padding:4px;width:12%;'><input type='text' style='$style;border:none;' name='rok_zapisnik' value='".$row['rok_zapisnik']."'> </td>
                        <td style='$style;padding:4px;width:12%;'><input type='text' style='$style;border:none;' name='rok_tova' value='".$row['rok_tova']."'> </td>
                        <td>
                            <input type='hidden' name='submit' value='0'>
                            <button name='save_proces' type='submit' class='button noPrint'> Potvrdi </button>
                            
                            <input type='hidden' name='submit' value='1'>
                            <button name='delete' type='submit' class='button noPrint'> Obriši </button>
                        </td>
                        
                    </tr>
                    
                    </form>";

                    $n++;
                }

            ?>
        </table>

        <br><br>
        <p style="margin-left:10px;font-weight:bold;" class="noPrint"> DODAJ NOVU PROIZVODNJU</p>

        <form method ="post">
            <table class="noPrint" style="margin:2px;padding-left:5px;">

            <tr class="header" style="background-color:black;color:white;text-align:center;font-size:15px;" }>
                <th>PROIZVODNJA</th>
                <th>KRAJNJI ROK</th>
                <th style='$style;padding:4px;width:360px;'>ROK ZA SAČINJAVANJE ZAPISNIKA</th>
                <th>ROK ZA KRAJ TOVA</th>
                <th></th>
            </tr>

            <tr style='background-color:lightblue;padding:4px;'>
                        <td style='padding:4px;'><input type='text' style='background-color:lightblue;border:1px solid white;width:800px;' name='proizvodnja'> </td>
                        <td style='$style;padding:4px;'><input type='text' style='background-color:lightblue;border:1px solid white;width:300px;' name='rok'> </td>
                        <td style='$style;padding:4px;width:160px;'><input type='text' style='background-color:lightblue;border:1px solid white;width:60px;' name='rok_zapisnik'> </td>
                        <td style='$style;padding:4px;'><input type='text' style='background-color:lightblue;border:1px solid white;width:200px;' name='rok_tova'> </td>
                        <td>
                            <input type='hidden' name='submit' value='2'>
                            <button name='dodaj' type='submit' class='button'> Dodaj </button>
                        </td>
                    </tr>
            
            </table>
        </form>

        <br><br>
        <script>
                
        </script>

    </body>
</html>