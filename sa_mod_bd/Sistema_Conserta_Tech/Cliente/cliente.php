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
      <form method="post">

        <div class="topoTitulo">
          <h1>CADASTRO DE CLIENTE</h1>
          <hr>
        </div>

        <!-- Seleção do tipo de pessoa -->
        <div class="linha">
          <!-- Tipo de cliente -->
          <div>
            <div class="linha">
              <label for="tipo_pessoa">
                <div class="alinharTitulo">Selecione o tipo de cliente: </div>
              </label>
              <select id="tipo_pessoa" name="tipo_pessoa" class="form-control tipo_pessoa">
                <option value="">Selecione</option>
                <option value="fisica">Pessoa Física</option>
                <option value="juridica">Pessoa Jurídica</option>
              </select>
            </div>

            <!-- Campos Pessoa Física -->

            <div class="form-container">
              <div id="campos-fisica">
                <div class="campos_fisica">

                  <div class="linha">
                    <label for="id_usuario">Id do usuário:</label>
                    <input type="number" id="id_usuario" name="numero" class="form-control"
                      placeholder="Insira o seu id para identificação">
                  </div>

                  <div class="linha">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome_cliente" name="nome_cliente" class="form-control" placeholder="Nome">
                  </div>

                  <div class="linha">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Exemplo123@gmail.com">
                  </div>

                  <div class="linha">
                    <label for="cpf">CPF:</label>
                    <input type="text" id="cpf" name="cpf" class="form-control" placeholder="000.000.000-00">
                  </div>

                  <div class="linha">
                    <label for="dataNascimento">Data Nascimento:</label>
                    <input type="text" id="dataNascimento" class="form-control" placeholder="Data de Nascimento">
                  </div>

                  <div class="linha">
                    <label for="sexo">Sexo:</label>
                    <select id="sexo" name="sexo" class="form-control">
                      <option value="">Selecione</option>
                      <option value="M">Masculino</option>
                      <option value="F">Feminino</option>
                      <option value="O">Outro</option>
                    </select>
                  </div>

                  <div class="linha">
                    <label for="Telefone">Telefone:</label>
                    <input type="tel" id="telefone" name="telefone" class="form-control" placeholder="(00) 00000-0000">
                  </div>

                  <div class="linha">
                    <label for="cep">CEP:</label>
                    <input type="text" id="cep" name="cep" class="form-control" maxlength="10" placeholder="00000-000">
                  </div>

                  <div class="linha">
                    <label for="logradouro">Logradouro:</label>
                    <input type="text" id="logradouro" name="logradouro" class="form-control" placeholder="Logradouro">
                  </div>

                  <div class="linha">
                    <label for="tipo_casa">Tipo de moradia:</label>
                    <select id="tipo_casa" name="tipo_casa" class="form-control">
                      <option value="">Selecione</option>
                      <option value="R">Residencial</option>
                      <option value="C">Comercial</option>
                    </select>
                  </div>

                  <div class="linha">
                    <label for="uf">Estado (UF):</label>
                    <select id="uf" name="uf" class="form-control">
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
                    <label for="numero">Número:</label>
                    <input type="number" id="numero" name="numero" class="form-control" placeholder="Número">
                  </div>

                  <div class="linha">
                    <label for="cidade">Cidade:</label>
                    <input type="text" id="cidade" name="cidade" class="form-control" placeholder="Cidade">
                  </div>

                  <div class="linha">
                    <label for="bairro">Bairro:</label>
                    <input type="text" id="bairro" name="bairro" class="form-control" placeholder="Bairro">
                  </div>

                  <div class="linha">
                    <label for="complemento">Complemento:</label>
                    <input type="text" id="complemento" name="complemento" class="form-control" 
                      placeholder="Complemento">
                  </div>

                   <div class="linha">
                    <label for="foto_fis">Imagem:</label>
                    <input type="file" id="foto_fis" name="foto_fis" class="form-control">
                  </div>

                  <div class="linha">
                    <label for="observacoes">Observações:</label>
                    <input type="text" id="observacoes" name="observacoes" class="form-control"
                      placeholder="Observações">
                  </div>

                </div>
              </div>
            </div>



            <!-- Campos Pessoa Jurídica -->
            <div class="form-container">
              <div id="campos-juridica">
                <div class="campos_juridica">


                  <div class="linha">
                    <label for="id_usuario">Id do usuário:</label>
                    <input type="number" id="id_usuario_jur" name="id_usuario_jur" class="form-control"
                      placeholder="Insira o seu id para identificação">
                  </div>


                  <div class="linha">
                    <label for="id_usuario">Razão Social:</label>
                    <input type="text" id="razao_social" name="razao_social" class="form-control"
                      placeholder="Razão Social">
                  </div>

                  <div class="linha">
                    <label for="cnpj">CNPJ:</label>
                    <input type="text" id="cnpj" name="cnpj" class="form-control" placeholder="00.000.000/0000-00">
                  </div>

                  <div class="linha">
                    <label for="dataFundacao">Data de fundação:</label>
                    <input type="text" id="dataFundacao" class="form-control" placeholder="Data de fundação">
                  </div>


                  <div class="linha">
                    <label for="Telefone">Telefone:</label>
                    <input type="text" id="telefone_jur" name="telefone" class="form-control"
                      placeholder="(00) 00000-0000">
                  </div>


                  <div class="linha">
                    <label for="email">Email:</label>
                    <input type="email" id="email_jur" name="email_jur" class="form-control"
                      placeholder="Exemplo@corporação_nome.com.br">
                  </div>

                  <div class="linha">
                    <label for="cep">CEP:</label>
                    <input type="text" id="cep_jur" name="cep" class="form-control" maxlength="10"
                      placeholder="00000-000">
                  </div>

                  <div class="linha">
                    <label for="logradouro">Logradouro:</label>
                    <input type="text" id="logradouro_jur" name="logradouro" class="form-control"
                      placeholder="Logradouro">
                  </div>

                  <div class="linha">
                    <label for="tipo_estabelecimento">Tipo de estabelecimento:</label>
                    <select id="tipo_estabelecimento" name="estabelecimento" class="form-control">
                      <option value="">Selecione</option>
                      <option value="R">Residencial</option>
                      <option value="C">Comercial</option>
                    </select>
                  </div>

                  <div class="linha">
                    <label for="uf">Estado (UF):</label>
                    <select id="uf_jur" name="uf" class="form-control">
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
                    <label for="numero">Número:</label>
                    <input type="number" id="numero_jur" name="numero" class="form-control" placeholder="Número">
                  </div>

                  <div class="linha">
                    <label for="cidade">Cidade:</label>
                    <input type="text" id="cidade_jur" name="cidade" class="form-control" placeholder="Cidade">
                  </div>

                  <div class="linha">
                    <label for="bairro">Bairro:</label>
                    <input type="text" id="bairro_jur" name="bairro" class="form-control" placeholder="Bairro">
                  </div>

                  <div class="linha">
                    <label for="complemento">Complemento:</label>
                    <input type="text" id="complemento_jur" name="complemento" class="form-control"
                      placeholder="Complemento">
                  </div>

                  <div class="linha">
                    <label for="Telefone">Imagem:</label>
                    <input type="file" id="foto_jur" name="foto_jur" class="form-control">
                  </div>

                  <div class="linha">
                    <label for="observacoes">Observações:</label>
                    <input type="text" id="observacoes_jur" name="observacoes" class="form-control"
                      placeholder="Observações">
                  </div>

                </div>
              </div>
            </div>
            <div class="container-botoes">
              <div class="enviar">
                <button type="button" id="enviar" class="form-control btn-enviar" onclick="return conferirCampos()">
                  Cadastrar </button>
              </div>

              <div class="limpar">
                <button type="reset" id="limpar" class="form-control btn-limpar"> Limpar </button>
              </div>
            </div>
      </form>
    </div>
  </main>


  <!-- Links javascript -->
  <script src="../Menu_lateral/carregar-menu.js" defer></script>
  <script src="cliente.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</body>

</html>