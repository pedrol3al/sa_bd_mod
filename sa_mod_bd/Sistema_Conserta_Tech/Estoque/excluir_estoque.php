<?php
    session_start();
    require '../Conexao/conexao.php';

    //verifica se o usuario tem permissao de adm
    if($_SESSION['perfil'] !=1){
        echo "<script>alert('Acesso negado!');window.location.href='principal.php';</script>";
        exit();
    }

    //inicializa vriavel para amarzenar usuarios
    $estoques=[];

    //busca todos os usuarios cadastrados em ordem alfabetica
    $sql="SELECT e.*, f.razao_social 
            FROM estoque e
            INNER JOIN fornecedor f ON e.id_fornecedor = f.id_fornecedor
            ORDER BY e.nome_peca ASC";
    $stmt=$pdo->prepare($sql);
    $stmt->execute();
    $estoques=$stmt->fetchAll(PDO::FETCH_ASSOC);

    //se um id for passado via get exclui o usuario
    if(isset($_GET['id']) && is_numeric($_GET['id'])){
        $id_estoque=$_GET['id'];

        //exclui o usuario do banco de dados
        $sql="DELETE FROM estoque WHERE id_pecas =:id";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':id',$id_estoque,PDO::PARAM_INT);

        if($stmt->execute()){
            echo "<script>alert('estoque excluído com sucesso!');window.location.href='excluir_estoque.php';</script>";
        } else {
            echo "<script>alert('Erro ao excluir o estoque!');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir estoque</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Links bootstrapt e css -->
    <link rel="stylesheet" href="css_estoque.css">
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
<body>
    <div id="menu-container"></div>
    <main>
    <div class="conteudo">
    <h2 align="center">Excluir estoque</h2>
    <?php if(!empty($estoques)): ?>
        <div class="container">
        <table border="1" align="center" class="table table-light table-hover">
            <tr class="table-secondary">
                <th>ID</th>
                <th>Nome</th>
                <th>Nome do fornecedor</th>
                <th>Data de cadastro</th>
                <th>Quantidade</th>
                <th>Valor unitário</th>
                <th>Descrição</th>
                <th>Foto da peça</th>
                <th>Ações</th>
            </tr>
            <?php foreach($estoques as $estoque): ?>
            <tr>
                <td><?=htmlspecialchars($estoque['id_pecas'])?></td>
                <td><?=htmlspecialchars($estoque['nome_peca'])?></td>
                <td><?=htmlspecialchars($estoque['razao_social'])?></td>
                <td><?=htmlspecialchars($estoque['data_cadastro'])?></td>
                <td><?=htmlspecialchars($estoque['quantidade'])?></td>
                <td><?=htmlspecialchars($estoque['valor_unitario'])?></td>
                <td><?=htmlspecialchars($estoque['descricao'])?></td>
                <td><img src="../img/techinho.png<?= htmlspecialchars($estoque['imagem_peca']) ?>" 
                    alt="Foto do estoque" 
                    width="50" height="50">
                </td>
                <td>
                    <a class="btn btn-danger" role="button" href="excluir_estoque.php?id=<?=htmlspecialchars($estoque['id_estoque'])?>" onclick="return confirm('Tem certeza de que deseja excluir este estoque?')">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum estoque encontrado!</p>
    <?php endif; ?>
    </br>
    <p align="center"><a class="btn btn-secondary" role="button" href="principal.php">Voltar</a></p>
    </div>
    </div>
    </main>
    
    </div>
    <script src="../Menu_lateral/carregar-menu.js" defer></script>
    <script src="estoque.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</body>
</html>