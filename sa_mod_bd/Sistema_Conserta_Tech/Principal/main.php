<?php
session_start();
require_once("../Conexao/conexao.php");

$id_perfil = $_SESSION['perfil'];
$sqlPerfil = "SELECT perfil FROM perfil WHERE id_perfil =:id_perfil";
$stmtPerfil = $pdo->prepare($sqlPerfil);
$stmtPerfil->bindParam(':id_perfil', $id_perfil);
$stmtPerfil->execute();
$perfil = $stmtPerfil->fetch(PDO::FETCH_ASSOC);
$nome_perfil = $perfil['perfil'];

// Query
$sqlOsAberta = "SELECT COUNT(*) AS total_abertas FROM os WHERE status = 1";
$stmt = $pdo->query($sqlOsAberta);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Quantidade de OS abertas
$total_abertas = $result['total_abertas'];

// Query
$sqlValorAberto = "SELECT SUM(p.valor_total) AS valor_aberto 
FROM pagamento p 
INNER JOIN os o ON p.id_os=o.id_os 
WHERE o.status = 1
";
$stmt = $pdo->query($sqlValorAberto);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Quantidade de OS abertas
$valor_aberto = $result['valor_aberto'];
?>

<!DOCTYPE HTML>

<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title> Conserta Tech - Principal </title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Link dos css -->
    <link rel="stylesheet" href="css_main.css">

    <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css">

    <!-- Link bootstrap e do favicon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">



</head>

<body>

<?php
  include("../Menu_lateral/menu.php"); 
?>


    <!-- Conteúdo principal da página -->
    <div class="animarConteudo">
        <section class="conteudo">

            <div class="tituloTopo">
                <h1 class="titulo">CONSERTA TECH</h1>
                <h2 class="bem_vindo">Bem-Vindo(a): <?php echo $_SESSION["usuario"]; ?>! </br>Perfil:
                    <?php echo $nome_perfil; ?></h2>
            </div>

            <div class="quadrado1">
                <h2 class="titulo_quadrado"> O.S. Abertas</h2>
                <h1 class="num_quadrado" id="num_quadrado1"><?php echo $total_abertas; ?> </h1>
            </div>

            <div class="quadrado2">
                <h2 class="titulo_quadrado"> Contas a receber hoje</h2>
                <h1 class="num_quadrado" id="num_quadrado2">R$ <?php echo $valor_aberto; ?></h1>
            </div>

            <div class="quadrado3">
                <h2 class="titulo_quadrado"> Contas a pagar hoje</h2>
                <h1 class="num_quadrado" id="num_quadrado3"></h1>
            </div>

            <div class="retangulo">
                <h2 class="titulo_quadrado"> Fluxo mensal de Caixa</h2>
                <canvas id="graficoFluxo"></canvas>
            </div>
        </section>
    </div>


    <!-- Link javascript -->
    <script src="../Menu_lateral/carregar-menu.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="main.js"></script>
</body>

</html>