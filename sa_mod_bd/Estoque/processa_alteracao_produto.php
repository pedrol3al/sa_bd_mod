<?php
session_start();
require_once '../Conexao/conexao.php';

// Verificar permissão do usuário
if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] !=5) {
  echo "<script>alert('Acesso negado!');window.location.href='../Principal/main.php'</script>";
  exit();
}

// Verificar se o ID foi passado
if (!isset($_GET['id'])) {
    $_SESSION['mensagem'] = 'ID do produto não especificado!';
    $_SESSION['tipo_mensagem'] = 'error';
    header('Location: buscar_produto.php');
    exit;
}

$id_produto = $_GET['id'];

// Processar exclusão se solicitado
if (isset($_GET['excluir_produto'])) {
    try {
        // Verificar se o produto está vinculado a alguma OS antes de excluir
        $sql_check = "SELECT COUNT(*) as total FROM os_produto WHERE id_produto = :id_produto";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->bindParam(':id_produto', $id_produto);
        $stmt_check->execute();
        $result = $stmt_check->fetch();
        
        if ($result['total'] > 0) {
            $_SESSION['mensagem'] = 'Não é possível excluir este produto pois está vinculado a ordens de serviço!';
            $_SESSION['tipo_mensagem'] = 'error';
            header('Location: buscar_produto.php');
            exit;
        }
        
        // Excluir produto
        $sql = "DELETE FROM produto WHERE id_produto = :id_produto";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_produto', $id_produto);
        $stmt->execute();
        
        $_SESSION['mensagem'] = 'Produto excluído com sucesso!';
        $_SESSION['tipo_mensagem'] = 'success';
        
        header('Location: buscar_produto.php');
        exit;
        
    } catch (Exception $e) {
        $_SESSION['mensagem'] = 'Erro ao excluir produto: ' . $e->getMessage();
        $_SESSION['tipo_mensagem'] = 'error';
        header('Location: buscar_produto.php');
        exit;
    }
}

// Buscar dados do produto
try {
    $sql = "SELECT p.*, f.razao_social as fornecedor_nome 
            FROM produto p 
            INNER JOIN fornecedor f ON p.id_fornecedor = f.id_fornecedor 
            WHERE p.id_produto = :id_produto";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_produto', $id_produto);
    $stmt->execute();
    $produto = $stmt->fetch();
    
    if (!$produto) {
        $_SESSION['mensagem'] = 'Produto não encontrado!';
        $_SESSION['tipo_mensagem'] = 'error';
        header('Location: buscar_produto.php');
        exit;
    }
    
    // Buscar fornecedores para o dropdown
    $sql_fornecedores = "SELECT id_fornecedor, razao_social FROM fornecedor WHERE inativo = 0 ORDER BY razao_social";
    $stmt_fornecedores = $pdo->prepare($sql_fornecedores);
    $stmt_fornecedores->execute();
    $fornecedores = $stmt_fornecedores->fetchAll();
    
} catch (PDOException $e) {
    echo "Erro ao carregar produto: " . $e->getMessage();
    exit;
}

// Processar atualização
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['atualizar_produto'])) {
    try {
        $id_fornecedor = $_POST['id_fornecedor'];
        $tipo = $_POST['tipo'];
        $nome = $_POST['nome'];
        $aparelho_utilizado = $_POST['aparelho_utilizado'];
        $quantidade = $_POST['quantidade'];
        $preco = $_POST['preco'];
        $data_registro = $_POST['data_registro'];
        $descricao = $_POST['descricao'];
        
        $sql_update = "UPDATE produto 
                       SET id_fornecedor = :id_fornecedor, 
                           tipo = :tipo, 
                           nome = :nome, 
                           aparelho_utilizado = :aparelho_utilizado, 
                           quantidade = :quantidade, 
                           preco = :preco, 
                           data_registro = :data_registro, 
                           descricao = :descricao 
                       WHERE id_produto = :id_produto";
        
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindParam(':id_fornecedor', $id_fornecedor);
        $stmt_update->bindParam(':tipo', $tipo);
        $stmt_update->bindParam(':nome', $nome);
        $stmt_update->bindParam(':aparelho_utilizado', $aparelho_utilizado);
        $stmt_update->bindParam(':quantidade', $quantidade);
        $stmt_update->bindParam(':preco', $preco);
        $stmt_update->bindParam(':data_registro', $data_registro);
        $stmt_update->bindParam(':descricao', $descricao);
        $stmt_update->bindParam(':id_produto', $id_produto);
        
        $stmt_update->execute();
        
        $_SESSION['mensagem'] = 'Produto atualizado com sucesso!';
        $_SESSION['tipo_mensagem'] = 'success';
        
        header('Location: buscar_produto.php');
        exit;
        
    } catch (Exception $e) {
        $_SESSION['mensagem'] = 'Erro ao atualizar produto: ' . $e->getMessage();
        $_SESSION['tipo_mensagem'] = 'error';
        header('Location: buscar_produto.php');
        exit;
    }
}
?>