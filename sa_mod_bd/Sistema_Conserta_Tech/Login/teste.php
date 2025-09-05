<?php
require_once('../Conexao/conexao.php');

$stmt = $pdo->query("SELECT COUNT(*) AS total FROM usuario");
$result = $stmt->fetch(PDO::FETCH_ASSOC);

echo "Total de usuários na tabela: " . $result['total'];
?>
