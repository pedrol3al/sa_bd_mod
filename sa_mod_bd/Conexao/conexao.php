<?php
$host = getenv("MYSQLHOST");
$dbname = getenv("MYSQLDATABASE");
$username = getenv("MYSQLUSER");
$password = getenv("MYSQLPASSWORD");
$port = getenv("MYSQLPORT") ?: "3306";

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
