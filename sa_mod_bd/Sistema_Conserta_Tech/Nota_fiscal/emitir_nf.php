<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Emitir NF</title>


  <!-- Links do css -->
  <link rel="stylesheet" href="css_nf.css" />
  <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" />

  <!-- Link do bootstrap e do favicon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">
</head>

<body>


  <div id="menu-container"></div>

  <!-- Conteúdo Principal -->
  <div class="conteudo">
    <h1>EMITIR NF</h1>
    
    <!-- Container das informações fixas -->
    <div class="info-container">
      <div class="prestador-esquerda">
        <p><strong>CNPJ:</strong> 00.623.904/0001-73</p>
        <p><strong>Nome:</strong> Conserta Tech</p>
        <p><strong>Endereço:</strong> Rua Imaginária, 142</p>
      </div>
      <div class="prestador-direita">
        <p><strong>Município:</strong> Joinville</p>
        <p><strong>I.E:</strong> 123.456.789</p>
        <p><strong>UF:</strong> Santa Catarina</p>
      </div>
    </div>

    <form class="formulario">
      <div class="linha">
        <label for="id_pecas">ID OS:</label>
        <input type="text" id="id_pecas" class="input-curto">

        <label for="nome">Nome:</label>
        <input type="text" id="nome" class="input-longo">
      </div>

      <div class="linha">
        <label for="aparelho_utilizado">Aparelho Utilizado:</label>
        <input type="text" id="aparelho_utilizado" class="input-medio">

        <label for="quantidade">Quantidade:</label>
        <input type="text" id="quantidade" class="input-curto">

        <label for="preco">Preço:</label>
        <input type="text" id="preco" class="input-curto">
      </div>

      <div class="linha">
        <label for="data_registro">Data de Registro:</label>
        <input type="date" id="data_registro" class="input-medio">
      </div>

      <div class="linha">
        <label for="numero_serie">Número da nota:</label>
        <input type="text" id="numero_serie" class="input-medio">
      </div>

      <div class="linha">
        <label for="descricao">Descrição:</label>
        <textarea id="descricao" class="input-longo"></textarea>
      </div>

      <div class="botoes">
        <button type="button" id="bnt-cadastrar" class="cadastrar"><i class="bi bi-save"></i> Cadastrar</button>
        <button type="button" id="bntPesquisar" class="pesquisar"><i class="bi bi-search"></i> Pesquisar</button>
        <button type="reset" id="bnt-novo" class="novo"><i class="bi bi-plus-circle"></i> Novo</button>
        <button type="button" id="btn-imprimir" class="imprimir"><i class="bi bi-printer"></i> Imprimir NF</button>
        <button type="button" id="btn-cancelar-edicao" style="display: none;">Cancelar</button>
      </div>
    </form>
  </div>

  <!-- Links javascript -->
  <script src="../Menu_lateral/carregar-menu.js"></script>
  <script src="emitir_nf.js"></script>

</body>
</html>