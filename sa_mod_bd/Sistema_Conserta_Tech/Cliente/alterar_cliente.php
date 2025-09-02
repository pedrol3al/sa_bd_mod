<?php
session_start();
require '../Conexao/conexao.php';

// Verifica se é admin
if($_SESSION['perfil'] !=1 && $_SESSION['perfil'] !=2){
    echo "<script>alert('Acesso negado!');window.location.href='../Principal/main.php';</script>";
    exit();
}



// Se um POST for enviado, atualiza o cliente
if(isset($_POST['id_cliente'], $_POST['nome'], $_POST['email'])){
    $id_cliente = $_POST['id_cliente'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $sql="UPDATE cliente SET nome=:nome, email=:email WHERE id_cliente=:id";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $id_cliente, PDO::PARAM_INT);

    if($stmt->execute()){
        echo "<script>alert('Cliente alterado com sucesso!');window.location.href='alterar_cliente.php';</script>";
        exit;
    } else {
        echo "<script>alert('Erro ao alterar o cliente!');</script>";
    }
}

// Se um GET com id for passado, busca os dados do cliente
$clienteAtual = null;
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id_cliente = $_GET['id'];
    $sql="SELECT * FROM cliente WHERE id_cliente=:id";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':id', $id_cliente, PDO::PARAM_INT);
    $stmt->execute();
    $clienteAtual = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Busca todos os clientes para exibir na tabela
$sql="SELECT * FROM cliente ORDER BY nome ASC";
$stmt=$pdo->prepare($sql);
$stmt->execute();
$clientes=$stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar cliente</title>
    <!-- Links bootstrapt e css -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="cliente_alterar.css" />
    <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <!-- Imagem no navegador -->
    <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">

    <!-- Link notfy -->
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <!-- Link das máscaras dos campos -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>
<body class="corpo">

<?php
  include("../Menu_lateral/menu.php"); 
?>


<main>
<div class="conteudo">
    <div class="topoTitulo">
        <h1>ALTERAR CLIENTE</h1>
        <hr>
    </div>

    <?php if($clienteAtual): ?>
    <form method="POST" enctype="multipart/form-data">

        <input type="hidden" name="id_cliente" value="<?= htmlspecialchars($clienteAtual['id_cliente']) ?>">

        <!-- Nome -->
        <div class="campos_juridica">
        <div class="linha">
            <label for="nome_cliente">Nome:</label>
            <input type="text" id="nome_cliente" name="nome_cliente" class="form-control" value="<?= htmlspecialchars($clienteAtual['nome']) ?>" required>
        </div>

        <!-- Email -->
        <div class="linha">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($clienteAtual['email']) ?>" required>
        </div>

        <!-- Observação -->
        <div class="linha">
            <label for="observacao">Observação:</label>
            <input type="text" id="observacao" name="observacao" class="form-control" value="<?= htmlspecialchars($clienteAtual['observacao']) ?>">
        </div>

        <!-- CPF / CNPJ -->
        <div class="linha">
            <label for="cep">Cep:</label>
            <input type="text" id="cep" name="cep" class="form-control" value="<?= htmlspecialchars($clienteAtual['cep'] ?? '') ?>">
        </div>

        <!-- Telefone -->
        <div class="linha">
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" class="form-control" value="<?= htmlspecialchars($clienteAtual['telefone'] ?? '') ?>">
        </div>

        <!-- Data de Nascimento -->
        <div class="linha">
            <label for="data_nasc">Data de Nascimento:</label>
            <input type="text" id="data_nasc" name="data_nasc" class="form-control" value="<?= htmlspecialchars($clienteAtual['data_nasc'] ?? '') ?>">
        </div>

        <!-- Sexo -->
        <div class="linha">
            <label for="sexo">Sexo:</label>
            <select id="sexo" name="sexo" class="form-control">
                <option value="">Selecione</option>
                <option value="M" <?= ($clienteAtual['sexo']=='M') ? 'selected' : '' ?>>Masculino</option>
                <option value="F" <?= ($clienteAtual['sexo']=='F') ? 'selected' : '' ?>>Feminino</option>
            </select>
        </div>

        <!-- Endereço completo -->
        <div class="linha">
            <label for="cep">CEP:</label>
            <input type="text" id="cep" name="cep" class="form-control" value="<?= htmlspecialchars($clienteAtual['cep'] ?? '') ?>">
        </div>
        <div class="linha">
            <label for="logradouro">Logradouro:</label>
            <input type="text" id="logradouro" name="logradouro" class="form-control" value="<?= htmlspecialchars($clienteAtual['logradouro'] ?? '') ?>">
        </div>
        <div class="linha">
            <label for="numero">Número:</label>
            <input type="text" id="numero" name="numero" class="form-control" value="<?= htmlspecialchars($clienteAtual['numero'] ?? '') ?>">
        </div>
        <div class="linha">
            <label for="bairro">Bairro:</label>
            <input type="text" id="bairro" name="bairro" class="form-control" value="<?= htmlspecialchars($clienteAtual['bairro'] ?? '') ?>">
        </div>
        <div class="linha">
            <label for="cidade">Cidade:</label>
            <input type="text" id="cidade" name="cidade" class="form-control" value="<?= htmlspecialchars($clienteAtual['cidade'] ?? '') ?>">
        </div>
        <div class="linha">
            <label for="uf">UF:</label>
            <select id="uf" name="uf" class="form-control">
                <?php
                $ufs = ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'];
                foreach($ufs as $uf){
                    $selected = ($clienteAtual['uf']==$uf) ? 'selected' : '';
                    echo "<option value='$uf' $selected>$uf</option>";
                }
                ?>
            </select>
        </div>


        <!-- Botões -->
        <div class="container-botoes">
            <button type="submit" class="btn btn-warning btn-enviar">Salvar Alterações</button>
            <button type="reset" class="btn btn-limpar">Limpar</button>
        </div>

    </form>
    <?php endif; ?>
</div>
</main>