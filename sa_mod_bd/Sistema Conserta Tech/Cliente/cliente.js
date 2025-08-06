document.addEventListener("DOMContentLoaded", function () {
  flatpickr("#dataNascimento", {
    dateFormat: "d/m/Y",
    maxDate: "today"
  });
});

document.addEventListener("DOMContentLoaded", function () {
  flatpickr("#dataFundacao", {
    dateFormat: "d/m/Y",
    maxDate: "today"
  });
});

const notyf = new Notyf({
  position: { x: 'center', y: 'top' }
});



// Espera até que todo o conteúdo da página esteja carregado
document.addEventListener("DOMContentLoaded", function () {

  // Obtém o select do tipo de pessoa
  const tipoPessoa = document.getElementById("tipo_pessoa");

  // Obtém os contêineres dos campos de pessoa física e jurídica
  const camposFisica = document.getElementById("campos-fisica");
  const camposJuridica = document.getElementById("campos-juridica");
  const btnEnviar = document.getElementById("enviar")
  const btnLimpar = document.getElementById("limpar");

  // Adiciona um ouvinte de evento ao select, que será executado sempre que o valor mudar
  tipoPessoa.addEventListener("change", function () {

    // Pega o valor selecionado no select (fisica, juridica ou vazio)
    const valor = tipoPessoa.value;

    // Se o valor for "fisica", mostra os campos da pessoa física e esconde os da jurídica
    if (valor === "fisica") {
      camposFisica.style.display = "block";      // Mostra os campos da pessoa física
      btnEnviar.style.display = "block";         //O botão enviar reaparece ao selecionar o cliente fisico 
      btnLimpar.style.display = "block";         //O botão limpar reaparece ao selecionar o cliente fisico 
      camposJuridica.style.display = "none";     // Esconde os campos da jurídica


      // Se o valor for "juridica", mostra os campos da jurídica e esconde os da física
    } else if (valor === "juridica") {
      camposFisica.style.display = "none";       // Esconde os campos da pessoa física
      btnEnviar.style.display = "block";         //O botão enviar reaparece ao selecionar o cliente juridico 
      btnLimpar.style.display = "block";         //O botão limpar reaparece ao selecionar o cliente juridico 
      camposJuridica.style.display = "block";    // Mostra os campos da jurídica

      // Se nenhum for selecionado (valor vazio), esconde ambos
    } else {
      camposFisica.style.display = "none";
      camposJuridica.style.display = "none";
    }
  });
});


function conferirCampos() {
  const tipoPessoa = document.getElementById('tipo_pessoa').value;

  if (tipoPessoa === '') {
    notyf.error(`Selecione o tipo de cliente!`);
    document.getElementById('tipo_pessoa').focus();
    return false;
  }



  // Campos obrigatórios para Pessoa Física
  const camposFisica = [
    { id: 'nome_cliente', nome: 'Nome' },
    { id: 'id_usuario', nome: 'Indentificação usuario' },
    { id: 'email', nome: 'Email' },
    { id: 'cpf', nome: 'CPF' },
    { id: 'dataNascimento', nome: 'Data de Nascimento' },
    { id: 'sexo', nome: 'Sexo' },
    { id: 'telefone', nome: 'Telefone' },
    { id: 'cep', nome: 'CEP' },
    { id: 'logradouro', nome: 'Logradouro' },
    { id: 'tipo_casa', nome: 'Tipo de moradia' },
    { id: 'uf', nome: 'Estado (UF)' },
    { id: 'numero', nome: 'Número' },
    { id: 'cidade', nome: 'Cidade' },
    { id: 'bairro', nome: 'Bairro' }
  ];

  // Campos obrigatórios para Pessoa Jurídica
  const camposJuridica = [
    { id: 'razao_social', nome: 'Razão Social' },
    { id: 'id_usuario_jur', nome: 'Indentificação usuario' },
    { id: 'cnpj', nome: 'CNPJ' },
    { id: 'dataFundacao', nome: 'Data de Fundação' },
    { id: 'telefone_jur', nome: 'Telefone' },
    { id: 'email_jur', nome: 'Email da corporação' },
    { id: 'cep_jur', nome: 'CEP' },
    { id: 'logradouro_jur', nome: 'Logradouro' },
    { id: 'tipo_estabelecimento', nome: 'Tipo de Estabelecimento' },
    { id: 'uf_jur', nome: 'Estado (UF)' },
    { id: 'numero_jur', nome: 'Número' },
    { id: 'cidade_jur', nome: 'Cidade' },
    { id: 'bairro_jur', nome: 'Bairro' }
  ];

  const camposParaVerificar = tipoPessoa === 'fisica' ? camposFisica : camposJuridica;

  for (let campo of camposParaVerificar) {
    const elemento = document.getElementById(campo.id);
    if (elemento && elemento.value.trim() === '') {
      notyf.error(`Preencha todos os campos!`);
      elemento.focus();
      return false;
    }
  }

  if ("#dataNascimento")

    // Todos os campos estão preenchidos corretamente
    notyf.success(`Cliente cadastrado!`);
  return true;

}


$(document).ready(function () {
  $('#cpf').mask('000.000.000-00')
})

$(document).ready(function () {
  $('#telefone').mask('(00) 00000-0000')
})

$(document).ready(function () {
  $('#telefone_jur').mask('(00) 00000-0000')
})

$(document).ready(function () {
  $('#cep').mask('00000-00')
})

$(document).ready(function () {
  $('#cep_jur').mask('00000-00')
})

$(document).ready(function () {
  $('#cnpj').mask('00.000.000/0000-00')
})
