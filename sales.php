<html>
<link rel="stylesheet" href="style.css">
<body>
<header>
<blockquote>
	<a href="index.php"><img src="image/logo.png"></a>
</blockquote>
</header>
<div class="container">
<center><h1>Historial de Compras</h1></center>
<?php
$hostname = 'database-project.cyehfteiydbz.us-east-1.rds.amazonaws.com';
$user = 'admin';
$password = '7E1cZlEa3EdRVYbxof7o';
$database = 'bookstore';
$port = 3306;
$conn = new mysqli($hostname, $user, $password, $database, $port);

//error_reporting(E_ERROR);

session_start();
$sql = "USE BuscaLibre";
$conn->query($sql);	

$user_id = 3; 
//$user_id = $_SESSION['ID_CLIENTE'];

$sql = "SELECT VENTAS.ID_VENTAS, FECHA, ESTADO, TÍTULO
FROM VENTAS_LIBROS 
JOIN VENTAS ON VENTAS.ID_VENTAS = VENTAS_LIBROS.ID_VENTAS
JOIN LIBROS ON LIBROS.ID_LIBRO = VENTAS_LIBROS.ID_LIBRO
JOIN ESTADOS ON ESTADOS.ID_ESTADO = VENTAS.ID_ESTADO
WHERE ID_CLIENTE = '$user_id' 
ORDER BY VENTAS.ID_VENTAS ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mostrar la tabla con el historial de compras
    echo "<table class =\"tabla\">
    <thead>
    <tr>
      <th>ID</th>
      <th>TITULO</th>
      <th>FECHA</th>
      <th>ESTADO</th>
    </tr>
  </thead>";
 
    while($row = $result->fetch_assoc()) {
      echo "<tr>
      <td>" . $row["ID_VENTAS"] . "</td>
      <td>" . $row["TÍTULO"] . "</td>
      <td>" . $row["FECHA"] . "</td>
      <td>" . $row["ESTADO"] ."</td>
      </tr>";
    }
    "</table>";

} else {
    echo "No se encontraron compras para este usuario";
}

?>

</div>
