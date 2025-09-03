<?php
session_start();
require '../Conexao/conexao.php';

if($_SESSION['perfil'] !=1){
    echo "<script>alert('Acesso negado!');window.location.href='../Principal/main.php';</script>";
    exit();
}

// Mova todo o código de processamento do POST para DENTRO de uma verificação de método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset(
            $_POST['id_cliente'], $_POST['nome'], $_POST['email'], $_POST['telefone'],
            $_POST['data_nasc'], $_POST['sexo'], $_POST['cep'], $_POST['logradouro'],
            $_POST['numero'], $_POST['bairro'], $_POST['cidade'], $_POST['uf'],
            $_POST['observacao']
        )
    ) {
        $id_cliente = $_POST['id_cliente'];
        $nome       = $_POST['nome'];
        $email      = $_POST['email'];
        $telefone   = $_POST['telefone'];
        $data_nasc  = $_POST['data_nasc'];
        $sexo       = $_POST['sexo'];
        $cep        = $_POST['cep'];
        $logradouro = $_POST['logradouro'];
        $numero     = $_POST['numero'];
        $bairro     = $_POST['bairro'];
        $cidade     = $_POST['cidade'];
        $uf         = $_POST['uf'];
        $observacao = $_POST['observacao'];

        $sql = "UPDATE cliente SET 
                    nome = :nome,
                    email = :email,
                    telefone = :telefone,
                    data_nasc = :data_nasc,
                    sexo = :sexo,
                    cep = :cep,
                    logradouro = :logradouro,
                    numero = :numero,
                    bairro = :bairro,
                    cidade = :cidade,
                    uf = :uf,
                    observacao = :observacao
                WHERE id_cliente = :id";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':data_nasc', $data_nasc);
        $stmt->bindParam(':sexo', $sexo);
        $stmt->bindParam(':cep', $cep);
        $stmt->bindParam(':logradouro', $logradouro);
        $stmt->bindParam(':numero', $numero, PDO::PARAM_INT);
        $stmt->bindParam(':bairro', $bairro);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':uf', $uf);
        $stmt->bindParam(':observacao', $observacao);
        $stmt->bindParam(':id', $id_cliente, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>alert('Cliente alterado com sucesso!');window.location.href='buscar_cliente.php?id=" . $id_cliente . "';</script>";
            exit;
        } else {
            echo "<script>alert('Erro ao alterar o cliente!');</script>";
        }
    } else {
        echo "<script>alert('Por favor, preencha todos os campos obrigatórios!');</script>";
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
    
    // Se não encontrar o cliente, redireciona
    if(!$clienteAtual) {
        echo "<script>alert('Cliente não encontrado!');window.location.href='buscar_cliente.php';</script>";
        exit;
    }
} else {
    // Se não tem ID, redireciona para busca
    echo "<script>alert('Nenhum cliente selecionado!');window.location.href='buscar_cliente.php';</script>";
    exit;
}

// Busca todos os clientes para exibir na tabela (se necessário)
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
     <div class="mb-3">
    <a href="buscar_cliente.php" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
<div class="conteudo">
    <div class="topoTitulo">
        <h1>ALTERAR CLIENTE</h1>
        <hr>
    </div>

    <?php if($clienteAtual): ?>
    <form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id_cliente" value="<?= htmlspecialchars($clienteAtual['id_cliente'] ?? '') ?>">

    <div class="campos_juridica">
        <div class="linha">
            <label for="nome_cliente">Nome:</label>
            <input type="text" id="nome_cliente" name="nome" class="form-control" value="<?= htmlspecialchars($clienteAtual['nome'] ?? '') ?>" required>
        </div>

        <div class="linha">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($clienteAtual['email'] ?? '') ?>" required>
        </div>

        <div class="linha">
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" class="form-control" value="<?= htmlspecialchars($clienteAtual['telefone'] ?? '') ?>">
        </div>

        <div class="linha">
            <label for="data_nasc">Data de Nascimento:</label>
            <input type="text" id="data_nasc" name="data_nasc" class="form-control" value="<?= htmlspecialchars($clienteAtual['data_nasc'] ?? '') ?>">
        </div>

        <div class="linha">
            <label for="sexo">Sexo:</label>
            <select id="sexo" name="sexo" class="form-control">
                <option value="">Selecione</option>
                <option value="M" <?= ($clienteAtual['sexo']=='M') ? 'selected' : '' ?>>Masculino</option>
                <option value="F" <?= ($clienteAtual['sexo']=='F') ? 'selected' : '' ?>>Feminino</option>
            </select>
        </div>

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

        <div class="linha">
            <label for="observacao">Observação:</label>
            <input type="text" id="observacao" name="observacao" class="form-control" value="<?= htmlspecialchars($clienteAtual['observacao'] ?? '') ?>">
        </div>
        
        <div class="container-botoes">
            <button type="submit" class="btn btn-warning btn-enviar">Salvar Alterações</button>
            <button type="reset" class="btn btn-limpar">Limpar</button>
        </div>
    </div>
</form>
    <?php endif; ?>
</div>
</main>
<script>
$(document).ready(function(){
    // Mantenha as máscaras para outros campos
    $('#cpf').mask('000.000.000-00');
    $('#cnpj').mask('00.000.000/0000-00');
    $('#telefone, #telefone_jur').mask('(00) 00000-0000');
    $('#cep, #cep_jur').mask('00000-000');
    
    flatpickr("#data_nasc", {
        dateFormat: "d/m/Y",
        locale: "pt"
    });
});
</script>
<script src="../Menu_lateral/carregar-menu.js" defer></script>
<script src="cliente.js"></script>
</body>
</html>