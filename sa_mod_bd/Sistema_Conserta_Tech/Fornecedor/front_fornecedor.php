<?php
session_start();

if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 3) {
  echo "<script>alert('Acesso negado!');window.location.href='../Login/index.php'</script>";
  exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro de Cliente</title>

  <!-- Links bootstrapt e css -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="css_fornecedor.css" />
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
      <form method="post" action="cadastro_fornecedor.php">

        <div class="topoTitulo">
          <h1>CADASTRO DE FORNECEDOR </h1>
          <hr>
        </div>

        <!-- Campos Pessoa Jurídica -->
        <div class="form-container">
          <div id="campos-fornecedor"> 
            <div class="campo_fornecedor">

              <div class="linha">
                <label for="razao_social_forn">Razão Social:</label>
                <input type="text" id="razao_social_forn" name="razao_social_forn" class="form-control"
                  placeholder="Razão Social">
              </div>

              <div class="linha">
                <label for="cnpj_forn">CNPJ:</label>
                <input type="text" id="cnpj_forn" name="cnpj_forn" class="form-control"
                  placeholder="00.000.000/0000-00">
              </div>

              <div class="linha">
                <label for="dataFundacao_forn">Data de fundação:</label>
                <input type="text" id="dataFundacao_forn" name="dataFundacao_forn" class="form-control"
                  placeholder="Data de fundação">
              </div>

              <div class="linha">
                <label for="dataCadastro_forn">Data de Cadastro:</label>
                <input type="text" id="dataCadastro_forn" name="dataCadastro_forn" class="form-control"
                  placeholder="Data de cadastro">
              </div>

              <div class="linha">
                <label for="telefone_forn">Telefone:</label>
                <input type="text" id="telefone_forn" name="telefone_forn" class="form-control"
                  placeholder="(00) 00000-0000">
              </div>

              <div class="linha">
                <label for="email_forn">Email:</label>
                <input type="email" id="email_forn" name="email_forn" class="form-control"
                  placeholder="Exemplo@corporação_nome.com.br">
              </div>

              <div class="linha">
                <label for="cep_forn">CEP:</label>
                <input type="text" id="cep_forn" name="cep_forn" class="form-control" maxlength="10"
                  placeholder="00000-000">
              </div>

              <div class="linha">
                <label for="logradouro_forn">Logradouro:</label>
                <input type="text" id="logradouro_forn" name="logradouro_forn" class="form-control"
                  placeholder="Logradouro">
              </div>

              <div class="linha">
                <label for="tipo_estabelecimento_forn">Tipo de estabelecimento:</label>
                <select id="tipo_estabelecimento_forn" name="tipo_estabelecimento_forn" class="form-control">
                  <option value="">Selecione</option>
                  <option value="R">Residencial</option>
                  <option value="C">Comercial</option>
                </select>
              </div>

              <div class="linha">
                <label for="uf_forn">Estado (UF):</label>
                <select id="uf_forn" name="uf_forn" class="form-control">
                  <option value="">Selecione</option>
                  <option value="AC">Acre</option>
                  <option value="AL">Alagoas</option>
                  <option value="AP">Amapá</option>
                  <option value="AM">Amazonas</option>
                  <option value="BA">Bahia</option>
                  <option value="CE">Ceará</option>
                  <option value="DF">Distrito Federal</option>
                  <option value="ES">Espírito Santo</option>
                  <option value="GO">Goiás</option>
                  <option value="MA">Maranhão</option>
                  <option value="MT">Mato Grosso</option>
                  <option value="MS">Mato Grosso do Sul</option>
                  <option value="MG">Minas Gerais</option>
                  <option value="PA">Pará</option>
                  <option value="PB">Paraíba</option>
                  <option value="PR">Paraná</option>
                  <option value="PE">Pernambuco</option>
                  <option value="PI">Piauí</option>
                  <option value="RJ">Rio de Janeiro</option>
                  <option value="RN">Rio Grande do Norte</option>
                  <option value="RS">Rio Grande do Sul</option>
                  <option value="RO">Rondônia</option>
                  <option value="RR">Roraima</option>
                  <option value="SC">Santa Catarina</option>
                  <option value="SP">São Paulo</option>
                  <option value="SE">Sergipe</option>
                  <option value="TO">Tocantins</option>
                </select>
              </div>

              <div class="linha">
                <label for="numero_forn">Número:</label>
                <input type="number" id="numero_forn" name="numero_forn" class="form-control" placeholder="Número">
              </div>

              <div class="linha">
                <label for="cidade_forn">Cidade:</label>
                <input type="text" id="cidade_forn" name="cidade_forn" class="form-control" placeholder="Cidade">
              </div>

              <div class="linha">
                <label for="bairro_forn">Bairro:</label>
                <input type="text" id="bairro_forn" name="bairro_forn" class="form-control" placeholder="Bairro">
              </div>

              <div class="linha">
                <label for="complemento_forn">Complemento:</label>
                <input type="text" id="complemento_forn" name="complemento_forn" class="form-control"
                  placeholder="Complemento">
              </div>

              <div class="linha">
                <label for="produto_fornecido">Produto fornecido:</label>
                <input type="text" id="produto_fornecido" name="produto_fornecido" class="form-control" 
                placeholder="Produto fornecido">
              </div>

              <div class="linha">
                <label for="observacoes_forn">Observações:</label>
                <input type="text" id="observacoes_forn" name="observacoes_forn" class="form-control"
                  placeholder="Observações">
              </div>

            </div>
          </div>
        </div>

        <div class="container-botoes">
          <div class="enviar">
            <button type="submit" id="enviar" class="form-control btn-enviar" onclick="conferirCampos()">
              Cadastrar </button>
          </div>

          <div class="limpar">
            <button type="reset" id="limpar" class="form-control btn-limpar" > Limpar </button>
          </div>
        </div>
      </form>
    </div>
  </main>


  <!-- Links javascript -->
  <script src="../Menu_lateral/carregar-menu.js" defer></script>
  <script src="fornecedor.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</body>

</html>