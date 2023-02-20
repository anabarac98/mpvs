<?php

	session_start();
	
	$error = "";
	$noterror = "";
	
	//logout forma
	if(array_key_exists("logout", $_GET)) {
			
		unset($_SESSION['id']);
		setcookie("id", "", time () - 60*60);
		$_COOKIE["id"] = "";
			
		} else if (array_key_exists("id", $_SESSION) OR array_key_exists("id", $_SESSION)) { 
			
			header("Location: mpvs/mpvs.php");
		}
		
	if(array_key_exists("submit", $_POST)) {	 

		//Povezivanje s bazom
		$link = mysqli_connect("localhost", "root", "", "mpvs");
		
		if (mysqli_connect_error()) {
			
			die("There was an error connecting to the database");
			
		}

		//Provjera da uneseni podatci nisu prazni
		if ($_POST['email'] == '') {
			
			$error= "<div class='alert alert-danger' role='alert'> Molimo unesite email. </div>";
			
		} else if ($_POST['lozinka'] == '') {
			
			$error= "<div class='alert alert-danger' role='alert'> Molimo unesite lozinku. </div>";
			
		} else {
			
			// Registracija korisnika
			if ($_POST['signUp'] == '0') {

				//provjera da li je email adresa već zauzeta
				$query = "SELECT id FROM korisnik WHERE email = '".mysqli_real_escape_string($link,$_POST['email'])."' LIMIT 1";
				
				$result = mysqli_query($link, $query);
				
				if (mysqli_num_rows($result) > 0) {
					
					$error = "Email adresa je zauzeta.";
					
				} else {
				
					//ukoliko email adresa nije zauzeta dodaj novog korisnika
					$query = "INSERT INTO korisnik (email, lozinka) VALUES ('".mysqli_real_escape_string($link,$_POST['email'])."','".mysqli_real_escape_string($link,$_POST['lozinka'])."')";
								
					if (!mysqli_query($link, $query)) {
						
						$error="Dogodila se neka greška. Molimo pokušajte ponovo.";
					
					} else {
						
						$query= "UPDATE korisnik SET lozinka = '".md5(md5(mysqli_insert_id($link)).$_POST['lozinka'])."' WHERE id = ".mysqli_insert_id($link)." LIMIT 1";
						
						mysqli_query($link,$query);

						$noterror = "Uspješno ste se registrirali. Možete se prijaviti sada."; 

					}
						
				}

			} else {

				//prijava postojećeg korisnika
				//provjera emaila
				$query = "SELECT * FROM korisnik WHERE email='".mysqli_real_escape_string($link, $_POST['email'])."'";
				
				$result= mysqli_query($link, $query);
				
				$row = mysqli_fetch_array($result);
				
				if(isset($row)) {
					
					//osigravanje anonimnosti lozinke
					$hashedPassword = md5(md5($row['id']).$_POST['lozinka']);
					
					print_r($hashedPassword);
					
					print_r ("---");
					print_r($row['lozinka']);
					
					//upućivanje na određenu web adresu ovisno o korisniku
					if ($hashedPassword == $row['lozinka']) {
						
						$_SESSION['id'] = $row['id'];
						
						if($_POST['ostaniprijavljen'] == '1') {
					
							setcookie("id", mysqli_insert_id($link), time() + 60*60);
					
						} if($_POST['email'] == "sluzbenik1@mpvs") {
					
							header("Location:sluzbenik1.php");

                        } elseif ($_POST['email'] == "sluzbenik2@mpvs") {
					
							header("Location:sluzbenik2-tim.php");
                            
                        } elseif ($_POST['email'] == "sluzbenik3@mpvs") {
					
							header("Location:sluzbenik3.php");

                        } elseif ($_POST['email'] == "admin@mpvs") {
					
							header("Location:admin.php");

                        } else {
							
							$error = "Taj korisnik ne postoji, molimo provjerite unešene podatke.";
							
						}
						
					} else {
						
						$error = "Netočna lozinka";
						
					}
					
				} else {
					
					$error = "Netočan email";

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
					
            #zaglavlje{
                margin:2px;
                margin-left: 30px;
                }

			#naslov {
				color:#394a51;
				text-align: center;
				margin-left: 20px;
				margin-top: 30px;
				font-size: 60px;
				}
				
            #logo {
                width: 110px;
                height:100px;
                }

			#login { 
				margin-top:150px;
				margin-left:400px;
				background-color: #7fa986;
				}
				
			#ObrazacZaPrijavu{
				padding:20px;
				border-color:white;
				border-width:2px;
				color: white;
                font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
				}
				
			#s {
                font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
				}
							
            .button {
                background-color: #39514c;
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
                background-color: #394a51;
                color: white;
                }


		</style>
	</head>
    <body>
  

        <?php 
		//ispisivanje eror poruke
        if($error != ""){
            echo "<div class='alert alert-danger' role='alert'>".$error."</div>";
        }else {
            echo " ";
        }
        ?>

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
        
		<!--Forma za prijavu -->
        <table class="table-bordered" id="login">
            <td class="table-active" id="ObrazacZaPrijavu">
    
                <div class="login">
                    <p id="s"><strong> Molimo unesite Vaše podatke za prijavu. </strong></p>
                    <form method="post" >
                        <div class="form-group row">
                            <label for="example-text-input" class="col-3 col-form-label">Email:</label>
                            <div class="col-7">
                                <input name="email" class="form-control" type="text" placeholder="" id="example-text-input">
                            </div>
                        </div>
    
                        <div class="form-group row">
                            <label for="example-password-input" class="col-3 col-form-label">Lozinka:</label>
                            <div class="col-7">
                                <input name="lozinka"class="form-control" type="password" placeholder="" id="example-password-input">
                            </div>
                        </div>
                            <p id="s"> <input type="checkbox" name="ostaniprijavljen" value=1> Ostani prijavljen/a </p>
                            <input type="hidden" name="signUp" value="1">
                            <button name="submit" type="submit" class="button">Prijavi se</button>
                    </form>
                </div>
            
        
            </td>

        	<!-- Forma za registraciju. -->
			
            <!--
            <td class="table-active" id="dio">
				<div>
					<p id="s"> Don't have an account? <strong> Sign up! </strong></p>
						<form method="post">
							<div class="form-group row">
								<label for="example-text-input" class="col-3 col-form-label">Email:</label>
								<div class="col-7">
								<input name="email" class="form-control" type="text" placeholder="" id="example-text-input">
								</div>
							</div>
							<div class="form-group row">
								<label for="example-password-input" class="col-3 col-form-label">Password:</label>
								<div class="col-7">
								<input name="lozinka" class="form-control" type="password" placeholder="" id="example-password-input">
								</div>
							</div>

							<input type="hidden" name="signUp" value="0">
							<button name="submit" type="submit" class='button'>Sign up</button>
						</form>
		    	</div>
            </td>
            -->

        </table>   

        <!-- jQuery first, then Tether, then Bootstrap JS. -->
        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    </body>
</html>