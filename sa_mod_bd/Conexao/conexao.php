<?php
// Pega as credenciais do banco do Railway (variáveis de ambiente)
$host = getenv("MYSQLHOST") ?: "localhost";
$dbname = getenv("MYSQLDATABASE") ?: "bd_imagens";
$username = getenv("MYSQLUSER") ?: "root";
$password = getenv("MYSQLPASSWORD") ?: "";
$port = getenv("MYSQLPORT") ?: "3306";

// Tenta conectar usando PDO
try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Conexão bem-sucedida!"; // só para teste
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
