<?php
session_start();

if($_SESSION['perfil'] !=1){
  echo "<script>alert('Acesso negado!');window.location.href='../Principal/main.php';</script>";
  exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro de Funcionários</title>

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
      <form method="POST" action="cadastrar_usuario.php">

        <div class="topoTitulo">
          <h1>CADASTRO DE FUNCIONÁRIOS</h1>
          <hr>
        </div>

        <div class="linha">
          <div class="form-container">
            <div id="campos-usuario">
              <div class="campo_usuario">

                <div class="linha">
                  <label for="nome_usuario">Nome:</label>
                  <input type="text" id="nome_usuario" name="nome_usuario" class="form-control" placeholder="Nome">
                </div>

                <div class="linha">
                  <label for="username">Nome de usuário</label>
                  <input type="text" id="username" name="username" class="form-control" placeholder="Nome de usuário">
                </div>

                <div class="linha">
                  <label for="email_usuario">Email:</label>
                  <input type="email" id="email_usuario" name="email_usuario" class="form-control"
                    placeholder="Exemplo123@gmail.com">
                </div>

                <div class="linha">
                  <label for="senha_usuario">Senha:</label>
                  <input type="password" id="senha_usuario" name="senha_usuario" class="form-control"
                    placeholder="Digite a senha" required>
                </div>

                <div class="linha">
                  <label for="cargo_usuario">Selecione o cargo do Funcionário:</label>
                  <select id="cargo_usuario" name="cargo_usuario" class="form-control">
                    <option value="">Selecione</option>
                    <option value="1">Administrador</option>
                    <option value="2">Atendente</option>
                    <option value="3">Técnico</option>
                    <option value="4">Financeiro</option>
                  </select>
                </div>

                <div class="linha">
                  <label for="cpf_usuario">CPF:</label>
                  <input type="text" id="cpf_usuario" name="cpf_usuario" class="form-control"
                    placeholder="000.000.000-00">
                </div>

                <div class="linha">
                  <label for="dataNascimento">Data Nascimento:</label>
                  <input type="text" id="dataNascimento" name="dataNascimento" class="form-control"
                    placeholder="Data de Nascimento">
                </div>

                <div class="linha">
                  <label for="dataCadastro">Data Cadastro:</label>
                  <input type="text" id="dataCadastro" name="dataCadastro" class="form-control"
                    placeholder="Data de Cadastro">
                </div>

                <div class="linha">
                  <label for="sexo_usuario">Sexo:</label>
                  <select id="sexo_usuario" name="sexo_usuario" class="form-control">
                    <option value="">Selecione</option>
                    <option value="M">Masculino</option>
                    <option value="F">Feminino</option>
                    <option value="O">Outro</option>
                  </select>
                </div>

                <div class="linha">
                  <label for="telefone_usuario">Telefone:</label>
                  <input type="tel" id="telefone_usuario" name="telefone_usuario" class="form-control"
                    placeholder="(00) 00000-0000">
                </div>

                <div class="linha">
                  <label for="cep_usuario">CEP:</label>
                  <input type="text" id="cep_usuario" name="cep_usuario" class="form-control" maxlength="10"
                    placeholder="00000-000">
                </div>

                <div class="linha">
                  <label for="logradouro_usuario">Logradouro:</label>
                  <input type="text" id="logradouro_usuario" name="logradouro_usuario" class="form-control"
                    placeholder="Logradouro">
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
                  <label for="uf_usuario">Estado (UF):</label>
                  <select id="uf_usuario" name="uf_usuario" class="form-control">
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
                  <label for="numero_usuario">Número:</label>
                  <input type="number" id="numero_usuario" name="numero_usuario" class="form-control"
                    placeholder="Número">
                </div>

                <div class="linha">
                  <label for="cidade_usuario">Cidade:</label>
                  <input type="text" id="cidade_usuario" name="cidade_usuario" class="form-control"
                    placeholder="Cidade">
                </div>

                <div class="linha">
                  <label for="bairro_usuario">Bairro:</label>
                  <input type="text" id="bairro_usuario" name="bairro_usuario" class="form-control"
                    placeholder="Bairro">
                </div>

                <div class="linha">
                  <label for="complemento_usuario">Complemento:</label>
                  <input type="text" id="complemento_usuario" name="complemento_usuario" class="form-control"
                    placeholder="Complemento">
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
  <script src="usuario.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</body>

</html>