<?php
// Define as credenciais de acesso ao banco de dados
$host = 'localhost';         
$dbname = 'conserta_tech_sa'; 
$user = 'root';               
$pass = '';                   

try {
    // utf8mb4 suporta caracteres especiais e emojis (mais completo que utf8)
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    // "mysql:host=$host;dbname=$dbname;charset=utf8mb4" - Define o driver MySQL, host, nome do BD e charset

    // PDO::ATTR_ERRMODE: Define como o PDO reportará erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    //caso ocorra qualquer erro na conexão
    // die() termina a execução do script e exibe a mensagem de erro
    die("Erro de conexão com o banco de dados: " . $e->getMessage());
}
?>