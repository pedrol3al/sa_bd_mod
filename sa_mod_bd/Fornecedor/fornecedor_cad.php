<?php
$sql = "SELECT id_usuario, nome FROM usuario WHERE inativo = 0 ORDER BY nome";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $usuarios = $stmt->fetchAll();

// Processar o cadastro do fornecedor
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../Conexao/conexao.php");
    
    $email = $_POST["email_forn"];
    $id_usuario = $_POST["id_usuario"];
    $razao_social = $_POST["razao_social_forn"];
    $cnpj = $_POST["cnpj_forn"];
    $data_fundacao = $_POST["dataFundacao_forn"];
    $data_cadastro = $_POST["dataCadastro_forn"];
    $telefone = $_POST["telefone_forn"];
    $produto_fornecido = $_POST["produto_fornecido"];
    $cep = $_POST["cep_forn"];
    $logradouro = $_POST["logradouro_forn"];
    $tipo = $_POST["tipo_estabelecimento_forn"];
    $complemento = $_POST["complemento_forn"];
    $numero = $_POST["numero_forn"];
    $cidade = $_POST["cidade_forn"];
    $uf = $_POST["uf_forn"];
    $bairro = $_POST["bairro_forn"];
    $observacoes = $_POST["observacoes_forn"];

    $sql = "INSERT INTO fornecedor (email, id_usuario, razao_social, cnpj, data_fundacao, data_cad, telefone, produto_fornecido, cep, logradouro, tipo, complemento, numero, cidade, uf, bairro, observacoes)
            VALUES (:email, :id_usuario, :razao_social, :cnpj, :data_fundacao, :data_cadastro, :telefone, :produto_fornecido, :cep, :logradouro, :tipo, :complemento, :numero, :cidade, :uf, :bairro, :observacoes)";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->bindParam(':razao_social', $razao_social);
    $stmt->bindParam(':cnpj', $cnpj);
    $stmt->bindParam(':data_fundacao', $data_fundacao);
    $stmt->bindParam(':data_cadastro', $data_cadastro);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':produto_fornecido', $produto_fornecido);
    $stmt->bindParam(':cep', $cep);
    $stmt->bindParam(':logradouro', $logradouro);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':complemento', $complemento);
    $stmt->bindParam(':numero', $numero);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':uf', $uf);
    $stmt->bindParam(':bairro', $bairro);
    $stmt->bindParam(':observacoes', $observacoes);

    if ($stmt->execute()) {
        $_SESSION['mensagem'] = 'Fornecedor cadastrado com sucesso!';
        $_SESSION['tipo_mensagem'] = 'success';
    } else {
        $_SESSION['mensagem'] = 'Erro ao cadastrar fornecedor!';
        $_SESSION['tipo_mensagem'] = 'danger';
    }
    
    // Redirecionar para a mesma página para evitar reenvio do formulário
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}


?>