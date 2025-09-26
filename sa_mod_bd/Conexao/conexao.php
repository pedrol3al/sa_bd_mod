<?php
$host = getenv("MYSQLHOST");
$port = getenv("MYSQLPORT") ?: "3306";
$dbname = getenv("MYSQLDATABASE");
$username = getenv("MYSQLUSER");
$password = getenv("MYSQLPASSWORD");

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8",
        $username,
        $password
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexão Railway OK!";
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
