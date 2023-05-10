<html>
<meta http-equiv="Content-Type"'.' content="text/html; charset=utf8"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css">
<body>
<?php
session_start();
	if(isset($_POST['ac'])){
		$hostname = 'database-project.cyehfteiydbz.us-east-1.rds.amazonaws.com';
		$user = 'admin';
		$password = '7E1cZlEa3EdRVYbxof7o';
		$database = 'bookstore';
		$port = 3306;
		$conn = new mysqli($hostname, $user, $password, $database, $port);

		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 

		$sql = "USE bookstore";
		$conn->query($sql);

		$sql = "SELECT * FROM book WHERE BookID = '".$_POST['ac']."'";
		$result = $conn->query($sql);

		while($row = $result->fetch_assoc()){
			$bookID = $row['BookID'];
			$quantity = $_POST['quantity'];
			$price = $row['Price'];
		}

		$sql = "INSERT INTO cart(BookID, Quantity, Price, TotalPrice) VALUES('".$bookID."', ".$quantity.", ".$price.", Price * Quantity)";
		$conn->query($sql);
	}

	if(isset($_POST['delc'])){
		$hostname = 'database-project.cyehfteiydbz.us-east-1.rds.amazonaws.com';
		$user = 'admin';
		$password = '7E1cZlEa3EdRVYbxof7o';
		$database = 'bookstore';
		$port = 3306;
		$conn = new mysqli($hostname, $user, $password, $database, $port);

		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 

		$sql = "USE bookstore";
		$conn->query($sql);

		$sql = "DELETE FROM cart";
		$conn->query($sql);
	}


	//CARGA
	$hostname = 'database-project.cyehfteiydbz.us-east-1.rds.amazonaws.com';
	$user = 'admin';
	$password = '7E1cZlEa3EdRVYbxof7o';
	$database = 'BuscaLibre';
	$port = 3306;
	$conn = new mysqli($hostname, $user, $password, $database, $port);
	$axuliar = new mysqli($hostname, $user, $password, $database, $port);
	$editoriales = new mysqli($hostname, $user, $password, $database, $port);
    $autores = new mysqli($hostname, $user, $password, $database, $port);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "USE BuscaLibre";
	$conn->query($sql);	

	$sql = "SELECT ID_LIBRO,
	TÍTULO,
    CATEGORIA,
    PRECIO,
    PÁGINAS,
    DISPONIBLE,
    IMAGEN,
    IDIOMA,
    EDITORIAL
	FROM LIBROS_CATEGORIAS 
	JOIN LIBROS ON LIBROS.ID_LIBRO = LIBROS_CATEGORIAS.ID_LIBROS
	JOIN CATEGORIAS ON CATEGORIAS.ID_CATEGORIA = LIBROS_CATEGORIAS.ID_CATEGORIAS
	JOIN IDIOMAS ON IDIOMAS.ID_IDIOMA = LIBROS.ID_IDIOMA
    JOIN EDITORIALES ON EDITORIALES.ID_EDITORIAL = LIBROS.ID_EDITORIAL
    GROUP BY TÍTULO";
	$result = $conn->query($sql);
	$aux = $axuliar->query("SELECT CATEGORIA FROM CATEGORIAS");
	$edit = $editoriales->query("SELECT EDITORIAL FROM EDITORIALES");
    $aut = $autores->query("SELECT NOMBRE, APELLIDO FROM AUTORES");
?>	

<?php
if(isset($_SESSION['id'])){
	echo '<header>';
	echo '<blockquote>';
	echo '<a href="index.php"><img src="image/logo.png"></a>';
	echo '<form class="hf" action="logout.php"><input class="hi" type="submit" name="submitButton" value="Logout"></form>';
	echo '<form class="hf" action="edituser.php"><input class="hi" type="submit" name="submitButton" value="Edit Profile"></form>';
	echo '</blockquote>';
	echo '</header>';
}

if(!isset($_SESSION['id'])){
	echo '<header>';
	echo '<blockquote>';
	echo '<a href="index.php"><img src="image/logo.png"></a>';
	echo '<form class="hf" action="register.php"><input class="hi" type="submit" name="submitButton" value="Register"></form>';
	echo '<form class="hf" action="login.php"><input class="hi" type="submit" name="submitButton" value="Login"></form>';
	echo '<form class="hf" action="sales.php"><input class="hi" type="submit" name="submitButton" value="Mis Compras"></form>';
	echo '<form method="post"> <label class="sl"><select name ="categoria" onchange= "this.form.submit()">
	<option value="">Seleccione categoria</option>';
	while($fila = $aux->fetch_assoc()){
		echo '<option value="'.$fila['CATEGORIA'].'">'.$fila['CATEGORIA'].'</option>';
	}
	echo '</select></label>';
	echo '<form method="post"> <label class="sl2"><select name ="editorial" onchange= "this.form.submit()">
	<option value="">Seleccione editorial</option>';
    while($fila = $edit->fetch_assoc()){
        echo '<option value="'.$fila['EDITORIAL'].'">'.$fila['EDITORIAL'].'</option>';
    }
    echo '</select></label>';
    echo '<form method="post"> <label class="sl3"><select name ="autores" onchange= "this.form.submit()">
	<option value="">Seleccione autor</option>';
    while($fila = $aut->fetch_assoc()){
        echo '<option value="'.$fila['NOMBRE'].' '.$fila['APELLIDO'].'">'.$fila['NOMBRE'].' '.$fila['APELLIDO'].'</option>';
    }
	echo '</select></label>';
	
	echo '</blockquote>';
	echo '</header>';
}
echo '<blockquote>';
	// echo "<table id='myTable' style='width:80%; float:left'>";
	// echo "<tr>";
    // while($row = $result->fetch_assoc()) {
	//     echo "<td>";
	//     echo "<table>";					//imagen																		TITULO																//IDIOMA													//Autor->eliminar															//Categoría->Páginas												//PRECIO
	//    	echo '<tr><td>'.'<img src="'.$row["Image"].'"width="80%">'.'</td></tr><tr><td style="padding: 5px;">Title: '.$row["BookTitle"].'</td></tr><tr><td style="padding: 5px;">ISBN: '.$row["ISBN"].'</td></tr><tr><td style="padding: 5px;">Author: '.$row["Author"].'</td></tr><tr><td style="padding: 5px;">Type: '.$row["Type"].'</td></tr><tr><td style="padding: 5px;">S/'.$row["Price"].'</td></tr><tr><td style="padding: 5px;">
	//    	<form action="" method="post">
	//    	Quantity: <input type="number" value="1" name="quantity" style="width: 20%"/><br>
	//    	<input type="hidden" value="'.$row['BookID'].'" name="ac"/>
	//    	<input class="button" type="submit" value="Add to Cart"/>
	//    	</form></td></tr>';
	//    	echo "</table>";
	//    	echo "</td>";
    // }
    // echo "</tr>";
    // echo "</table>";
	
	if (isset($_POST['editorial'])) {
		$editorial_seleccionada = $_POST['editorial'];
		$query = "SELECT ID_LIBRO,
		TÍTULO,
		CATEGORIA,
		PRECIO,
		PÁGINAS,
		DISPONIBLE,
		IMAGEN,
		IDIOMA,
		EDITORIAL
		FROM LIBROS_CATEGORIAS 
		JOIN LIBROS ON LIBROS.ID_LIBRO = LIBROS_CATEGORIAS.ID_LIBROS
		JOIN CATEGORIAS ON CATEGORIAS.ID_CATEGORIA = LIBROS_CATEGORIAS.ID_CATEGORIAS
		JOIN IDIOMAS ON IDIOMAS.ID_IDIOMA = LIBROS.ID_IDIOMA
		JOIN EDITORIALES ON EDITORIALES.ID_EDITORIAL = LIBROS.ID_EDITORIAL WHERE EDITORIAL = '$editorial_seleccionada'";
		$result = $conn->query($query);
		echo "<table id='myTable' style='width:80%; float:left'>";
		echo "<tr>";
		while ($row = $result->fetch_assoc()) {
			// Muestra los detalles del libro
			echo "<td>";
			echo "<table>";					//imagen																		TITULO																//IDIOMA													//Autor->eliminar															//Categoría->Páginas												//PRECIO
			echo '<tr><td>'.'<img src="'.$row["IMAGEN"].'"width="100px" hegih="100px">'.
			'</td></tr><tr><td style="padding: 5px;">Título: '
			.$row["TÍTULO"].'</td></tr><tr><td style="padding: 5px;">Editorial: '
			.$row["EDITORIAL"].'</td></tr><tr><td style="padding: 5px;">Idioma: '
			.$row["IDIOMA"].'</td></tr><tr><td style="padding: 5px;">Categoría: '
			.$row["CATEGORIA"].'</td></tr><tr><td style="padding: 5px;">Páginas: '
			.$row["PÁGINAS"].'</td></tr><tr><td style="padding: 5px;">S/'
			.$row["PRECIO"].'</td></tr><tr><td style="padding: 5px;"></td></tr>';
			   echo "</table>";
			   echo "</td>";
		}
		echo "</tr>";
		echo "</table>";
	}else{
	echo "<table id='myTable' style='width:80%; float:left'>";
	echo "<tr>";
    while($row = $result->fetch_assoc()) {
	    echo "<td>";
	    echo "<table>";					//imagen																		TITULO																//IDIOMA													//Autor->eliminar															//Categoría->Páginas												//PRECIO
		echo '<tr><td>'.'<img src="'.$row["IMAGEN"].'"width="100px" hegih="100px">'.
		'</td></tr><tr><td style="padding: 5px;">Título: '
		.$row["TÍTULO"].'</td></tr><tr><td style="padding: 5px;">Editorial: '
		.$row["EDITORIAL"].'</td></tr><tr><td style="padding: 5px;">Idioma: '
		.$row["IDIOMA"].'</td></tr><tr><td style="padding: 5px;">Categoría: '
		.$row["CATEGORIA"].'</td></tr><tr><td style="padding: 5px;">Páginas: '
		.$row["PÁGINAS"].'</td></tr><tr><td style="padding: 5px;">S/'
		.$row["PRECIO"].'</td></tr><tr><td style="padding: 5px;"></td></tr>';
	   	echo "</table>";
	   	echo "</td>";
    }
    echo "</tr>";
    echo "</table>";
	}
	if (isset($_POST['categoria'])) {
		$categoria_seleccionada = $_POST['categoria'];
		$query = "SELECT ID_LIBRO,
		TÍTULO,
		CATEGORIA,
		PRECIO,
		PÁGINAS,
		DISPONIBLE,
		IMAGEN,
		IDIOMA,
		EDITORIAL
		FROM LIBROS_CATEGORIAS 
		JOIN LIBROS ON LIBROS.ID_LIBRO = LIBROS_CATEGORIAS.ID_LIBROS
		JOIN CATEGORIAS ON CATEGORIAS.ID_CATEGORIA = LIBROS_CATEGORIAS.ID_CATEGORIAS
		JOIN IDIOMAS ON IDIOMAS.ID_IDIOMA = LIBROS.ID_IDIOMA
		JOIN EDITORIALES ON EDITORIALES.ID_EDITORIAL = LIBROS.ID_EDITORIAL WHERE CATEGORIA = '$categoria_seleccionada'";
		$result = $conn->query($query);
		echo "<table id='myTable' style='width:80%; float:left'>";
		echo "<tr>";
		while ($row = $result->fetch_assoc()) {
			// Muestra los detalles del libro
			echo "<td>";
			echo "<table>";					//imagen																		TITULO																//IDIOMA													//Autor->eliminar															//Categoría->Páginas												//PRECIO
			echo '<tr><td>'.'<img src="'.$row["IMAGEN"].'"width="100px" hegih="100px">'.
			'</td></tr><tr><td style="padding: 5px;">Título: '
			.$row["TÍTULO"].'</td></tr><tr><td style="padding: 5px;">Editorial: '
			.$row["EDITORIAL"].'</td></tr><tr><td style="padding: 5px;">Idioma: '
			.$row["IDIOMA"].'</td></tr><tr><td style="padding: 5px;">Categoría: '
			.$row["CATEGORIA"].'</td></tr><tr><td style="padding: 5px;">Páginas: '
			.$row["PÁGINAS"].'</td></tr><tr><td style="padding: 5px;">S/'
			.$row["PRECIO"].'</td></tr><tr><td style="padding: 5px;"></td></tr>';
			   echo "</table>";
			   echo "</td>";
		}
		echo "</tr>";
		echo "</table>";
	}else{
	echo "<table id='myTable' style='width:80%; float:left'>";
	echo "<tr>";
    while($row = $result->fetch_assoc()) {
	    echo "<td>";
	    echo "<table>";					//imagen																		TITULO																//IDIOMA													//Autor->eliminar															//Categoría->Páginas												//PRECIO
		echo '<tr><td>'.'<img src="'.$row["IMAGEN"].'"width="100px" hegih="100px">'.
		'</td></tr><tr><td style="padding: 5px;">Título: '
		.$row["TÍTULO"].'</td></tr><tr><td style="padding: 5px;">Editorial: '
		.$row["EDITORIAL"].'</td></tr><tr><td style="padding: 5px;">Idioma: '
		.$row["IDIOMA"].'</td></tr><tr><td style="padding: 5px;">Categoría: '
		.$row["CATEGORIA"].'</td></tr><tr><td style="padding: 5px;">Páginas: '
		.$row["PÁGINAS"].'</td></tr><tr><td style="padding: 5px;">S/'
		.$row["PRECIO"].'</td></tr><tr><td style="padding: 5px;"></td></tr>';
	   	echo "</table>";
	   	echo "</td>";
    }
    echo "</tr>";
    echo "</table>";
	}

	if (isset($_POST['autores'])) {
		$autor_seleccionado = $_POST['autores'];
		$query = "SELECT ID_LIBRO,
		TÍTULO,
		CATEGORIA,
		PRECIO,
		PÁGINAS,
		DISPONIBLE,
		IMAGEN,
		IDIOMA,
		EDITORIAL
		FROM LIBROS_CATEGORIAS 
		JOIN LIBROS ON LIBROS.ID_LIBRO = LIBROS_CATEGORIAS.ID_LIBROS
		JOIN CATEGORIAS ON CATEGORIAS.ID_CATEGORIA = LIBROS_CATEGORIAS.ID_CATEGORIAS
		JOIN IDIOMAS ON IDIOMAS.ID_IDIOMA = LIBROS.ID_IDIOMA
		JOIN EDITORIALES ON EDITORIALES.ID_EDITORIAL = LIBROS.ID_EDITORIAL
		JOIN AUTORES ON AUTORES.ID_AUTOR = LIBROS.ID_AUTOR WHERE CONCAT(AUTORES.NOMBRE, ' ', AUTORES.APELLIDO) = '$autor_seleccionado'";
		$result = $conn->query($query);
		echo "<table id='myTable' style='width:80%; float:left'>";
		echo "<tr>";
		while ($row = $result->fetch_assoc()) {
			// Muestra los detalles del libro
			echo "<td>";
			echo "<table>";					//imagen																		TITULO																//IDIOMA													//Autor->eliminar															//Categoría->Páginas												//PRECIO
			echo '<tr><td>'.'<img src="'.$row["IMAGEN"].'"width="100px" hegih="100px">'.
			'</td></tr><tr><td style="padding: 5px;">Título: '
			.$row["TÍTULO"].'</td></tr><tr><td style="padding: 5px;">Editorial: '
			.$row["EDITORIAL"].'</td></tr><tr><td style="padding: 5px;">Idioma: '
			.$row["IDIOMA"].'</td></tr><tr><td style="padding: 5px;">Categoría: '
			.$row["CATEGORIA"].'</td></tr><tr><td style="padding: 5px;">Páginas: '
			.$row["PÁGINAS"].'</td></tr><tr><td style="padding: 5px;">S/'
			.$row["PRECIO"].'</td></tr><tr><td style="padding: 5px;"></td></tr>';
			   echo "</table>";
			   echo "</td>";
		}
		echo "</tr>";
		echo "</table>";
	}else{
	echo "<table id='myTable' style='width:80%; float:left'>";
	echo "<tr>";
    while($row = $result->fetch_assoc()) {
	    echo "<td>";
	    echo "<table>";					//imagen																		TITULO																//IDIOMA													//Autor->eliminar															//Categoría->Páginas												//PRECIO
		echo '<tr><td>'.'<img src="'.$row["IMAGEN"].'"width="100px" hegih="100px">'.
		'</td></tr><tr><td style="padding: 5px;">Título: '
		.$row["TÍTULO"].'</td></tr><tr><td style="padding: 5px;">Editorial: '
		.$row["EDITORIAL"].'</td></tr><tr><td style="padding: 5px;">Idioma: '
		.$row["IDIOMA"].'</td></tr><tr><td style="padding: 5px;">Categoría: '
		.$row["CATEGORIA"].'</td></tr><tr><td style="padding: 5px;">Páginas: '
		.$row["PÁGINAS"].'</td></tr><tr><td style="padding: 5px;">S/'
		.$row["PRECIO"].'</td></tr><tr><td style="padding: 5px;"></td></tr>';
	   	echo "</table>";
	   	echo "</td>";
    }
    echo "</tr>";
    echo "</table>";


	// $sql = "SELECT book.BookTitle, book.Image, cart.Price, cart.Quantity, cart.TotalPrice FROM book,cart WHERE book.BookID = cart.BookID;";
	$sql = "SELECT TÍTULO, IMAGEN, PRECIO, PÁGINAS FROM LIBROS";
    $result = $conn->query($sql);

    echo "<table style='width:20%; float:right;'>";
    echo "<th style='text-align:left;'><i class='fa fa-shopping-cart' style='font-size:24px'></i> Cart <form style='float:right;' action='' method='post'><input type='hidden' name='delc'/><input class='cbtn' type='submit' value='Empty Cart'></form></th>";
    $total = 0;
    while($row = $result->fetch_assoc()){//Tabla de pedidos
        echo "<tr><td>";
        echo '<img src="'.$row["IMAGEN"].'"width="20%"><br>';
        echo $row['TÍTULO']."<br>S/".$row['PRECIO']."<br>";
        echo "Páginas: ".$row['PÁGINAS']."<br>";
        $total += $row['PRECIO'];
    }
    echo "<tr><td style='text-align: right;background-color: #f2f2f2;''>";
    echo "Total: <b>S/".$total."</b><center><form action='checkout.php' method='post'><input class='button' type='submit' name='checkout' value='CHECKOUT'></form></center>";
    echo "</td></tr>";
    echo "</table>";
	echo '</blockquote>';

	}
?>
</body>
</html>