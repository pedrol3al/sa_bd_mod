// Função para aplicar uma máscara de formatação a um input
function aplicarMascara(input, mascara) {
  input.addEventListener('input', () => {
    const numeros = input.value.replace(/\D/g, '');
    let resultado = '';
    let index = 0;

    for (let i = 0; i < mascara.length && index < numeros.length; i++) {
      if (mascara[i] === '#') {
        resultado += numeros[index++];
      } else {
        resultado += mascara[i];
      }
    }

    input.value = resultado;
  });
}

// Máscaras com guia automática (preenchida com zeros)
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
        resultado += mascara[i];
      }
    }

    input.value = resultado;

    let firstZero = resultado.indexOf('0');
    if (firstZero !== -1) {
      setCursorPosition(firstZero, input);
    } else {
      setCursorPosition(resultado.length, input);
    }
  });

  input.addEventListener('focus', function () {
    let firstZero = input.value.indexOf('0');
    if (firstZero !== -1) {
      setCursorPosition(firstZero, input);
    }
  });
}

// Aplica máscaras com guia ao carregar a página
document.addEventListener('DOMContentLoaded', function () {
  mascaraGuia(document.getElementById('cpf'), '000.000.000-00');
  mascaraGuia(document.getElementById('rg'), '00.000.000-0');
  mascaraGuia(document.getElementById('telefone'), '(00) 0000-0000');
  mascaraGuia(document.getElementById('celular'), '(00) 00000-0000');
  mascaraGuia(document.getElementById('cep'), '00000-000');
});

// Nega letras em campos numéricos
document.addEventListener('DOMContentLoaded', () => {
  const Numero = document.getElementById('num');
  const codigo = document.getElementById('codigo');
  const codigoUsuario = document.getElementById('codigoUsuario');

  function somenteNumeros(event) {
    const teclasPermitidas = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab'];

    if (teclasPermitidas.includes(event.key)) {
      return;
    }

    if (!/^[0-9]$/.test(event.key)) {
      event.preventDefault();
    }
  }

  Numero.addEventListener('keydown', somenteNumeros);
  codigo.addEventListener('keydown', somenteNumeros);
  codigoUsuario.addEventListener('keydown', somenteNumeros);
});

// Nega números em campos de texto
document.addEventListener('DOMContentLoaded', () => {
  const camposTexto = [
    document.getElementById('nome'),
    document.getElementById('bairro'),
    document.getElementById('cidade'),
  ];

  function bloquearNumeros(event) {
    const teclasPermitidas = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab', ' '];

    if (teclasPermitidas.includes(event.key)) {
      return;
    }

    if (/^[0-9]$/.test(event.key)) {
      event.preventDefault();
    }
  }

  camposTexto.forEach(campo => {
    campo.addEventListener('keydown', bloquearNumeros);
  });
});

// Validação de email
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
      alertMostrado = false;
    }
  });
});

// Enter avança para o próximo campo
document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('form.formulario');
  const campos = Array.from(form.querySelectorAll('input, select, textarea'));

  campos.forEach((campo, index) => {
    campo.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();

        const proximoIndex = index + 1;

        if (proximoIndex < campos.length) {
          campos[proximoIndex].focus();
        }
      }
    });
  });
});

// Validação dos campos obrigatórios
function validarCamposObrigatorios() {
  const campos = document.querySelectorAll('.formulario input, .formulario select, .formulario textarea');
  let camposValidos = true;

  campos.forEach(campo => {
    if (campo.value.trim() === '') {
      campo.classList.add('campo-invalido');
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

// Cadastro de cliente
document.addEventListener('DOMContentLoaded', () => {
  const cpf = document.getElementById('cpf');
  const rg = document.getElementById('rg');
  const cep = document.getElementById('cep');
  const telefone = document.getElementById('telefone');
  const celular = document.getElementById('celular');

  if (cpf) aplicarMascara(cpf, '###.###.###-##');
  if (rg) aplicarMascara(rg, '##.###.###-#');
  if (cep) aplicarMascara(cep, '#####-###');
  if (telefone) aplicarMascara(telefone, '(##) ####-####');
  if (celular) aplicarMascara(celular, '(##) #####-####');

  const btnCadastrar = document.getElementById('bt_cadastrar');

  btnCadastrar.addEventListener('click', () => {
    if (!validarCamposObrigatorios()) {
      return;
    }

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
