<?php
    session_start();
    require_once '../Conexao/conexao.php';

    //verifica se o os tem permissao de adm ou secretaria
    if($_SESSION['perfil'] !=1 && $_SESSION['perfil'] !=2){
        echo "<script>alert('Acesso negado!');window.location.href='principal.php';</script>";
        exit();
    }

    $os=[]; //inicializa a variavel para evitar erros

    //se o formulario for enviado, busca o os pelo id ou nome
    if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['busca'])){
        $busca=trim($_POST['busca']);

        //verifica se a busca é um numero ou nome
        if(is_numeric($busca)){
            $sql="SELECT os.*, cliente.nome, cliente.id_cliente FROM os INNER JOIN cliente on os.id_cliente=cliente.id_cliente WHERE id_os = :busca ORDER BY data_termino ASC";
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(':busca',$busca, PDO::PARAM_INT);
        } else {
            $sql="SELECT os.*, cliente.id_cliente, cliente.nome FROM os INNER JOIN cliente ON os.id_cliente = cliente.id_cliente WHERE nome LIKE :busca_nome ORDER BY nome ASC";
            $stmt=$pdo->prepare($sql);
            $stmt->bindValue(':busca_nome',"$busca%", PDO::PARAM_STR); //MUDAR AQUI PARA A ENTREGA (ja mudei)
        }
    } else {
        $sql="SELECT os.*, cliente.id_cliente, cliente.nome FROM os INNER JOIN cliente on os.id_cliente=cliente.id_cliente ORDER BY data_termino ASC";
        $stmt=$pdo->prepare($sql);
    }
    $stmt->execute();
    $oss=$stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar os</title>
    <!-- Links bootstrapt e css -->
    <link rel="stylesheet" href="css_os.css">
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
    <h2 align="center">Buscar Ordem de serviço</h2>
    <form action="buscar_os.php" method="POST">
        <label for="busca">Digite o ID ou Nome(cliente): </label>
        <input type="text" id="busca" name="busca">
        <button class="btn btn-primary" type="submit">Pesquisar</button>
    </form>
    <?php if(!empty($oss)): ?>
        <div class="container">
        <table id="tabela_pesquisa" border="1" class="table table-light table-hover">
            <tr>
                <th>ID</th>
                <th>Nome do cliente</th>
                <th>Número de série</th>
                <th>Data de abertura</th>
                <th>Data de término</th>
                <th>Modelo</th>
                <th>Número do aparelho</th>
                <th>Defeito relatado</th>
                <th>Condição</th>
                <th>Observações</th>
                <th>Fabricante</th>
                <th>Ações</th>
            </tr>
            <?php foreach($oss as $os): ?>
                <tr>
                    <td><?=htmlspecialchars($os['id_os'])?></td>
                    <td><?=htmlspecialchars($os['nome'])?></td>
                    <td><?=htmlspecialchars($os['num_serie'])?></td>
                    <td><?=htmlspecialchars($os['data_abertura'])?></td>
                    <td><?=htmlspecialchars($os['data_termino'])?></td>
                    <td><?=htmlspecialchars($os['modelo'])?></td>
                    <td><?=htmlspecialchars($os['num_aparelho'])?></td>
                    <td><?=htmlspecialchars($os['defeito_rlt'])?></td>
                    <td><?=htmlspecialchars($os['condicao'])?></td>
                    <td><?=htmlspecialchars($os['observacoes'])?></td>
                    <td><?=htmlspecialchars($os['fabricante'])?></td>
                    <td>
                        <a class="btn btn-warning" href="alterar_os.php?id=<?=htmlspecialchars($os['id_os'])?>">Alterar</a>
                        <a class="btn btn-danger" href="excluir_os.php?id=<?=htmlspecialchars($os['id_os'])?>" onclick="return confirm('Tem certeza da exclusão?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <?php else: ?>
            <p align="center">Nenhum ordem de serviço encontrada.</p> 
        <?php endif; ?>
        </div>
        </br>
        <p align="center"><a class="btn btn-secondary" role="button" href="index.php">Voltar</a></p>
        </div>
    </main>
    <script src="../Menu_lateral/carregar-menu.js" defer></script>
    <script src="os.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</body>
</html>