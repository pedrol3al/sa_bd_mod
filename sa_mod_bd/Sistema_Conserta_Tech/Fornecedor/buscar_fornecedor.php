<?php
    session_start();
    require_once '../Conexao/conexao.php';

    //verifica se o fornecedor tem permissao de adm ou secretaria
    if($_SESSION['perfil'] !=1 && $_SESSION['perfil'] !=2){
        echo "<script>alert('Acesso negado!');window.location.href='principal.php';</script>";
        exit();
    }

    $fornecedor=[]; //inicializa a variavel para evitar erros

    //se o formulario for enviado, busca o fornecedor pelo id ou nome
    if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['busca'])){
        $busca=trim($_POST['busca']);

        //verifica se a busca é um numero ou nome
        if(is_numeric($busca)){
            $sql="SELECT * FROM fornecedor WHERE id_fornecedor = :busca ORDER BY nome ASC";
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(':busca',$busca, PDO::PARAM_INT);
        } else {
            $sql="SELECT * FROM fornecedor WHERE razao_social LIKE :busca_nome ORDER BY razao_social ASC";
            $stmt=$pdo->prepare($sql);
            $stmt->bindValue(':busca_nome',"$busca%", PDO::PARAM_STR); //MUDAR AQUI PARA A ENTREGA (ja mudei)
        }
    } else {
        $sql="SELECT * FROM fornecedor ORDER BY razao_social ASC";
        $stmt=$pdo->prepare($sql);
    }
    $stmt->execute();
    $fornecedores=$stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar fornecedor</title>
    <!-- Links bootstrapt e css -->
    <link rel="stylesheet" href="css_fornecedor.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
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
    <h2 align="center">Buscar fornecedores</h2>
    <form action="buscar_fornecedor.php" method="POST">
        <label for="busca">Digite o ID ou Nome(opcional): </label>
        <input type="text" id="busca" name="busca">
        <button class="btn btn-primary" type="submit">Pesquisar</button>
    </form>
    <?php if(!empty($fornecedores)): ?>
        <div class="container">
        <table id="tabela_pesquisa" border="1" class="table table-light table-hover">
            <tr>
                <th>ID</th>
                <th>Razão Social</th>
                <th>Email</th>
                <th>CNPJ</th>
                <th>Data de fundação</th>
                <th>Produto fornecido</th>
                <th>Data de cadastro</th>
                <th>Foto</th>
                <th>Ações</th>
            </tr>
            <?php foreach($fornecedores as $fornecedor): ?>
                <tr>
                    <td><?=htmlspecialchars($fornecedor['id_fornecedor'])?></td>
                    <td><?=htmlspecialchars($fornecedor['razao_social'])?></td>
                    <td><?=htmlspecialchars($fornecedor['email'])?></td>
                    <td><?=htmlspecialchars($fornecedor['cnpj'])?></td>
                    <td><?=htmlspecialchars($fornecedor['data_fundacao'])?></td>
                    <td><?=htmlspecialchars($fornecedor['produto_fornecido'])?></td>
                    <td><?=htmlspecialchars($fornecedor['data_cad'])?></td>
                    <td><img src="../img/techinho.png<?= htmlspecialchars($fornecedor['foto_fornecedor']) ?>" 
                        alt="Foto do fornecedor" 
                        width="50" height="50">
                    </td>
                    <td>
                        <a class="btn btn-warning" href="alterar_fornecedor.php?id=<?=htmlspecialchars($fornecedor['id_fornecedor'])?>">Alterar</a>
                        <a class="btn btn-danger" href="excluir_fornecedor.php?id=<?=htmlspecialchars($fornecedor['id_fornecedor'])?>" onclick="return confirm('Tem certeza da exclusão?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <?php else: ?>
            <p align="center">Nenhum fornecedor encontrado.</p> 
        <?php endif; ?>
        </div>
        </br>
        <p align="center"><a class="btn btn-secondary" role="button" href="index.php">Voltar</a></p>
        </div>
    </main>
    <script src="../Menu_lateral/carregar-menu.js" defer></script>
    <script src="fornecedor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</body>
</html>