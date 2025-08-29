<?php
    session_start();
    require_once '../Conexao/conexao.php';

    //verifica se o cliente tem permissao de adm
    if($_SESSION['perfil'] !=1){
        echo "<script>alert('Acesso negado!');window.location.href='principal.php';</script>";
        exit();
    }

    //inicializa variaveis
    $cliente=null;

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(!empty($_POST['busca_cliente'])){
            $busca=trim($_POST['busca_cliente']);

            //verifica se a busca é um numero (id) ou um nome
            if(is_numeric($busca)){
                $sql="SELECT * FROM cliente where id_cliente = :busca";
                $stmt=$pdo->prepare($sql);
                $stmt->bindParam(':busca',$busca,PDO::PARAM_INT);
            } else {
                $sql="SELECT * FROM cliente where nome LIKE :busca_nome";
                $stmt=$pdo->prepare($sql);
                $stmt->bindValue(':busca_nome',"$busca%",PDO::PARAM_STR);
            }

            $stmt->execute();
            $cliente=$stmt->fetch(PDO::FETCH_ASSOC);

            //se o cliente nao for encontrado, exibe um alerta
            if(!$cliente){
                echo "<script>alert('Cliente não encontrado!');</script>";
            }
        }
    }
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
    <link rel="stylesheet" href="cliente.css" />
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
    <div id="menu-container"></div>
    <main>
    <div class="conteudo">
    <h2 align="center">Alterar cliente</h2>
    
    <form action="alterar_cliente.php" method="POST">
        <label for="busca_cliente">Digite o ID ou Nome do cliente</label>
        <input type="text" id="busca_cliente" name="busca_cliente" required onkeyup="buscarSugestoes()">

        <!-- div para exibis sugestoes de clientes -->
        <div id="sugestoes"></div>
        <button class="btn btn-primary" type="submit">Buscar</button>
    </form>

    <?php if($cliente): ?>
        <!-- formulario para alterar cliente -->
        <form action="processa_alteracao_cliente.php" method="POST">
            <input type="hidden" name="id_cliente" value="<?=htmlspecialchars($cliente['id_cliente'])?>">

            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" value="<?=htmlspecialchars($cliente['nome'])?>" required>

            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" value="<?=htmlspecialchars($cliente['email'])?>" required>

            <label for="id_perfil">Perfil</label>
            <select id="id_perfil" name="id_perfil">
                <option value="1" <?=$cliente['id_perfil'] == 1 ?'select':''?>>Administrador</option>
                <option value="2" <?=$cliente['id_perfil'] == 2 ?'select':''?>>Secretaria</option>
                <option value="3" <?=$cliente['id_perfil'] == 3 ?'select':''?>>Almoxarife</option>
                <option value="4" <?=$cliente['id_perfil'] == 4 ?'select':''?>>Cliente</option>
            </select>

            <!-- se o cliente logado for adm, exibir opção de alterar senha -->
            <?php if($_SESSION['perfil']==1): ?>
                <label for="nova_senha">Nova senha</label>
                <input type="password" id="nova_senha" name="nova_senha">
            <?php endif; ?>

            <button class="btn btn-primary" type="submit">Alterar</button>
            </br>
            <button class="btn btn-primary" type="reset">Limpar</button>
        </form>
    <?php endif; ?>
    <p align="center"><a class="btn btn-secondary" role="button" href="principal.php">Voltar</a></p>
    </div>
    </main>
    <!-- Links javascript -->
    <script src="../Menu_lateral/carregar-menu.js" defer></script>
    <script src="cliente.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</body>
</html>