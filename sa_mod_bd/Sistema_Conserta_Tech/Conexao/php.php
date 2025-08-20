<?php
// Inclui o arquivo de conexão com o banco
require_once 'conexao.php'; // Altere para o caminho correto se necessário

try {
    // Seleciona todos os usuários que ainda têm senha em texto plano
    $stmt = $pdo->query("SELECT id_usuario, senha FROM usuario WHERE LENGTH(senha) <= 20");

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id_usuario = $row['id_usuario'];
        $senha_plana = $row['senha'];

        // Aplica o hash na senha
        $senha_hash = password_hash($senha_plana, PASSWORD_DEFAULT);

        // Atualiza a senha no banco com o hash
        $update = $pdo->prepare("UPDATE usuario SET senha = :senha WHERE id_usuario = :id");
        $update->execute([
            ':senha' => $senha_hash,
            ':id' => $id_usuario
        ]);

        echo "Senha do usuário ID $id_usuario atualizada com hash.\n";
    }

} catch (PDOException $e) {
    echo "Erro ao atualizar senha: " . $e->getMessage();
}
?>
