<?php
$hostname = 'database-project.cyehfteiydbz.us-east-1.rds.amazonaws.com';
$user = 'admin';
$password = '7E1cZlEa3EdRVYbxof7o';
$database = 'BuscaLibre';
$port = 3306;
$conn = new mysqli($hostname, $user, $password, $database, $port);
$conn->set_charset("utf8")
?>