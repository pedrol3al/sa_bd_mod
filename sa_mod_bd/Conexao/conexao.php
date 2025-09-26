<?php
$host = "mysql.railway.internal";    // ex: containers-us-west-123.railway.app
$port = "3306";       // ex: 12345
$dbname = "railway";
$username = "root";
$password = "REdhhCojiuDxlwkZVLrYGethCAKKjkVT";

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8",
        $username,
        $password
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexão OK!";
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
