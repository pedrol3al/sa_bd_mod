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
        break;
      }
    } else {
      if (pos < numeros.length) {
        resultado += mascara[i];
      } else {
        break;
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
      if (confirm('Deseja cancelar as mudanças?')) {
        form.reset();
        alternarModoEdicao(false);
      }
    } else {
      form.reset();
    }
  });
});

const cpfField = document.getElementById('cpf');
const cnpjField = document.getElementById('cnpj');
const rgField = document.getElementById('rg');
const tipoClienteField = document.getElementById('tipo_cliente');
const data_nascField = document.getElementById('data_nasc');
const sexoField = document.getElementById('sexo');

function validarDocumentos() {
  const tipoCliente = tipoClienteField.value;
  const cpf = cpfField.value.replace(/\D/g, '');
  const cnpj = cnpjField.value.replace(/\D/g, '');
  const rg = rgField.value.replace(/\D/g, '');

  if (tipoCliente === 'F') {
    cnpjField.disabled = true;
    cpfField.disabled = false;
    rgField.disabled = false;
    data_nascField.disabled = false;
    sexoField.disabled = false;
    if (cnpj.length > 0) {
      cnpjField.value = '';
      return false;
    }
    if (cpf.length > 0 && rg.length > 0) {
      return true;
    }
    if (cpf.length === 0 && rg.length === 0) {
      return false;
    }
  }

  if (tipoCliente === 'J') {
    cpfField.disabled = true;
    rgField.disabled = true;
    data_nascField.disabled = true;
    sexoField.disabled = true;
    cnpjField.disabled = false;
    if (cpf.length > 0 || rg.length > 0 || data_nascField.value || sexoField.value) {
      cpfField.value = '';
      rgField.value = '';
      data_nascField.value = '';
      sexoField.value = '';
      return false;
    }
    if (cnpj.length === 0) {
      return false;
    }
  }
  return true;
}

cpfField.addEventListener('blur', validarDocumentos);
cnpjField.addEventListener('blur', validarDocumentos);
rgField.addEventListener('blur', validarDocumentos);
tipoClienteField.addEventListener('change', function () {
  if (this.value === 'F') {
    cnpjField.value = '';
  } else if (this.value === 'J') {
    cpfField.value = '';
    rgField.value = '';
  }
  validarDocumentos();
});

// Função salvarCliente corrigida
function salvarCliente(cliente, editar = false) {
  if (!validarDocumentos()) return false;

  let clientes = JSON.parse(localStorage.getItem('clientes')) || [];

  if (editar && clienteEmEdicao) {
    const index = clientes.findIndex(c => c.codigo === clienteEmEdicao.codigo);
    if (index !== -1) {
      clientes[index] = cliente;
    }
  } else {
    clientes.push(cliente);
  }

  localStorage.setItem('clientes', JSON.stringify(clientes));
  return true;
}

function obterDadosFormulario() {
  return {
    codigo: document.getElementById('codigo').value.trim(),
    codigoUsuario: document.getElementById('codigoUsuario').value.trim(),
    nome: document.getElementById('nome').value.trim(),
    cpf: document.getElementById('cpf').value.trim(),
    rg: document.getElementById('rg').value.trim(),
    data_nasc: document.getElementById('data_nasc').value.trim(),
    sexo: document.getElementById('sexo').value,
    endereco: document.getElementById('endereco').value.trim(),
    num: document.getElementById('num').value.trim(),
    tipo_cliente: document.getElementById('tipo_cliente').value,
    complemento: document.getElementById('complemento').value.trim(),
    bairro: document.getElementById('bairro').value.trim(),
    uf: document.getElementById('uf').value,
    cep: document.getElementById('cep').value.trim(),
    cidade: document.getElementById('cidade').value.trim(),
    telefone: document.getElementById('telefone').value.trim(),
    celular: document.getElementById('celular').value.trim(),
    email: document.getElementById('email').value.trim(),
    data_cadastro: document.getElementById('data_cadastro').value.trim(),
    observacoes: document.getElementById('observacoes').value.trim(),
    ativo: true
  };
}

let clienteEmEdicao = null;
const form = document.querySelector('form');

document.addEventListener('DOMContentLoaded', function () {
  const botaoCadastrar = document.getElementById('bt_cadastrar');

  botaoCadastrar.addEventListener('click', function (e) {
    e.preventDefault();
    const cliente = obterDadosFormulario();

    if (!cliente.nome || !cliente.codigo) {
      alert('Insira todos os campos obrigatórios!');
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

// ========== [Fábrica de Modais] ==========
class ModalFactory {
  constructor() {
    this.overlay = this.createOverlay();
    document.body.appendChild(this.overlay);
  }

  createOverlay() {
    const overlay = document.createElement('div');
    overlay.id = 'modal-overlay';
    overlay.style.cssText = `
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.5);
      z-index: 999;
    `;
    return overlay;
  }

  createModal(options = {}) {
    const {
      id = 'custom-modal',
      title = '',
      content = '',
      width = '600px',
      height = '600px',
      top = '150px',
      left = '250px'
    } = options;

    // Remove modal existente com o mesmo ID
    const existingModal = document.getElementById(id);
    if (existingModal) existingModal.remove();

    const modal = document.createElement('div');
    modal.id = id;
    modal.className = 'custom-modal';
    modal.style.cssText = `
      display: none;
      position: fixed;
      top: ${top};
      left: ${left};
      width: ${width};
      height: ${height};
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.3);
      z-index: 1000;
      overflow: auto;
    `;

    // Cabeçalho do modal
    const header = document.createElement('div');
    header.style.cssText = `
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 1px solid #eee;
    `;

    const titleElement = document.createElement('h2');
    titleElement.textContent = title;
    titleElement.style.margin = '0';

    const closeButton = document.createElement('button');
    closeButton.innerHTML = '&times;';
    closeButton.style.cssText = `
      background: none;
      border: none;
      font-size: 24px;
      cursor: pointer;
    `;

    header.appendChild(titleElement);
    header.appendChild(closeButton);
    modal.appendChild(header);

    // Corpo do modal
    const body = document.createElement('div');
    body.className = 'modal-body';
    body.innerHTML = content;
    modal.appendChild(body);

    document.body.appendChild(modal);

    // Configura comportamentos
    closeButton.addEventListener('click', () => this.closeModal(modal));
    this.overlay.addEventListener('click', () => this.closeModal(modal));

    return {
      element: modal,
      show: () => this.showModal(modal),
      close: () => this.closeModal(modal),
      updateContent: (newContent) => {
        body.innerHTML = newContent;
      }
    };
  }

  showModal(modal) {
    modal.style.display = 'block';
    this.overlay.style.display = 'block';
  }

  closeModal(modal) {
    modal.style.display = 'none';
    this.overlay.style.display = 'none';
  }
}

// ========== [7. Pesquisa de Clientes] ==========
document.addEventListener('DOMContentLoaded', function () {
  // Cria a instância da fábrica de modais
  const modalFactory = new ModalFactory();

  // Cria o modal de pesquisa usando a fábrica
  const pesquisaModal = modalFactory.createModal({
    id: 'modal_pesquisar',
    title: 'Pesquisa de Clientes',
    width: '800px',
    height: '600px',
    top: '50px',
    left: 'calc(50% - 400px)',
    content: `
      <div style="margin-bottom: 20px;">
        <input type="text" id="campoBusca" class="form-control" placeholder="Insira o código do cliente ou o seu nome">
      </div>
      <div id="resultadoPesquisa" style="width: 100%;"></div>
      <button id="fechar-modal" style="
        position: absolute;
        top: 15px;
        right: 15px;
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
      ">&times;</button>
    `
  });

  // Elementos do modal
  const campoBusca = document.getElementById('campoBusca');
  const resultadoPesquisa = document.getElementById('resultadoPesquisa');
  const fecharModal = document.getElementById('fechar-modal');

  // Botão pesquisar da página principal
  const botaoPesquisar = document.getElementById('bt_pesquisar');
  botaoPesquisar.addEventListener('click', () => {
    pesquisaModal.show();
    campoBusca.value = '';
    resultadoPesquisa.innerHTML = '';
    campoBusca.focus();
  });

  // Fechar modal
  fecharModal.addEventListener('click', () => {
    pesquisaModal.close();
  });

  // Evento de pesquisa
  campoBusca.addEventListener('input', () => {
    const termo = campoBusca.value.trim().toLowerCase();
    const clientes = JSON.parse(localStorage.getItem('clientes')) || [];
    resultadoPesquisa.innerHTML = '';

    if (termo === '') return;

    resultadoPesquisa.style.width = '100%';
    resultadoPesquisa.style.minHeight = '';
    resultadoPesquisa.style.height = '';

    // Filtra clientes por código ou nome
    const resultados = clientes.filter(c => 
      (c.codigo.toString() === termo || c.nome.toLowerCase().includes(termo))
    );

    if (resultados.length > 0) {
      resultados.forEach((cliente, index) => {
        const card = document.createElement('div');
        card.className = 'card-cliente';
        card.style.cssText = `
          overflow: visible;
          width: 100%;
          padding: 10px;
          border: 1px solid #ccc;
          border-radius: 8px;
          background: #fafafa;
          margin-bottom: 10px;
        `;

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
        btnDetalhes.style.cssText = `
          margin-right: 10px;
          background-color: #3498db;
          color: white;
          border: none;
          padding: 5px 10px;
          border-radius: 5px;
          cursor: pointer;
        `;
        btnDetalhes.addEventListener('click', (event) => {
          event.preventDefault();
          detalhes.style.display = detalhes.style.display === 'none' ? 'block' : 'none';
          btnDetalhes.textContent = detalhes.style.display === 'none' ? 'Visualizar Detalhes' : 'Ocultar Detalhes';
        });

        card.appendChild(titulo);
        card.appendChild(btnDetalhes);

        if (cliente.ativo !== false) {
          const btnDesativar = document.createElement('button');
          btnDesativar.type = 'button';
          btnDesativar.textContent = 'Desativar Cliente';
          btnDesativar.style.cssText = `
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
          `;
          btnDesativar.addEventListener('click', (event) => {
            event.preventDefault();
            if (confirm('Tem certeza que deseja desativar o cliente ${cliente.nome}?')) {
              cliente.ativo = false;
              clientes[index] = cliente;
              localStorage.setItem('clientes', JSON.stringify(clientes));
              alert('Cliente ${cliente.nome} desativado.');
              campoBusca.dispatchEvent(new Event('input'));
            }
          });
          card.appendChild(btnDesativar);
        } else {
          const btnAtivar = document.createElement('button');
          btnAtivar.type = 'button';
          btnAtivar.textContent = 'Ativar Cliente';
          btnAtivar.style.cssText = `
            background-color: #27ae60;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
          `;
          btnAtivar.addEventListener('click', (event) => {
            event.preventDefault();
            if (confirm('Deseja ativar o cliente ${cliente.nome}?')) {
              cliente.ativo = true;
              clientes[index] = cliente;
              localStorage.setItem('clientes', JSON.stringify(clientes));
              alert('Cliente ${cliente.nome} ativado.');
              campoBusca.dispatchEvent(new Event('input'));
            }
          });
          card.appendChild(btnAtivar);
        }

        const btnEditar = document.createElement('button');
        btnEditar.type = 'button';
        btnEditar.textContent = 'Editar Cliente';
        btnEditar.style.cssText = `
          margin-top: 10px;
          background-color: #f39c12;
          color: white;
          border: none;
          padding: 5px 10px;
          border-radius: 5px;
          cursor: pointer;
          display: block;
        `;
        btnEditar.addEventListener('click', (event) => {
          event.preventDefault();
          preencherFormulario(cliente);
          clienteEmEdicao = cliente;
          alternarModoEdicao(true);
          pesquisaModal.close();
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

  // Funções auxiliares (mantidas do código original)
  function preencherFormulario(cliente) {
    // Implementação da função para preencher o formulário
    // (mantenha a mesma implementação que você já tem)
  }

  function alternarModoEdicao(emEdicao) {
    // Implementação da função para alternar modo de edição
    // (mantenha a mesma implementação que você já tem)
  }
});