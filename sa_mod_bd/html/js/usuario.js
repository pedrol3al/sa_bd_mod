
// =================== VALIDAÇÃO CAMPOS ===================
function camposObrigatoriosPreenchidos() {
  const campos = [
    "codigo", "nome", "cpf", "rg", "data_nasc", "sexo",
    "endereco", "num", "bairro", "uf", "cep", "cidade",
    "telefone", "celular", "email", "data_cadastro"
  ];
  return campos.every(id => {
    const campo = document.getElementById(id);
    return campo && campo.value.trim() !== '';
  });
}



// =================== MÁSCARAS ===================
function setCursorPosition(pos, el) {
  el.focus();
  if (el.setSelectionRange) {
    el.setSelectionRange(pos, pos);
  } else if (el.createTextRange) {
    const range = el.createTextRange();
    range.collapse(true);
    range.moveEnd('character', pos);
    range.moveStart('character', pos);
    range.select();
  }
}

function mascaraGuia(input, mascara) {
  if (!input.value) input.value = mascara;

  input.addEventListener('input', () => {
    const valor = input.value.replace(/\D/g, '');
    let resultado = '';
    let pos = 0;

    for (let i = 0; i < mascara.length; i++) {
      if (mascara[i] === '0') {
        resultado += pos < valor.length ? valor[pos++] : '0';
      } else {
        resultado += mascara[i];
      }
    }

    input.value = resultado;
    const firstZero = resultado.indexOf('0');
    setCursorPosition(firstZero !== -1 ? firstZero : resultado.length, input);
  });

  input.addEventListener('focus', () => {
    const firstZero = input.value.indexOf('0');
    if (firstZero !== -1) setCursorPosition(firstZero, input);
  });
}

document.addEventListener('DOMContentLoaded', () => {
  mascaraGuia(document.getElementById('cpf'), '000.000.000-00');
  mascaraGuia(document.getElementById('rg'), '00.000.000-0');
  mascaraGuia(document.getElementById('telefone'), '(00) 0000-0000');
  mascaraGuia(document.getElementById('celular'), '(00) 00000-0000');
  mascaraGuia(document.getElementById('cep'), '00000-000');
});

// =================== BLOQUEIO DE TECLAS ===================
// Apenas números
document.addEventListener('DOMContentLoaded', () => {
  const camposNumericos = ['num', 'codigo', 'codigoUsuario'].map(id => document.getElementById(id));

  camposNumericos.forEach(campo => {
    if (!campo) return;
    campo.addEventListener('keydown', event => {
      const permitido = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab'];
      if (!permitido.includes(event.key) && !/^[0-9]$/.test(event.key)) {
        event.preventDefault();
      }
    });
  });
});

// Apenas texto
document.addEventListener('DOMContentLoaded', () => {
  const camposTexto = ['nome', 'bairro', 'cidade'].map(id => document.getElementById(id));

  camposTexto.forEach(campo => {
    if (!campo) return;
    campo.addEventListener('keydown', event => {
      const permitido = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab', ' '];
      if (!permitido.includes(event.key) && /^[0-9]$/.test(event.key)) {
        event.preventDefault();
      }
    });
  });
});

// =================== VALIDAÇÃO EMAIL ===================
document.addEventListener('DOMContentLoaded', () => {
  const email = document.getElementById('email');
  let alerta = false;

  email.addEventListener('blur', () => {
    const valor = email.value.trim();
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (valor !== '' && !regex.test(valor)) {
      if (!alerta) {
        alert('Por favor, insira um email válido.');
        alerta = true;
        email.focus();
      }
    } else {
      alerta = false;
    }
  });
});

// =================== BLOQUEIO CPF/RG vs CNPJ ===================
document.addEventListener('DOMContentLoaded', () => {
  const cpf = document.getElementById('cpf');
  const rg = document.getElementById('rg');
  const cnpj = document.getElementById('cnpj');

  function verificarDocumento() {
    const cpfPreenchido = cpf.value.trim() !== '';
    const rgPreenchido = rg.value.trim() !== '';
    const cnpjPreenchido = cnpj.value.trim() !== '';

    if (cnpjPreenchido) {
      cpf.disabled = true;
      rg.disabled = true;
    } else if (cpfPreenchido || rgPreenchido) {
      cnpj.disabled = true;
    } else {
      // Se todos estão vazios, ativa tudo
      cpf.disabled = false;
      rg.disabled = false;
      cnpj.disabled = false;
    }
  }

  // Quando o usuário digita ou sai do campo, verifica a regra
  cpf.addEventListener('input', verificarDocumento);
  rg.addEventListener('input', verificarDocumento);
  cnpj.addEventListener('input', verificarDocumento);
});

// =================== ENTER PARA PRÓXIMO ===================
document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('form.formulario');
  const campos = Array.from(form.querySelectorAll('input, select, textarea'));

  campos.forEach((campo, i) => {
    campo.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        if (i + 1 < campos.length) {
          campos[i + 1].focus();
        }
      }
    });
  });
});

// =================== MANIPULAÇÃO DE DADOS ===================
function limparFormulario() {
  document.querySelector('form.formulario').reset();
}

function pegarDadosFormulario() {
  const campos = [
    "codigo", "nome", "cpf", "cnpj", "rg", "data_nasc", "sexo",
    "endereco", "num", "complemento", "bairro", "uf", "cep",
    "cidade", "telefone", "celular", "email", "data_cadastro", "observacoes"
  ];

  const dados = {};
  campos.forEach(id => {
    const campo = document.getElementById(id);
    dados[id] = campo ? campo.value.trim() : '';
  });
  return dados;
}

function preencherFormulario(usuario) {
  for (const campo in usuario) {
    const elemento = document.getElementById(campo);
    if (elemento) elemento.value = usuario[campo];
  }
  fecharModalPesquisar();
}

// =================== OVERLAY E MODAIS ===================
// Função para limpar o formulário (botão Novo)
function limparFormulario() {
  document.querySelector('form.formulario').reset();
}

// Função para simular o cadastro (botão Cadastrar)
function cadastrarUsuario() {
  // Pega os valores dos inputs
  const nome = document.getElementById('nome').value.trim();
  if (!nome) {
    alert('Por favor, preencha todos os campo!');
    
  }  // Aqui você pode colocar o código para enviar os dados para um servidor, por exemplo.
}

// Função para abrir modal de pesquisa (botão Pesquisar)
function abrirModalPesquisar() {
  document.getElementById('overlay').style.display = 'block';
  document.getElementById('modal_pesquisar').style.display = 'block';
  document.getElementById('campoBusca').focus();
}

// Função para fechar modal de pesquisa
function fecharModalPesquisar() {
  document.getElementById('overlay').style.display = 'none';
  document.getElementById('modal_pesquisar').style.display = 'none';
}

// Associar eventos aos botões após o carregamento da página
document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('bt_novo').addEventListener('click', limparFormulario);
  document.getElementById('bt_cadastrar').addEventListener('click', cadastrarUsuario);
  document.getElementById('bt_pesquisar').addEventListener('click', abrirModalPesquisar);
});

function atualizarOverlay() {
  const modalPesquisar = document.getElementById('modal_pesquisar').style.display === 'block';
  const modalDetalhes = document.getElementById('modalDetalhes').style.display === 'block';
  const overlay = document.getElementById('overlay');

  overlay.style.display = modalPesquisar || modalDetalhes ? 'block' : 'none';
}

function abrirModalPesquisar() {
  document.getElementById('modal_pesquisar').style.display = 'block';
  document.getElementById('campoBusca').focus();
  atualizarOverlay();
}

function fecharModalPesquisar() {
  document.getElementById('modal_pesquisar').style.display = 'none';
  document.getElementById('campoBusca').value = '';
  document.getElementById('resultadoPesquisa').innerHTML = '';
  atualizarOverlay();
}

function fecharModalDetalhes() {
  document.getElementById('modalDetalhes').style.display = 'none';
  atualizarOverlay();
}

// Pega os usuários do localStorage (array)
function pegarUsuarios() {
  const usuariosJSON = localStorage.getItem(STORAGE_KEY);
  return usuariosJSON ? JSON.parse(usuariosJSON) : [];
}

// Salva lista de usuários no localStorage
function salvarUsuarios(usuarios) {
  localStorage.setItem(STORAGE_KEY, JSON.stringify(usuarios));
}

// Cadastrar usuário (salva no localStorage)
function cadastrarUsuario() {
  const nome = document.getElementById('nome').value.trim();
  if (!nome) {
    alert('Por favor, preencha todos os campos!');
    return;
  }

  const usuario = {
    codigo: document.getElementById('codigo').value.trim(),
    nome: nome,
    cpf: document.getElementById('cpf').value.trim(),
    email: document.getElementById('email').value.trim()
    // Pode adicionar outros campos aqui
  };

  const usuarios = pegarUsuarios();

  // Verifica se já existe código repetido
  if (usuarios.some(u => u.codigo === usuario.codigo && usuario.codigo !== '')) {
    alert('Código já existe. Use um código diferente.');
    return;
  }

  usuarios.push(usuario);
  salvarUsuarios(usuarios);

  alert(`Usuário "${nome}" cadastrado com sucesso!`);
  limparFormulario();
}

// Limpa formulário
function limparFormulario() {
  document.querySelector('form.formulario').reset();
}

// Abre modal de pesquisa
function abrirModalPesquisar() {
  document.getElementById('overlay').style.display = 'block';
  document.getElementById('modal_pesquisar').style.display = 'block';
  document.getElementById('campoBusca').value = '';
  document.getElementById('campoBusca').focus();
  mostrarResultados('');
}

// Fecha modal de pesquisa
function fecharModalPesquisar() {
  document.getElementById('overlay').style.display = 'none';
  document.getElementById('modal_pesquisar').style.display = 'none';
}

// Seleção dos elementos
const formulario = document.getElementById('form-fornecedor');
const tabela = document.getElementById('tabela-fornecedores').getElementsByTagName('tbody')[0];
const btnCadastrar = document.getElementById('btn-cadastrar');
const btnNovo = document.getElementById('btn-novo');
const mensagem = document.getElementById('mensagem');
const buscaInput = document.getElementById('busca');

// Função para exibir mensagens
function exibirMensagem(texto, tipo) {
    mensagem.textContent = texto;
    mensagem.className = tipo;
    mensagem.style.display = 'block';
    setTimeout(() => {
        mensagem.style.display = 'none';
    }, 3000);
}

// Função para adicionar fornecedor na tabela
function adicionarFornecedor() {
    const nome = formulario.nome.value.trim();
    const cnpj = formulario.cnpj.value.trim();
    const email = formulario.email.value.trim();
    const telefone = formulario.telefone.value.trim();

    if (nome === '' || cnpj === '' || email === '' || telefone === '') {
        exibirMensagem('Preencha todos os campos!', 'erro');
        return;
    }

    const novaLinha = tabela.insertRow();

    novaLinha.insertCell(0).textContent = nome;
    novaLinha.insertCell(1).textContent = cnpj;
    novaLinha.insertCell(2).textContent = email;
    novaLinha.insertCell(3).textContent = telefone;

    const acaoCell = novaLinha.insertCell(4);
    const btnExcluir = document.createElement('button');
    btnExcluir.textContent = 'Excluir';
    btnExcluir.className = 'btn-excluir';
    btnExcluir.onclick = function () {
        tabela.deleteRow(novaLinha.rowIndex - 1);
        exibirMensagem('Fornecedor excluído com sucesso!', 'sucesso');
    };
    acaoCell.appendChild(btnExcluir);

    exibirMensagem('Fornecedor cadastrado com sucesso!', 'sucesso');
}

// Função para limpar o formulário
function limparFormulario() {
    formulario.reset();
}

// Função de busca na tabela
function buscarFornecedor() {
    const termo = buscaInput.value.toLowerCase();
    const linhas = tabela.getElementsByTagName('tr');

    for (let i = 0; i < linhas.length; i++) {
        const colunas = linhas[i].getElementsByTagName('td');
        let encontrado = false;

        for (let j = 0; j < colunas.length - 1; j++) {
            if (colunas[j].textContent.toLowerCase().includes(termo)) {
                encontrado = true;
                break;
            }
        }

        linhas[i].style.display = encontrado ? '' : 'none';
    }
}

// Eventos
btnCadastrar.addEventListener('click', (e) => {
    e.preventDefault();
    adicionarFornecedor();
    // ❌ Não limpa mais o formulário aqui
});

btnNovo.addEventListener('click', (e) => {
    e.preventDefault();
    limparFormulario();
});

buscaInput.addEventListener('input', buscarFornecedor);

// Mostra resultados filtrados pela pesquisa
function mostrarResultados(texto) {
  const resultadoDiv = document.getElementById('resultadoPesquisa');
  const usuarios = pegarUsuarios();

  const filtro = texto.toLowerCase();
  const filtrados = usuarios.filter(u => u.nome.toLowerCase().includes(filtro));

  if (filtrados.length === 0) {
    resultadoDiv.innerHTML = '<p>Nenhum usuário encontrado.</p>';
    return;
  }

  const listaHTML = filtrados.map(u => `
    <div class="item-resultado" onclick="mostrarDetalhes('${u.codigo}')">
      <strong>${u.nome}</strong> - CPF: ${u.cpf} - Email: ${u.email}
    </div>
  `).join('');
  resultadoDiv.innerHTML = listaHTML;
}

// Mostra detalhes do usuário no modal
function mostrarDetalhes(codigo) {
  const usuarios = pegarUsuarios();
  const usuario = usuarios.find(u => u.codigo === codigo);
  if (!usuario) return alert('Usuário não encontrado.');

  const conteudo = `
    <h2>${usuario.nome}</h2>
    <p><strong>Código:</strong> ${usuario.codigo}</p>
    <p><strong>CPF:</strong> ${usuario.cpf}</p>
    <p><strong>Email:</strong> ${usuario.email}</p>
  `;
  document.getElementById('conteudoDetalhes').innerHTML = conteudo;
  document.getElementById('modalDetalhes').style.display = 'block';
  document.getElementById('overlay').style.display = 'block';
}

// Fecha modal detalhes
function fecharModalDetalhes() {
  document.getElementById('modalDetalhes').style.display = 'none';
  document.getElementById('overlay').style.display = 'none';
}

// Eventos ao carregar a página
document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('bt_novo').addEventListener('click', limparFormulario);
  document.getElementById('bt_cadastrar').addEventListener('click', cadastrarUsuario);
  document.getElementById('bt_pesquisar').addEventListener('click', abrirModalPesquisar);

  document.getElementById('campoBusca').addEventListener('input', e => {
    mostrarResultados(e.target.value);
  });

  // Tornar as funções globais para fechar modais (por onclick)
  window.fecharModalPesquisar = fecharModalPesquisar;
  window.fecharModalDetalhes = fecharModalDetalhes;
  window.mostrarDetalhes = mostrarDetalhes;
});

function mostrarDetalhes(usuario) {
  const conteudo = `
    <p><strong>Nome:</strong> ${usuario.nome}</p>
    <p><strong>CPF:</strong> ${usuario.cpf || '-'}</p>
    <p><strong>CNPJ:</strong> ${usuario.cnpj || '-'}</p>
    <p><strong>RG:</strong> ${usuario.rg || '-'}</p>
    <p><strong>Data de Nascimento:</strong> ${usuario.data_nasc || '-'}</p>
    <p><strong>Sexo:</strong> ${usuario.sexo}</p>
    <p><strong>Email:</strong> ${usuario.email || '-'}</p>
    <p><strong>Telefone:</strong> ${usuario.telefone || '-'}</p>
    <p><strong>Celular:</strong> ${usuario.celular || '-'}</p>
    <p><strong>Endereço:</strong> ${usuario.endereco}, Nº ${usuario.num}</p>
    <p><strong>Complemento:</strong> ${usuario.complemento || '-'}</p>
    <p><strong>Bairro:</strong> ${usuario.bairro}</p>
    <p><strong>CEP:</strong> ${usuario.cep}</p>
    <p><strong>Estado:</strong> ${usuario.uf}</p>
    <p><strong>Cidade:</strong> ${usuario.cidade}</p>
    <p><strong>Data de Cadastro:</strong> ${usuario.data_cadastro}</p>
    <p><strong>Observações:</strong> ${usuario.observacoes || '-'}</p>
  `;
  document.getElementById('conteudoDetalhes').innerHTML = conteudo;
  document.getElementById('modalDetalhes').style.display = 'block';
  atualizarOverlay();

}
