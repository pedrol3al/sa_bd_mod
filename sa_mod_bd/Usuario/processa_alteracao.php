<?php
session_start();
require '../Conexao/conexao.php';

// Verifica se é admin
if($_SESSION['perfil'] !=1){
    $_SESSION['mensagem'] = 'Acesso negado!';
    $_SESSION['tipo_mensagem'] = 'error';
    header('Location: buscar_usuario.php');
    exit();
}

// Processar inativação do usuário
if(isset($_GET['inativar']) && is_numeric($_GET['inativar'])){
    try {
        $id_usuario = $_GET['inativar'];
        $sql = "UPDATE usuario SET inativo = 1 WHERE id_usuario = :id_usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        
        if($stmt->execute()){
            $_SESSION['mensagem'] = 'Usuário inativado com sucesso!';
            $_SESSION['tipo_mensagem'] = 'success';
            header('Location: buscar_usuario.php');
            exit;
        } else {
            $_SESSION['mensagem'] = 'Erro ao inativar o usuário!';
            $_SESSION['tipo_mensagem'] = 'error';
            header('Location: buscar_usuario.php');
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['mensagem'] = 'Erro ao inativar usuário: ' . $e->getMessage();
        $_SESSION['tipo_mensagem'] = 'error';
        header('Location: buscar_usuario.php');
        exit;
    }
}

// Processar ativação do usuário
if(isset($_GET['ativar']) && is_numeric($_GET['ativar'])){
    try {
        $id_usuario = $_GET['ativar'];
        $sql = "UPDATE usuario SET inativo = 0 WHERE id_usuario = :id_usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        
        if($stmt->execute()){
            $_SESSION['mensagem'] = 'Usuário ativado com sucesso!';
            $_SESSION['tipo_mensagem'] = 'success';
            header('Location: buscar_usuario.php');
            exit;
        } else {
            $_SESSION['mensagem'] = 'Erro ao ativar o usuário!';
            $_SESSION['tipo_mensagem'] = 'error';
            header('Location: buscar_usuario.php');
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['mensagem'] = 'Erro ao ativar usuário: ' . $e->getMessage();
        $_SESSION['tipo_mensagem'] = 'error';
        header('Location: buscar_usuario.php');
        exit;
    }
}

// Se um POST for enviado, atualiza o usuario
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_usuario'])){
    try {
        $id_usuario = $_POST['id_usuario'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        
        // CORREÇÃO DO CAMPO SEXO - TRATAMENTO CORRETO
        $sexo = $_POST['sexo'];
        $sexo = ($sexo === '') ? null : $sexo;
        // Validar se é um valor permitido
        if ($sexo !== null && !in_array($sexo, ['M', 'F'])) {
            $sexo = null;
        }
        
        $id_perfil = $_POST['perfil'];
        $cpf = $_POST['cpf'];
        $username = $_POST['username'];
        $data_nasc = $_POST['data_nasc'];
        $cep = $_POST['cep'];
        $logradouro = $_POST['logradouro'];
        $numero = $_POST['numero'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];
        $bairro = $_POST['bairro'];
        $telefone = $_POST['telefone'];

        $sql = "UPDATE usuario SET 
                    nome = :nome, 
                    email = :email, 
                    sexo = :sexo, 
                    id_perfil = :id_perfil, 
                    cpf = :cpf, 
                    username = :username, 
                    data_nasc = :data_nasc, 
                    cep = :cep, 
                    logradouro = :logradouro, 
                    numero = :numero, 
                    cidade = :cidade, 
                    uf = :estado, 
                    bairro = :bairro, 
                    telefone = :telefone 
                WHERE id_usuario = :id_usuario";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':sexo', $sexo);
        $stmt->bindParam(':id_perfil', $id_perfil, PDO::PARAM_INT);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':data_nasc', $data_nasc);
        $stmt->bindParam(':cep', $cep);
        $stmt->bindParam(':logradouro', $logradouro);
        $stmt->bindParam(':numero', $numero);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':bairro', $bairro);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

        if($stmt->execute()){
            $_SESSION['mensagem'] = 'Usuário alterado com sucesso!';
            $_SESSION['tipo_mensagem'] = 'success';
            header('Location: buscar_usuario.php');
            exit;
        } else {
            $_SESSION['mensagem'] = 'Erro ao alterar o usuário!';
            $_SESSION['tipo_mensagem'] = 'error';
            header('Location: buscar_usuario.php');
            exit;
        }
        
    } catch (PDOException $e) {
        $_SESSION['mensagem'] = 'Erro ao alterar usuário: ' . $e->getMessage();
        $_SESSION['tipo_mensagem'] = 'error';
        header('Location: buscar_usuario.php');
        exit;
    }
}

// Se um GET com id for passado, busca os dados do usuario
$usuarioAtual = null;
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id_usuario = $_GET['id'];
    $sql = "SELECT * FROM usuario WHERE id_usuario = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);
    $stmt->execute();
    $usuarioAtual = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Busca todos os usuarios para exibir na tabela (apenas os ativos)
$sql = "SELECT * FROM usuario WHERE inativo = 0 ORDER BY nome ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Função auxiliar para evitar erros com valores nulos
function safe_html($value) {
    return $value !== null ? htmlspecialchars($value) : '';
}
?>