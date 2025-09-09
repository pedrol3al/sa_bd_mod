<?php
// Inicia ou resume a sessão para acessar variáveis de sessão
session_start();
// Inclui o arquivo de conexão com o banco de dados (apenas uma vez)
require_once("../Conexao/conexao.php");

// Função para sanitizar dados - previne ataques XSS (Cross-Site Scripting)
function safe_html($data) {
    // Converte caracteres especiais em entidades HTML
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// Buscar todos os usuários ativos do sistema
$sql = "SELECT * FROM usuario WHERE inativo = 0 ORDER BY nome"; // Query para selecionar usuários ativos ordenados por nome
$stmt = $pdo->prepare($sql); // Prepara a query para execução
$stmt->execute(); // Executa a query no banco de dados
$usuarios = $stmt->fetchAll(); // Armazena todos os resultados na variável $usuarios

// Verificar se há um ID de usuário para editar (quando acessado via GET)
$usuarioAtual = null; // Inicializa a variável como nula
if (isset($_GET['id']) && is_numeric($_GET['id'])) { // Verifica se o parâmetro ID existe e é numérico
    $id_usuario = $_GET['id']; // Armazena o ID do usuário
    $sql = "SELECT * FROM usuario WHERE id_usuario = :id"; // Query para buscar usuário específico
    $stmt = $pdo->prepare($sql); // Prepara a query
    $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT); // Associa o parâmetro :id ao valor recebido
    $stmt->execute(); // Executa a query
    $usuarioAtual = $stmt->fetch(); // Armazena os dados do usuário encontrado
}

// Processar inativação de usuário (quando acessado via GET com parâmetro 'inativar')
if (isset($_GET['inativar']) && is_numeric($_GET['inativar'])) {
    $id_inativar = $_GET['inativar']; // Armazena o ID do usuário a ser inativado
    $sql = "UPDATE usuario SET inativo = 1 WHERE id_usuario = :id"; // Query para marcar usuário como inativo
    $stmt = $pdo->prepare($sql); // Prepara a query
    $stmt->bindParam(':id', $id_inativar, PDO::PARAM_INT); // Associa o parâmetro :id
    
    if ($stmt->execute()) { // Se a execução for bem-sucedida
        // Redireciona com parâmetro de sucesso e ID do usuário
        header("Location: processa_alteracao_cliente.php?inactivated=1&id=" . $id_inativar);
        exit(); // Termina a execução do script
    } else {
        // Redireciona com parâmetro de erro
        header("Location: processa_alteracao_cliente.php?error=1");
        exit();
    }
}

// Processar ativação de usuário (quando acessado via GET com parâmetro 'ativar')
if (isset($_GET['ativar']) && is_numeric($_GET['ativar'])) {
    $id_ativar = $_GET['ativar']; // Armazena o ID do usuário a ser ativado
    $sql = "UPDATE usuario SET inativo = 0 WHERE id_usuario = :id"; // Query para marcar usuário como ativo
    $stmt = $pdo->prepare($sql); // Prepara a query
    $stmt->bindParam(':id', $id_ativar, PDO::PARAM_INT); // Associa o parâmetro :id
    
    if ($stmt->execute()) { // Se a execução for bem-sucedida
        // Redireciona com parâmetro de sucesso e ID do usuário
        header("Location: processa_alteracao_cliente.php?activated=1&id=" . $id_ativar);
        exit();
    } else {
        // Redireciona com parâmetro de erro
        header("Location: processa_alteracao_cliente.php?error=1");
        exit();
    }
}

// Processar atualização de dados do usuário (quando o formulário é submetido via POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_usuario'])) {
    // Obtém todos os dados do formulário, usando operador de coalescência nula para valores opcionais
    $id_usuario = $_POST['id_usuario'];
    $perfil = $_POST['perfil'];
    $nome = $_POST['nome'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'] ?? null; // Valor padrão null se não existir
    $data_nasc = $_POST['data_nasc'] ?? null;
    $cep = $_POST['cep'] ?? null;
    $logradouro = $_POST['logradouro'] ?? null;
    $numero = $_POST['numero'] ?? null;
    $cidade = $_POST['cidade'] ?? null;
    $estado = $_POST['estado'] ?? null;
    $bairro = $_POST['bairro'] ?? null;
    $telefone = $_POST['telefone'] ?? null;

    // Query SQL para atualizar múltiplos campos do usuário
    $sql = "UPDATE usuario SET 
            id_perfil = :perfil, 
            nome = :nome, 
            username = :username, 
            email = :email, 
            cpf = :cpf, 
            data_nasc = :data_nasc, 
            cep = :cep, 
            logradouro = :logradouro, 
            numero = :numero, 
            cidade = :cidade, 
            uf = :estado, 
            bairro = :bairro, 
            telefone = :telefone 
            WHERE id_usuario = :id";

    $stmt = $pdo->prepare($sql); // Prepara a query
    // Associa cada parâmetro da query aos valores do formulário
    $stmt->bindParam(':perfil', $perfil, PDO::PARAM_INT);
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $stmt->bindParam(':data_nasc', $data_nasc, PDO::PARAM_STR);
    $stmt->bindParam(':cep', $cep, PDO::PARAM_STR);
    $stmt->bindParam(':logradouro', $logradouro, PDO::PARAM_STR);
    $stmt->bindParam(':numero', $numero, PDO::PARAM_STR);
    $stmt->bindParam(':cidade', $cidade, PDO::PARAM_STR);
    $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
    $stmt->bindParam(':bairro', $bairro, PDO::PARAM_STR);
    $stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);

    if ($stmt->execute()) { // Se a atualização for bem-sucedida
        // Redireciona com parâmetro de sucesso e ID do usuário
        header("Location: processa_alteracao_cliente.php?updated=1&id=" . $id_usuario);
        exit();
    } else {
        // Redireciona com parâmetro de erro
        header("Location: processa_alteracao_cliente.php?error=1");
        exit();
    }
}

?>