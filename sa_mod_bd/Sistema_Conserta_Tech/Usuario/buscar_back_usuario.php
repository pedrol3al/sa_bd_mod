<?php
session_start();
require_once '../Conexao/conexao.php';

if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 1) {
    die("Acesso negado");
}

$usuario = [];

if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['buscar_usuario'])) {
    $busca = trim($_POST['buscar_usuario']);

    try {
        // Prepara a busca insensível a maiúsculas/minúsculas e acentos
        $busca_like = '%' . $busca . '%';

        // Query combinada
        $sql = "SELECT * FROM usuario 
                WHERE id_usuario = :id
                   OR nome LIKE :nome 
                ORDER BY nome ASC";

        $stmt = $pdo->prepare($sql);

        // Bind do ID: se não for número, define 0 (não existe)
        $stmt->bindValue(':id', is_numeric($busca) ? (int)$busca : 0, PDO::PARAM_INT);
        $stmt->bindValue(':nome', $busca_like, PDO::PARAM_STR);

        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Erro ao buscar usuários: " . $e->getMessage();
    }
}

include 'buscar_usuario.php';
