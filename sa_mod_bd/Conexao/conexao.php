<?php
// Pega as credenciais do banco do Railway (variáveis de ambiente)
$host = getenv("DB_HOST") ?: "localhost";
$dbname = getenv("DB_NAME") ?: "bd_imagens";
$username = getenv("DB_USER") ?: "root";
$password = getenv("DB_PASS") ?: "";

// Tenta conectar usando PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Conexão bem-sucedida!"; // só para teste
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
