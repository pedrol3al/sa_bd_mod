<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro de Peças</title>

  <!-- Links bootstrapt e css -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="css_estoque.css" />
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
      <form method="POST" action="estoque_cad.php">

        <div class="topoTitulo">
          <h1>CADASTRO DE PEÇAS</h1>
          <hr>
        </div>

        <div class="linha">
          <div class="form-container">
            <div id="campos-usuario">
              <div class="campo_usuario">

                <div class="linha">
                  <label for="id_usuario">Id usuário:</label>
                  <input type="number" id="id_usuario" name="id_usuario" class="form-control"
                    placeholder="Insira seu id">
                </div> 

                <div class="linha">
                  <label for="nome_peca">Nome da peça</label>
                  <input type="text" id="nome_peca" name="nome_peca" class="form-control" placeholder="Nome da peça">
                </div>

                <div class="linha">
                  <label for="id_fornecedor">Id do fornecedor:</label>
                  <input type="text" id="id_fornecedor" name="id_fornecedor" class="form-control"
                    placeholder="Insira o id do fornecedor da peça">
                </div>

                <div class="linha">
                  <label for="dataPeca">Data de cadastro:</label>
                  <input type="text" id="cadPeca" name="cadPeca" class="form-control"
                    placeholder="Insira a data do cadastro realizado" required>
                </div>

                <div class="linha">
                  <label for="quantidade">Quantidade:</label>
                  <input type="number" id="quantidade" name="quantidade" class="form-control"
                    placeholder="Insira a quantia de peças  ">
                </div>

                <div class="linha">
                  <label for="valor_unit">Valor unitário:</label>
                  <input type="text" id="valor_unit" name="valor_unit" class="form-control"
                    placeholder="Valor de cada peça">
                </div>

                <div class="linha">
                  <label for="descricao">Descrição:</label>
                  <input type="text" id="descricao" name="descricao" class="form-control"
                    placeholder="Insira informações adicionais">
                </div>
              </div>
            </div>
          </div>

          <div class="container-botoes">
            <div class="enviar">
              <button id="enviar" class="form-control btn-enviar" onclick="return conferirCampos()">
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
  <script src="cadastrar_estoque.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</body>

</html>