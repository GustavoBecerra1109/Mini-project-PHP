<?php
session_start();
$nameErr = $emailErr = $addressErr = $contactErr = $lastnameErr = $DNIErr = $countryErr= "";
$name = $email = $address = $contact = $lastname = $DNI = $country = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["name"])) {//nombre
		$nameErr = "Por favor, ingrese sus nombres";
	}else{
		if (!preg_match("/^[a-zA-Z ]*$/", $name)){
			$nameErr = "Solo letras y espacios";
			$name = "";
		}else{
			$name = $_POST['name'];

			if (empty($_POST["lastname"])) {
				$lastnameErr = "Por favor, ingrese sus apellidos";
			}else{
				if (!preg_match("/^[a-zA-Z ]*$/", $lastname)){
					$lastnameErr = "Solo letras y espacios";
					$lastname="";
				}else{
					$lastname=$_POST['lastname'];

					if (empty($_POST["dni"])) {
						$DNIErr = "Por favor, ingrese su DNI";
					}else{
						if(!preg_match("/^[0-9 -]*$/", $DNI)){
							$DNIErr = "Ingrese su DNI nuevamente";
							$DNI = "";
						}else{
							$DNI = $_POST['dni'];
							if (empty($_POST["email"])){
								$emailErr = "Por favor, ingrese su email";
							}else{
								if (filter_var($email, FILTER_VALIDATE_EMAIL)){
									$emailErr = "Formato de email incorrecto";
									$email = "";
								}else{
									$email = $_POST['email'];
									if (empty($_POST["contact"])){
										$contactErr = "Por favor, ingrese un número de contacto";
									}else{
										if(!preg_match("/^[0-9 -]*$/", $contact)){
											$contactErr = "Ingrese un número de celular válido";
											$contact = "";
										}else{
											$contact = $_POST['contact'];
											if (empty($_POST["pais"])){
												$countryErr = "El país es requerido!";
												$country = "";
											}else{
												$country = $_POST['pais'];
												if (empty($_POST["address"])){
													$addressErr = "Por favor, ingrese su dirección";
													$address = "";
												}else{
													$address = $_POST['address'];
													$hostname = 'database-project.cyehfteiydbz.us-east-1.rds.amazonaws.com';
													$user = 'admin';
													$password = '7E1cZlEa3EdRVYbxof7o';
													$database = 'BuscaLibre';
													$port = 3306;
													$conn = new mysqli($hostname, $user, $password, $database, $port);
													if ($conn->connect_error) {
													    die("Connection failed: " . $conn->connect_error);
													} 
													$sql = "USE BuscaLibre";
													$conn->query($sql);
													$sql = "INSERT INTO CLIENTES(NOMBRE, APELLIDO, DIRECCIÓN, CORREO, PAÍS, CELULAR, DNI) 
													VALUES('".$name."', '".$lastname."', '".$address."', '".$email."', '".$country."', '".$contact."', '".$DNI."')";
													$conn->query($sql);
													header("Location:index.php");
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}
}												
function test_input($data){
	$data = trim($data);
	$data = stripcslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>
<html>
<link rel="stylesheet" href="style.css">
<body>
<header>
<blockquote>
	<a href="index.php"><img src="image/logo.png"></a>
</blockquote>
</header>
<blockquote>
<div class="container">
<form method="post"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<h1>Register:</h1>
	Names:<br><input type="text" name="name" placeholder="Names">
	<span class="error" style="color: red; font-size: 0.8em;"><?php echo $nameErr;?></span><br><br>

	Last Names:<br><input type="text" name="lastname" placeholder="Lastnames">
	<span class="error" style="color: red; font-size: 0.8em;"><?php echo $lastnameErr;?></span><br><br>

	DNI:<br><input type="text" name="dni" placeholder="DNI">
	<span class="error" style="color: red; font-size: 0.8em;"><?php echo $DNIErr;?></span><br><br>

	E-mail:<br><input type="text" name="email" placeholder="example@email.com">
	<span class="error" style="color: red; font-size: 0.8em;"><?php echo $emailErr;?></span><br><br>

	Mobile Number:<br><input type="text" name="contact" placeholder="123-456-789">
	<span class="error" style="color: red; font-size: 0.8em;"><?php echo $contactErr;?></span><br><br>

	<label for="pais">País de origen:</label><br>
	<select name="pais" id="pais">
        <option value="Perú">Perú</option>
        <option value="EEUU">EEUU</option>
        <option value="UK">UK</option>
        <option value="Brasil">Brasil</option>
        <option value="España">España</option>
        <option value="México">México</option>
        <option value="Uruguay">Uruguay</option>
    </select>
	<span class="error" style="color: red; font-size: 0.8em;"><?php echo $countryErr;?></span><br><br>
	
	<label>Address:</label><br>
    <textarea name="address" cols="50" rows="5" placeholder="Address"></textarea>
    <span class="error" style="color: red; font-size: 0.8em;"><?php echo $addressErr;?></span><br><br>

	<input class="button" type="submit" name="submitButton" value="Submit">
	<input class="button" type="button" name="cancel" value="Cancel" onClick="window.location='index.php';" />
</form>
</div>
</blockquote>
</center>
</body>
</html>