<?php
$host = "seu_host_do_railway";    // ex: containers-us-west-123.railway.app
$port = "porta_do_railway";       // ex: 12345
$dbname = "nome_do_banco";
$username = "usuario_do_banco";
$password = "senha_do_banco";

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
