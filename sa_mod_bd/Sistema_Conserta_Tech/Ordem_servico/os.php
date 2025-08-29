<?php
session_start();
require_once("../Conexao/conexao.php");

$clientes = $pdo->query("SELECT id_cliente, nome FROM cliente")->fetchAll(PDO::FETCH_ASSOC);
$usuarios = $pdo->query("SELECT id_usuario, nome FROM usuario")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro de Ordem de serviço</title>

  <!-- Links bootstrapt e css -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="css_os.css" />
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
      <form method="POST" action="cadastro_os.php" enctype="multipart/form-data">

        <div class="topoTitulo">
          <h1>CADASTRO DE ORDEM DE SERVIÇO</h1>
          <hr>
        </div>

        <div class="linha">
          <div class="form-container">
            <div id="campos-os">
              <div class="campo_os">

                <div class="linha">
                    <label for="id_cliente">Cliente:</label>
                    <select name="id_cliente" id="id_cliente" class="form-control" required>
                        <option value="">Selecione...</option>
                        <?php foreach ($clientes as $c): ?>
                            <option value="<?= $c['id_cliente'] ?>"><?= $c['nome'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="linha">
                    <label for="id_usuario">Usuário:</label>
                    <select name="id_usuario" id="id_usuario" class="form-control" required>
                        <option value="">Selecione...</option>
                        <?php foreach ($usuarios as $u): ?>
                            <option value="<?= $u['id_usuario'] ?>"><?= $u['nome'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="linha">
                  <label for="num_serie">Número de série:</label>
                  <input type="number" id="num_serie" name="num_serie" class="form-control"
                    placeholder="Número de série do aparelho">
                </div>

                <div class="linha">
                  <label for="data_abertura">Data abertura:</label>
                  <input type="date" id="data_abertura" name="data_abertura" class="form-control"
                    placeholder="Data de cadastro da OS">
                </div>

                <div class="linha">
                  <label for="data_termino">Data término:</label>
                  <input type="date" id="data_termino" name="data_termino" class="form-control"
                    placeholder="Data expectada de conclusão">
                </div>

                <div class="linha">
                  <label for="modelo">Modelo:</label>
                  <input type="text" id="modelo" name="modelo" class="form-control"
                    placeholder="Modelo do aparelho">
                </div>

                <div class="linha">
                  <label for="num_aparelho">Número aparelho:</label>
                  <input type="text" id="num_aparelho" name="num_aparelho" class="form-control" maxlength="10"
                    placeholder="Número específico do aparelho">
                </div>

                <div class="linha">
                  <label for="defeito_rlt">Defeito relatado:</label>
                  <input type="text" id="defeito_rlt" name="defeito_rlt" class="form-control"
                    placeholder="Defeito relatado pelo cliente">
                </div>

                <div class="linha">
                  <label for="condicao">Condição:</label>
                  <input type="tel" id="condicao" name="condicao" class="form-control" placeholder="Problema observado pelo técnico">
                </div>

                <div class="linha">
                  <label for="fabricante">Fabricante:</label>
                  <input type="text" id="fabricante" name="fabricante" class="form-control" placeholder="Fabricante do aparelho">
                </div>

                <div class="linha">
                  <label for="observacoes">Observações:</label>
                  <input type="box-text" id="observacoes" name="observacoes" class="form-control" placeholder="Observações adicionais">
                </div>

                <div class="linha">
                    <label for="status">Status:</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="">Selecione...</option>
                        <option value="1">Em andamento</option>
                        <option value="2">Concluído</option>
                        <option value="3">Atrasado</option>
                    </select>
                </div>
              </div>
            </div>
          </div>

          <div class="container-botoes">
            <div class="enviar">
              <button id="enviar" class="form-control btn-success" type="submit">
                Cadastrar
              </button>
            </div>

            <div class="limpar">
              <button type="reset" id="limpar" class="form-control btn-limpar"> Cancelar </button>
            </div>
          </div>
      </form>
    </div>
  </main>

  <!-- Links javascript -->
  <script src="../Menu_lateral/carregar-menu.js" defer></script>
  <script src="pesquisa_forn.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</body>

</html>