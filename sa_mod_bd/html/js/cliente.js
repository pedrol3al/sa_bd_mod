// Função para aplicar uma máscara de formatação a um input
function aplicarMascara(input, mascara) {
  // Adiciona um ouvinte de evento para quando o usuário digitar no input
  input.addEventListener('input', () => {
    // Remove tudo que não for número do valor digitado (apenas dígitos)
    const numeros = input.value.replace(/\D/g, '');

    let resultado = ''; // Variável para montar o valor formatado
    let index = 0; // Índice para percorrer os números digitados

    // Percorre a máscara e os números ao mesmo tempo
    for (let i = 0; i < mascara.length && index < numeros.length; i++) {
      // Se o caractere da máscara for '#', substitui pelo número correspondente
      if (mascara[i] === '#') {
        resultado += numeros[index++];
// Máscaras para os campo determinados

function setCursorPosition(pos, el) {
  el.focus();
  if (el.setSelectionRange) {
    el.setSelectionRange(pos, pos);
  } else if (el.createTextRange) {
    let range = el.createTextRange();
    range.collapse(true);
    range.moveEnd('character', pos);
    range.moveStart('character', pos);
    range.select();
  }
}

function mascaraGuia(input, mascara) {
  // Inicializa o campo com a máscara se vazio
  if (!input.value) {
    input.value = mascara;
  }

  input.addEventListener('input', function () {
    let valor = input.value.replace(/\D/g, '');
    let resultado = '';
    let pos = 0;

    for (let i = 0; i < mascara.length; i++) {
      if (mascara[i] === '0') {
        if (pos < valor.length) {
          resultado += valor[pos];
          pos++;
        } else {
          resultado += '0';
        }
      } else {
        // Caso contrário, mantém o caractere da máscara (como pontos, traços, parênteses)
        resultado += mascara[i];
      }
    }

    // Atualiza o valor do input com o texto formatado
    input.value = resultado;

    // Coloca cursor na posição do primeiro zero não preenchido
    let firstZero = resultado.indexOf('0');
    if (firstZero !== -1) {
      setCursorPosition(firstZero, input);
    } else {
      setCursorPosition(resultado.length, input);
    }
  });

  input.addEventListener('focus', function () {
    // Se quiser, pode remover isso para não ficar reposicionando o cursor toda vez que foca
    let firstZero = input.value.indexOf('0');
    if (firstZero !== -1) {
      setCursorPosition(firstZero, input);
    }
  })};

document.addEventListener('DOMContentLoaded', function () {
  mascaraGuia(document.getElementById('cpf'), '000.000.000-00');
  mascaraGuia(document.getElementById('rg'), '00.000.000-0');
  mascaraGuia(document.getElementById('telefone'), '(00) 0000-0000');
  mascaraGuia(document.getElementById('celular'), '(00) 00000-0000');
  mascaraGuia(document.getElementById('cep'), '00000-000');
});

//Verificação dos campos

//Nega letras

document.addEventListener('DOMContentLoaded', () => {
  const Numero = document.getElementById('num');
  const codigo = document.getElementById('codigo');
  const codigoUsuario = document.getElementById('codigoUsuario');

  function somenteNumeros(event) {
    // Permite teclas de controle: backspace, delete, setas, tab
    const teclasPermitidas = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab'];

    if (teclasPermitidas.includes(event.key)) {
      return;
    }

    // Bloqueia se não for número
    if (!/^[0-9]$/.test(event.key)) {
      event.preventDefault();
    }
  }
  Numero.addEventListener('keydown', somenteNumeros);
  codigo.addEventListener('keydown', somenteNumeros);
  codigoUsuario.addEventListener('keydown', somenteNumeros);
});

//Nega números

document.addEventListener('DOMContentLoaded', () => {
  const camposTexto = [
    document.getElementById('nome'),
    document.getElementById('bairro'),
    document.getElementById('cidade'),
  ];

  function bloquearNumeros(event) {
    // Permite teclas de controle: backspace, delete, setas, tab, espaço
    const teclasPermitidas = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab', ' '];

    if (teclasPermitidas.includes(event.key)) {
      return;
    }

    // Bloqueia números
    if (/^[0-9]$/.test(event.key)) {
      event.preventDefault();
    }
  }

  camposTexto.forEach(campo => {
    campo.addEventListener('keydown', bloquearNumeros);
  });
});

//Verificação de email

document.addEventListener('DOMContentLoaded', () => {
  const campoEmail = document.getElementById('email');
  let alertMostrado = false;

  campoEmail.addEventListener('blur', () => {
    const email = campoEmail.value.trim();
    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (email !== '' && !regexEmail.test(email)) {
      if (!alertMostrado) {
        alert('Por favor, insira um email válido.');
        alertMostrado = true;
        campoEmail.focus();
      }
    } else {
      alertMostrado = false; // reseta se o email está correto ou vazio
    }
  });
});


//Ao apertar enter, passa para o proximo campo

document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('form.formulario');
  const campos = Array.from(form.querySelectorAll('input, select, textarea'));

  campos.forEach((campo, index) => {
    campo.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault(); // evita envio do form ou outro comportamento padrão

        const proximoIndex = index + 1;

        if (proximoIndex < campos.length) {
          campos[proximoIndex].focus();
        }
      }
    });
  });
});


//Armazenamento de dados

function validarCamposObrigatorios() {
  const campos = document.querySelectorAll('.formulario input, .formulario select, .formulario textarea');
  let camposValidos = true;

  campos.forEach(campo => {
    if (campo.value.trim() === '') {
      campo.classList.add('campo-invalido'); // Destaque visual para campo vazio
      camposValidos = false;
    } else {
      campo.classList.remove('campo-invalido');
    }
  });

  if (!camposValidos) {
    alert('Por favor, preencha todos os campos obrigatórios.');
  }

  return camposValidos;
}

// Espera o carregamento completo do DOM para executar
document.addEventListener('DOMContentLoaded', () => {
  // Seleciona os inputs pelo ID
  const cpf = document.getElementById('cpf');
  const rg = document.getElementById('rg');
  const cep = document.getElementById('cep');
  const telefone = document.getElementById('telefone');
  const celular = document.getElementById('celular');

  // Aplica a máscara correta para cada campo, se existir
  if (cpf) aplicarMascara(cpf, '###.###.###-##');       // Máscara CPF: 000.000.000-00
  if (rg) aplicarMascara(rg, '##.###.###-#');           // Máscara RG: 00.000.000-0
  if (cep) aplicarMascara(cep, '#####-###');            // Máscara CEP: 00000-000
  if (telefone) aplicarMascara(telefone, '(##) ####-####'); // Telefone fixo: (00) 0000-0000
  if (celular) aplicarMascara(celular, '(##) #####-####'); // Celular: (00) 00000-0000
  const btnCadastrar = document.getElementById('bt_cadastrar');

  btnCadastrar.addEventListener('click', () => {
    // Primeiro valida os campos
    if (!validarCamposObrigatorios()) {
      return; // Para o cadastro se tiver campo vazio
    }

    // Se passou na validação, monta o objeto cliente e salva no localStorage
    const cliente = {
      codigo: document.getElementById('codigo').value.trim(),
      codigoUsuario: document.getElementById('codigoUsuario').value.trim(),
      nome: document.getElementById('nome').value.trim(),
      cpf: document.getElementById('cpf').value.trim(),
      rg: document.getElementById('rg').value.trim(),
      data_nasc: document.getElementById('data_nasc').value.trim(),
      sexo: document.getElementById('sexo').value,
      endereco: document.getElementById('endereco').value.trim(),
      num: document.getElementById('num').value.trim(),
      tipo_cliente: document.getElementById('tipo_cliente').value.trim(),
      complemento: document.getElementById('complemento').value.trim(),
      bairro: document.getElementById('bairro').value.trim(),
      uf: document.getElementById('uf').value,
      cep: document.getElementById('cep').value.trim(),
      cidade: document.getElementById('cidade').value.trim(),
      telefone: document.getElementById('telefone').value.trim(),
      celular: document.getElementById('celular').value.trim(),
      email: document.getElementById('email').value.trim(),
      data_cadastro: document.getElementById('data_cadastro').value.trim(),
      observacoes: document.getElementById('observacoes').value.trim()
    };

    let clientes = JSON.parse(localStorage.getItem('clientes')) || [];
    clientes.push(cliente);
    localStorage.setItem('clientes', JSON.stringify(clientes));

    alert('Cliente cadastrado com sucesso!');
    document.querySelector('.formulario').reset();
  });
});
