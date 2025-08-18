// Lista inicial de fornecedores para exemplo
let listaFornecedores = [
  {
    codigo: "001",
    empresa: "Tech Suprimentos Ltda",
    cnpj: "12.345.678/0001-00",
    endereco: "Rua das Indústrias, 456",
    num: "456",
    complemento: "Galpão 2",
    bairro: "Industrial",
    cidade: "Joinville",
    uf: "SC",
    cep: "89200-000",
    telefone: "(47) 3333-4444",
    celular: "(47) 98888-7777",
    email: "contato@techsuprimentos.com",
    dataCadastro: "2025-05-20",
    fornece: "Peças eletrônicas",
    observacoes: "Entrega pontual, fornece peças originais"
  }
];

// Verifica se campos obrigatórios estão preenchidos
function camposObrigatoriosPreenchidos() {
  const camposObrigatorios = [
    "codigo", "empresa", "cnpj", "endereco", "num", "bairro", "fornece",
    "cidade", "uf", "cep", "telefone", "celular", "email", "dataCadastro", "complemento"
  ];
  for (const id of camposObrigatorios) {
    const campo = document.getElementById(id);
    if (!campo || campo.value.trim() === "") {
      return false;
    }
  }
  return true;
}

// Pega os dados do formulário e retorna como objeto
function pegarDadosFormulario() {
  return {
    codigo: document.getElementById("codigo").value.trim(),
    empresa: document.getElementById("empresa").value.trim(),
    cnpj: document.getElementById("cnpj").value.trim(),
    endereco: document.getElementById("endereco").value.trim(),
    num: document.getElementById("num").value.trim(),
    complemento: document.getElementById("complemento").value.trim(),
    bairro: document.getElementById("bairro").value.trim(),
    cidade: document.getElementById("cidade").value.trim(),
    uf: document.getElementById("uf").value.trim(),
    cep: document.getElementById("cep").value.trim(),
    telefone: document.getElementById("telefone").value.trim(),
    celular: document.getElementById("celular").value.trim(),
    email: document.getElementById("email").value.trim(),
    dataCadastro: document.getElementById("dataCadastro").value.trim(),
    fornece: document.getElementById("fornece").value.trim(),
    observacoes: document.getElementById("observacoes").value.trim()
  };
}

// Preenche o formulário com dados do fornecedor
function preencherFormulario(fornecedor) {
  for (const campo in fornecedor) {
    const elemento = document.getElementById(campo);
    if (elemento) {
      elemento.value = fornecedor[campo];
    }
  }
  fecharModalPesquisar();
}

// Atualiza exibição do overlay de fundo escuro
function atualizarOverlay() {
  const modalPesquisarAberta = document.getElementById('modal_pesquisar').style.display === 'block';
  const modalDetalhesAberta = document.getElementById('modalDetalhes').style.display === 'block';
  const overlay = document.getElementById('overlay');

  overlay.style.display = (modalPesquisarAberta || modalDetalhesAberta) ? 'block' : 'none';
}

// Modal: abrir e fechar
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

// Detalhes do fornecedor
function mostrarDetalhes(fornecedor) {
  const conteudo = `
    <p><strong>Empresa:</strong> ${fornecedor.empresa}</p>
    <p><strong>CNPJ:</strong> ${fornecedor.cnpj}</p>
    <p><strong>Email:</strong> ${fornecedor.email}</p>
    <p><strong>Telefone:</strong> ${fornecedor.telefone}</p>
    <p><strong>Celular:</strong> ${fornecedor.celular}</p>
    <p><strong>Endereço:</strong> ${fornecedor.endereco}, Nº ${fornecedor.num}</p>
    <p><strong>Complemento:</strong> ${fornecedor.complemento || '-'}</p>
    <p><strong>Bairro:</strong> ${fornecedor.bairro}</p>
    <p><strong>CEP:</strong> ${fornecedor.cep}</p>
    <p><strong>Estado:</strong> ${fornecedor.uf}</p>
    <p><strong>Cidade:</strong> ${fornecedor.cidade}</p>
    <p><strong>Data de Cadastro:</strong> ${fornecedor.dataCadastro}</p>
    <p><strong>Fornece:</strong> ${fornecedor.fornece}</p>
    <p><strong>Observações:</strong> ${fornecedor.observacoes || '-'}</p>
  `;
  document.getElementById('conteudoDetalhes').innerHTML = conteudo;
  document.getElementById('modalDetalhes').style.display = 'block';
  atualizarOverlay();
}

// Pesquisa
function pesquisarFornecedores() {
  const termo = document.getElementById('campoBusca').value.toLowerCase();
  const resultados = listaFornecedores.filter(fornecedor =>
    fornecedor.empresa.toLowerCase().includes(termo) || fornecedor.cnpj.includes(termo)
  );
  mostrarResultados(resultados);
}

// Resultados da pesquisa
function mostrarResultados(resultados) {
  const container = document.getElementById('resultadoPesquisa');
  container.innerHTML = '';

  if (resultados.length === 0) {
    container.innerHTML = '<p>Nenhum fornecedor encontrado.</p>';
    return;
  }

  const ul = document.createElement('ul');
  ul.style.listStyle = 'none';
  ul.style.padding = '0';

  resultados.forEach(fornecedor => {
    const li = document.createElement('li');
    li.style.display = 'flex';
    li.style.justifyContent = 'space-between';
    li.style.alignItems = 'center';
    li.style.padding = '8px 0';
    li.style.borderBottom = '1px solid #ccc';

    const textoInfo = document.createElement('span');
    textoInfo.textContent = `${fornecedor.empresa} - CNPJ: ${fornecedor.cnpj}`;

    const botoesDiv = document.createElement('div');

    const btnPreencher = document.createElement('button');
    btnPreencher.textContent = '🔄 Preencher';
    btnPreencher.onclick = () => preencherFormulario(fornecedor);

    const btnExcluir = document.createElement('button');
    btnExcluir.textContent = '❌ Excluir';
    btnExcluir.onclick = () => {
      if (confirm(`Confirma a exclusão do fornecedor "${fornecedor.empresa}"?`)) {
        const idx = listaFornecedores.findIndex(f => f.cnpj === fornecedor.cnpj);
        if (idx !== -1) {
          listaFornecedores.splice(idx, 1);
          pesquisarFornecedores();
        }
      }
    };

    const btnDetalhes = document.createElement('button');
    btnDetalhes.textContent = '🔍 Detalhes';
    btnDetalhes.onclick = () => mostrarDetalhes(fornecedor);

    botoesDiv.appendChild(btnPreencher);
    botoesDiv.appendChild(btnExcluir);
    botoesDiv.appendChild(btnDetalhes);

    li.appendChild(textoInfo);
    li.appendChild(botoesDiv);

    ul.appendChild(li);
  });

  container.appendChild(ul);
}

// Cadastrar ou atualizar fornecedor
function cadastrarFornecedor(event) {
  event.preventDefault();

  if (!camposObrigatoriosPreenchidos()) {
    Swal.fire({
      icon: 'warning',
      title: 'Campos obrigatórios',
      text: 'Por favor, preencha todos os campos obrigatórios!',
      confirmButtonColor: '#d33',
      confirmButtonText: 'OK'
    });
    return;
  }

  const fornecedor = pegarDadosFormulario();
  const idxExistente = listaFornecedores.findIndex(f => f.cnpj === fornecedor.cnpj);

  if (idxExistente !== -1) {
    listaFornecedores[idxExistente] = fornecedor;
    Swal.fire('Atualizado', 'Fornecedor atualizado com sucesso!', 'success');
  } else {
    listaFornecedores.push(fornecedor);
    Swal.fire('Cadastrado', 'Fornecedor cadastrado com sucesso!', 'success');
  }

  document.querySelector(".formulario").reset();
}

// Novo fornecedor
function limparFormulario() {
  document.querySelector(".formulario").reset();
}

// Eventos
document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('bt_cadastrar').addEventListener('click', cadastrarFornecedor);
  document.getElementById('bt_pesquisar').addEventListener('click', abrirModalPesquisar);
  document.getElementById('campoBusca').addEventListener('input', pesquisarFornecedores);
  document.getElementById('bt_novo').addEventListener('click', limparFormulario);
});
