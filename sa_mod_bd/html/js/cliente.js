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

function aplicarMascara(valor, mascara) {
  let numeros = valor.replace(/\D/g, '');
  let resultado = '';
  let pos = 0;

  for (let i = 0; i < mascara.length; i++) {
    if (mascara[i] === '0') {
      if (pos < numeros.length) {
        resultado += numeros[pos];
        pos++;
      } else {
        break; // Para de montar a máscara se não há mais números
      }
    } else {
      if (pos < numeros.length) {
        resultado += mascara[i];
      } else {
        break; // Evita adicionar traços/pontos se não há números ainda
      }
    }
  }

  return resultado;
}

function mascaraGuia(input, mascara) {
  function atualizar() {
    const valorAntes = input.value;
    const valorFormatado = aplicarMascara(valorAntes, mascara);
    input.value = valorFormatado;

    // Validação visual (borda vermelha se incompleto)
    input.style.borderColor = valorFormatado.length === mascara.length ? '' : 'red';
  }

  input.addEventListener('input', () => {
    const pos = input.selectionStart;
    atualizar();
    setCursorPosition(pos, input);
  });

  input.addEventListener('blur', atualizar);

  input.addEventListener('focus', atualizar);

  input.addEventListener('paste', function (e) {
    e.preventDefault();
    const texto = (e.clipboardData || window.clipboardData).getData('text');
    input.value = aplicarMascara(texto, mascara);
    atualizar();
  });

  // Aplica ao carregar se já tiver valor
  if (input.value) {
    input.value = aplicarMascara(input.value, mascara);
  }
}

document.addEventListener('DOMContentLoaded', function () {
  mascaraGuia(document.getElementById('cpf'), '000.000.000-00');
  mascaraGuia(document.getElementById('rg'), '00.000.000-0');
  mascaraGuia(document.getElementById('telefone'), '(00) 0000-0000');
  mascaraGuia(document.getElementById('celular'), '(00) 00000-0000');
  mascaraGuia(document.getElementById('cep'), '00000-000');
  mascaraGuia(document.getElementById('cnpj'), '00.000.000/0000-00');
});


// ========== [3. Verificação dos campos] ==========
document.addEventListener('DOMContentLoaded', () => {
  const Numero = document.getElementById('num');
  const codigo = document.getElementById('codigo');
  const codigoUsuario = document.getElementById('codigoUsuario');

  function somenteNumeros(event) {
    const teclasPermitidas = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab'];
    if (teclasPermitidas.includes(event.key)) return;
    if (!/^[0-9]$/.test(event.key)) event.preventDefault();
  }

  Numero.addEventListener('keydown', somenteNumeros);
  codigo.addEventListener('keydown', somenteNumeros);
  codigoUsuario.addEventListener('keydown', somenteNumeros);
});

document.addEventListener('DOMContentLoaded', () => {
  const camposTexto = [
    document.getElementById('nome'),
    document.getElementById('bairro'),
    document.getElementById('cidade'),
  ];

  function bloquearNumeros(event) {
    const teclasPermitidas = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab', ' '];
    if (teclasPermitidas.includes(event.key)) return;
    if (/^[0-9]$/.test(event.key)) event.preventDefault();
  }

  camposTexto.forEach(campo => campo.addEventListener('keydown', bloquearNumeros));
});

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

document.addEventListener('DOMContentLoaded', () => {
  const campos = Array.from(form.querySelectorAll('input, select, textarea'));
  campos.forEach((campo, index) => {
    campo.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        const proximoIndex = index + 1;
        if (proximoIndex < campos.length) campos[proximoIndex].focus();
      }
    });
  });
});

// ========== [4. Funções Auxiliares] ==========
function preencherFormulario(cliente) {
  document.querySelector('#codigo').value = cliente.codigo || '';
  document.querySelector('#codigoUsuario').value = cliente.codigoUsuario || '';
  document.querySelector('#nome').value = cliente.nome || '';
  document.querySelector('#cpf').value = cliente.cpf || '';
  document.querySelector('#rg').value = cliente.rg || '';
  document.querySelector('#data_nasc').value = cliente.data_nasc || '';
  document.querySelector('#sexo').value = cliente.sexo || '';
  document.querySelector('#endereco').value = cliente.endereco || '';
  document.querySelector('#num').value = cliente.num || '';
  document.querySelector('#tipo_cliente').value = cliente.tipo_cliente || '';
  document.querySelector('#complemento').value = cliente.complemento || '';
  document.querySelector('#bairro').value = cliente.bairro || '';
  document.querySelector('#uf').value = cliente.uf || '';
  document.querySelector('#cep').value = cliente.cep || '';
  document.querySelector('#cidade').value = cliente.cidade || '';
  document.querySelector('#telefone').value = cliente.telefone || '';
  document.querySelector('#celular').value = cliente.celular || '';
  document.querySelector('#email').value = cliente.email || '';
  document.querySelector('#data_cadastro').value = cliente.data_cadastro || '';
  document.querySelector('#observacoes').value = cliente.observacoes || '';
}



function alternarModoEdicao(editando) {
  const botaoCadastrar = document.getElementById('bt_cadastrar');
  const botaoNovo = document.getElementById('bt_novo');

  if (editando) {
    botaoCadastrar.textContent = 'Salvar Edições';
    botaoCadastrar.style.backgroundColor = '#f39c12';
    botaoNovo.textContent = 'Cancelar mudanças';
    botaoNovo.style.backgroundColor = '#e74c3c';
  } else {
    botaoCadastrar.textContent = 'Cadastrar';
    botaoCadastrar.style.backgroundColor = '';
    botaoNovo.textContent = 'Novo';
    botaoNovo.style.backgroundColor = '';
    clienteEmEdicao = null;
  }
}
document.addEventListener('DOMContentLoaded', function () {
  const botaoNovo = document.getElementById('bt_novo');

  botaoNovo.addEventListener('click', function (e) {
    e.preventDefault();

    if (clienteEmEdicao) {
      // Se estiver em modo de edição, cancelar mudanças
      if (confirm('Deseja cancelar as mudanças?')) {
        form.reset();
        alternarModoEdicao(false);
      }
    } else {
      // Modo padrão "Novo"
      form.reset();
    }
  });
});


// ========== [5. Manipulação de Clientes] ==========
const cpfField = document.getElementById('cpf');
  const cnpjField = document.getElementById('cnpj');
  const rgField = document.getElementById('rg');
  const tipoClienteField = document.getElementById('tipo_cliente');

  function validarDocumentos() {
    const tipoCliente = tipoClienteField.value;
    const cpf = cpfField.value.replace(/\D/g, '');
    const cnpj = cnpjField.value.replace(/\D/g, '');
    const rg = rgField.value.replace(/\D/g, '');

    // Validação para cliente físico
    if (tipoCliente === 'F') {
      if (cnpj.length > 0) {
        alert('Cliente físico não pode ter CNPJ!');
        cnpjField.value = '';
        return false;
      }
      if (cpf.length > 0 && rg.length > 0) {
        // Permitir CPF e RG juntos para pessoa física
        return true;
      }
      if (cpf.length === 0 && rg.length === 0) {
        alert('Cliente físico deve ter CPF ou RG!');
        return false;
      }
    }
    // Validação para cliente jurídico
    else if (tipoCliente === 'J') {
      if (cpf.length > 0 || rg.length > 0) {
        alert('Cliente jurídico não pode ter CPF ou RG!');
        cpfField.value = '';
        rgField.value = '';
        return false;
      }
      if (cnpj.length === 0) {
        alert('Cliente jurídico deve ter CNPJ!');
        return false;
      }
    }
    return true;
  }

  // Adiciona eventos de validação
  cpfField.addEventListener('blur', validarDocumentos);
  cnpjField.addEventListener('blur', validarDocumentos);
  rgField.addEventListener('blur', validarDocumentos);
  tipoClienteField.addEventListener('change', function() {
    // Limpa campos quando muda o tipo de cliente
    if (this.value === 'F') {
      cnpjField.value = '';
    } else if (this.value === 'J') {
      cpfField.value = '';
      rgField.value = '';
    }
    validarDocumentos();
  });

// ========== [5. Manipulação de Clientes] ==========
function salvarCliente(cliente, editar = false) {
  // Adiciona validação antes de salvar
  if (!validarDocumentos()) {
    return false;
  }
}
  const clientes = JSON.parse(localStorage.getItem('clientes')) || [];


// ========== [6. Eventos Principais] ==========
document.addEventListener('DOMContentLoaded', function () {
  const botaoCadastrar = document.getElementById('bt_cadastrar');

  botaoCadastrar.addEventListener('click', function (e) {
    e.preventDefault();
    const cliente = obterDadosFormulario();

    if (!cliente.nome || !cliente.codigo) {
      alert('Insira todos os campos!');
      return;
    }

    if (clienteEmEdicao) {
      if (salvarCliente(cliente, true)) {
        alert('Cliente atualizado com sucesso!');
        alternarModoEdicao(false);
        form.reset();
      }
    } else {
      if (salvarCliente(cliente)) {
        alert('Cliente cadastrado com sucesso!');
        form.reset();
      }
    }
  });
});



// ========== [7. Pesquisa de Clientes] ==========
document.addEventListener('DOMContentLoaded', function () {
  const botaoPesquisar = document.getElementById('bt_pesquisar');
  const modal = document.getElementById('modal_pesquisar');
  const overlay = document.getElementById('overlay');
  const campoBusca = document.getElementById('campoBusca');
  const resultadoPesquisa = document.getElementById('resultadoPesquisa');
  const fecharModal = document.getElementById('fechar-modal');

  botaoPesquisar.addEventListener('click', () => {
    modal.style.display = 'block';
    overlay.style.display = 'block';
    campoBusca.value = '';
    resultadoPesquisa.innerHTML = '';
    campoBusca.focus();
    modal.style.position = 'fixed';
    modal.style.top = '150px';
    modal.style.left = '250px';
    modal.style.background = 'white';
    modal.style.padding = '20px';
    modal.style.borderRadius = '8px';
    modal.style.boxShadow = '0 0 10px rgba(0,0,0,0.3)';
    modal.style.zIndex = '1000';
    modal.style.height = '600px';
  });

  fecharModal.addEventListener('click', () => {
    modal.style.display = 'none';
    overlay.style.display = 'none';
  });

  campoBusca.placeholder = "Insira o código do cliente ou o seu nome";

  campoBusca.addEventListener('input', () => {
    const termo = campoBusca.value.trim().toLowerCase();
    const clientes = JSON.parse(localStorage.getItem('clientes')) || [];
    resultadoPesquisa.innerHTML = '';

    if (termo === '') return;

    resultadoPesquisa.style.width = '100%';
    resultadoPesquisa.style.minHeight = '';
    resultadoPesquisa.style.height = '';

    // Filtra clientes por código ou nome, independente do status ativo/desativado para poder ativar/desativar
    const resultados = clientes.filter(c => 
      (c.codigo.toString() === termo || c.nome.toLowerCase().includes(termo))
    );

    if (resultados.length > 0) {
      resultados.forEach((cliente, index) => {
        const card = document.createElement('div');
        card.className = 'card-cliente';
        card.style = 'overflow: visible; width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 8px; background: #fafafa; margin-bottom: 10px;';

        const titulo = document.createElement('h3');
        titulo.textContent = cliente.nome + (cliente.ativo === false ? ' (Desativado)' : '');

        const detalhes = document.createElement('div');
        detalhes.style.display = 'none';
        detalhes.innerHTML = `
          <p><strong>Endereço:</strong> ${cliente.endereco}</p>
          <p><strong>Complemento:</strong> ${cliente.complemento}</p>
          <p><strong>Bairro:</strong> ${cliente.bairro}</p>
          <p><strong>Cidade:</strong> ${cliente.cidade}</p>
          <p><strong>CEP:</strong> ${cliente.cep}</p>
          <p><strong>Telefone:</strong> ${cliente.telefone}</p>
          <p><strong>Celular:</strong> ${cliente.celular}</p>
          <p><strong>Email:</strong> ${cliente.email}</p>
          <p><strong>Data de Cadastro:</strong> ${cliente.data_cadastro}</p>
          <p><strong>Observações:</strong> ${cliente.observacoes}</p>
        `;

        const btnDetalhes = document.createElement('button');
        btnDetalhes.type = 'button';
        btnDetalhes.textContent = 'Visualizar Detalhes';
        btnDetalhes.style = 'margin-right: 10px; background-color: #3498db; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer;';
        btnDetalhes.addEventListener('click', (event) => {
          event.preventDefault();
          detalhes.style.display = detalhes.style.display === 'none' ? 'block' : 'none';
          btnDetalhes.textContent = detalhes.style.display === 'none' ? 'Visualizar Detalhes' : 'Ocultar Detalhes';
        });

        card.appendChild(titulo);
        card.appendChild(btnDetalhes);

        if (cliente.ativo !== false) {
          // Botão Desativar aparece só se cliente está ativo
          const btnDesativar = document.createElement('button');
          btnDesativar.type = 'button';
          btnDesativar.textContent = 'Desativar Cliente';
          btnDesativar.style = 'background-color: #e74c3c; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; margin-right: 10px;';
          btnDesativar.addEventListener('click', (event) => {
            event.preventDefault();
            if (confirm(`Tem certeza que deseja desativar o cliente ${cliente.nome}?`)) {
              cliente.ativo = false;
              clientes[index] = cliente;
              localStorage.setItem('clientes', JSON.stringify(clientes));
              alert(`Cliente ${cliente.nome} desativado.`);
              campoBusca.dispatchEvent(new Event('input'));
            }
          });
          card.appendChild(btnDesativar);
        } else {
          // Botão Ativar aparece só se cliente está desativado
          const btnAtivar = document.createElement('button');
          btnAtivar.type = 'button';
          btnAtivar.textContent = 'Ativar Cliente';
          btnAtivar.style = 'background-color: #27ae60; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; margin-right: 10px;';
          btnAtivar.addEventListener('click', (event) => {
            event.preventDefault();
            if (confirm(`Deseja ativar o cliente ${cliente.nome}?`)) {
              cliente.ativo = true;
              clientes[index] = cliente;
              localStorage.setItem('clientes', JSON.stringify(clientes));
              alert(`Cliente ${cliente.nome} ativado.`);
              campoBusca.dispatchEvent(new Event('input'));
            }
          });
          card.appendChild(btnAtivar);
        }

        const btnEditar = document.createElement('button');
        btnEditar.type = 'button';
        btnEditar.textContent = 'Editar Cliente';
        btnEditar.style = 'margin-top: 10px; background-color: #f39c12; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; display: block;';
        btnEditar.addEventListener('click', (event) => {
          event.preventDefault();
          preencherFormulario(cliente);
          clienteEmEdicao = cliente;
          alternarModoEdicao(true);
          modal.style.display = 'none';
          overlay.style.display = 'none';
          document.getElementById('nome').focus();
        });

        card.appendChild(btnEditar);
        card.appendChild(detalhes);
        resultadoPesquisa.appendChild(card);
      });
    } else {
      resultadoPesquisa.innerHTML = '<p>Cliente não encontrado.</p>';
    }
  });
});

