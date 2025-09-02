<?php
session_start();
require '../Conexao/conexao.php';

// Verifica se é admin
if($_SESSION['perfil'] !=1){
    echo "<script>alert('Acesso negado!');window.location.href='principal.php';</script>";
    exit();
}

// Se um POST for enviado, atualiza o usuario
if(isset($_POST['id_usuario'], $_POST['nome'], $_POST['email'])){
    $id_usuario = $_POST['id_usuario'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $sql="UPDATE usuario SET nome=:nome, email=:email WHERE id_usuario=:id";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);

    if($stmt->execute()){
        echo "<script>alert('Usuario alterado com sucesso!');window.location.href='alterar_usuario.php';</script>";
        exit;
    } else {
        echo "<script>alert('Erro ao alterar o Usuario!');</script>";
    }
}

// Se um GET com id for passado, busca os dados do usuario
$usuarioAtual = null;
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id_usuario = $_GET['id'];
    $sql="SELECT * FROM usuario WHERE id_usuario=:id";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);
    $stmt->execute();
    $usuarioAtual = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Busca todos os usuarios para exibir na tabela
$sql="SELECT * FROM usuario ORDER BY nome ASC";
$stmt=$pdo->prepare($sql);
$stmt->execute();
$usuarios=$stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar usuario</title>
    <!-- Links bootstrapt e css -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="usuario.css" />
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
    <h2 align="center">Alterar usuario</h2>
    <?php if(!empty($usuarios)): ?>
        <div class="container">
        <table border="1" align="center" class="table table-light table-hover">
            <tr class="table-secondary">
                <th>ID</th>
                <th>Perfil</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Username</th>
                <th>Email</th>
                <th>Data de Nascimento</th>
                <th>CEP</th>
                <th>Logradouro</th>
                <th>Número</th>
                <th>Cidade</th>
                <th>Estado</th>
                <th>Bairro</th>
                <th>Telefone</th>
                <th>Foto</th>
                <th>Senha</th>
                </tr>
            <?php foreach($usuarios as $usuario): ?>
                <tr>
                   <td><?= htmlspecialchars($usuario['id_usuario']) ?></td>
                <!-- FOTO DO USUÁRIO -->
                    <td>
                        <img src="../img/<?= htmlspecialchars($usuario['foto_usuario']) ?>" 
                            alt="Foto do usuário" 
                            width="50" height="50"
                            style="border-radius: 50%; object-fit: cover;">
                    </td>

                    <td><?= htmlspecialchars($usuario['id_usuario']) ?></td>
    <td><?= htmlspecialchars($usuario['id_perfil']) ?></td>
    <td><?= htmlspecialchars($usuario['nome']) ?></td>
    <td><?= htmlspecialchars($usuario['cpf']) ?></td>
    <td><?= htmlspecialchars($usuario['username']) ?></td>
    <td><?= htmlspecialchars($usuario['email']) ?></td>
    <td><?= htmlspecialchars($usuario['data_nasc']) ?></td>
    <td><?= htmlspecialchars($usuario['cep']) ?></td>
    <td><?= htmlspecialchars($usuario['logradouro']) ?></td>
    <td><?= htmlspecialchars($usuario['numero']) ?></td>
    <td><?= htmlspecialchars($usuario['cidade']) ?></td>
    <td><?= htmlspecialchars($usuario['estado']) ?></td>
    <td><?= htmlspecialchars($usuario['bairro']) ?></td>
    <td><?= htmlspecialchars($usuario['telefone']) ?></td>
    <!-- FOTO -->
    <td>
        <img src="../img/<?= htmlspecialchars($usuario['foto_usuario']) ?>" 
             alt="Foto do usuário" 
             width="50" height="50" 
             style="border-radius: 50%; object-fit: cover;">
    </td>
                    <a class="btn btn-warning" role="button" href="alterar_usuario.php?id=<?=htmlspecialchars($usuario['id_usuario'])?>" onclick="return confirm('Tem certeza de que deseja alterar este usuario?')">Alterar</a>                
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum usuario encontrado!</p>
    <?php endif; ?>

    <?php if($usuarioAtual): ?>
        <form action="alterar_usuario.php" method="POST" enctype="multipart/form-data">
    <!-- ID oculto -->
    <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($usuarioAtual['id_usuario']) ?>">

    <label for="perfil">Perfil:</label>
    <input type="text" id="perfil" name="perfil" value="<?= htmlspecialchars($usuarioAtual['perfil']) ?>" required>

    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($usuarioAtual['nome']) ?>" required>

    <label for="cpf">CPF:</label>
    <input type="text" id="cpf" name="cpf" value="<?= htmlspecialchars($usuarioAtual['cpf']) ?>" required>

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" value="<?= htmlspecialchars($usuarioAtual['username']) ?>" required>

    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" value="<?= htmlspecialchars($usuarioAtual['email']) ?>" required>

    <label for="data_nasc">Data de Nascimento:</label>
    <input type="date" id="data_nasc" name="data_nasc" value="<?= htmlspecialchars($usuarioAtual['data_nasc']) ?>" required>

    <label for="cep">CEP:</label>
    <input type="text" id="cep" name="cep" value="<?= htmlspecialchars($usuarioAtual['cep']) ?>">

    <label for="logradouro">Logradouro:</label>
    <input type="text" id="logradouro" name="logradouro" value="<?= htmlspecialchars($usuarioAtual['logradouro']) ?>">

    <label for="numero">Número:</label>
    <input type="text" id="numero" name="numero" value="<?= htmlspecialchars($usuarioAtual['numero']) ?>">

    <label for="cidade">Cidade:</label>
    <input type="text" id="cidade" name="cidade" value="<?= htmlspecialchars($usuarioAtual['cidade']) ?>">

    <label for="estado">Estado:</label>
    <input type="text" id="estado" name="estado" value="<?= htmlspecialchars($usuarioAtual['estado']) ?>">

    <label for="bairro">Bairro:</label>
    <input type="text" id="bairro" name="bairro" value="<?= htmlspecialchars($usuarioAtual['bairro']) ?>">

    <label for="telefone">Telefone:</label>
    <input type="text" id="telefone" name="telefone" value="<?= htmlspecialchars($usuarioAtual['telefone']) ?>">

    <!-- Upload de Foto -->
    <label for="foto_usuario">Foto:</label>
    <input type="file" id="foto_usuario" name="foto_usuario" accept="image/*">

    <!-- Mostrar foto atual -->
    <?php if (!empty($usuarioAtual['foto_usuario'])): ?>
        <div>
            <p>Foto atual:</p>
            <img src="../img/<?= htmlspecialchars($usuarioAtual['foto_usuario']) ?>" 
                 alt="Foto do usuário" width="80" height="80"
                 style="border-radius: 50%; object-fit: cover;">
        </div>
        <?php endif; ?>
<?php endif; ?>



    </div>
    </div>
    </main>
    </div>
    <script src="../Menu_lateral/carregar-menu.js" defer></script>
    <script src="usuario.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</body>
</html>