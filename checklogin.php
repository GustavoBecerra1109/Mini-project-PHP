<?php
$hostname = 'database-project.cyehfteiydbz.us-east-1.rds.amazonaws.com';
$user = 'admin';
$password = '7E1cZlEa3EdRVYbxof7o';
$database = 'BuscaLibre';
$port = 3306;
$conn = new mysqli($hostname, $user, $password, $database, $port);

if(!empty($_POST['enviar'])){
    if(empty($username=$_POST['names']) && empty($dni = $_POST['dni'])){
        echo 'LOS CAMPOS ESTÁN VACIOS';//Por modficiar para diseño
    }else{
        $username = $_POST['names'];
        $dni = $_POST['dni'];
        $sql = $conn->query(" SELECT NOMBRE, DNI FROM CLIENTES WHERE NOMBRE='$username' AND DNI='$dni'");
        if($datos=$sql->fetch_object()){
            header("Location:index.php");
        }else{
            echo 'ACCESO DENEGADO'; //Falta diseño
        }
    } 
}
?>