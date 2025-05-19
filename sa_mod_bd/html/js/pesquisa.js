// Lista inicial de clientes para exemplo
let listaClientes = [
  {
    codigo: "001",
    nome: "João Silva",
    cpf: "123.456.789-00",
    cnpj: "",
    rg: "12.345.678-9",
    data_nasc: "1980-05-10",
    sexo: "M",
    endereco: "Rua A, 123",
    num: "123",
    tipo_cliente: "Pessoa Física",
    complemento: "Apto 101",
    bairro: "Centro",
    uf: "SP",
    cep: "01000-000",
    cidade: "São Paulo",
    telefone: "(11) 1234-5678",
    celular: "(11) 91234-5678",
    email: "joao.silva@email.com",
    data_cadastro: "2025-05-10",
    observacoes: "Cliente fiel, sem pendências"
  },
  {
    codigo: "002",
    nome: "Maria Oliveira",
    cpf: "987.654.321-00",
    cnpj: "",
    rg: "98.765.432-1",
    data_nasc: "1990-12-22",
    sexo: "F",
    endereco: "Av. B, 456",
    num: "456",
    tipo_cliente: "Pessoa Física",
    complemento: "",
    bairro: "Jardim",
    uf: "RJ",
    cep: "20000-000",
    cidade: "Rio de Janeiro",
    telefone: "(21) 2345-6789",
    celular: "(21) 92345-6789",
    email: "maria.oliveira@email.com",
    data_cadastro: "2025-04-22",
    observacoes: ""
  },
  {
    codigo: "003",
    nome: "Empresa XYZ Ltda",
    cpf: "",
    cnpj: "12.345.678/0001-99",
    rg: "",
    data_nasc: "",
    sexo: "N/A",
    endereco: "Rua C, 789",
    num: "789",
    tipo_cliente: "Pessoa Jurídica",
    complemento: "Sala 5",
    bairro: "Industrial",
    uf: "SC",
    cep: "89000-000",
    cidade: "Joinville",
    telefone: "(47) 3456-7890",
    celular: "",
    email: "contato@xyz.com",
    data_cadastro: "2025-03-15",
    observacoes: "Cliente corporativo"
  }
];

// Verifica se campos obrigatórios estão preenchidos
function camposObrigatoriosPreenchidos() {
  const camposObrigatorios = [
    "codigo", "nome", "cpf", "rg", "data_nasc", "sexo",
    "endereco", "num", "tipo_cliente", "bairro", "uf",
    "cep", "cidade", "telefone", "celular", "email", "data_cadastro"
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
    nome: document.getElementById("nome").value.trim(),
    cpf: document.getElementById("cpf").value.trim(),
    cnpj: document.getElementById("cnpj").value.trim(),
    rg: document.getElementById("rg").value.trim(),
    data_nasc: document.getElementById("data_nasc").value.trim(),
    sexo: document.getElementById("sexo").value.trim(),
    endereco: document.getElementById("endereco").value.trim(),
    num: document.getElementById("num").value.trim(),
    tipo_cliente: document.getElementById("tipo_cliente").value.trim(),
    complemento: document.getElementById("complemento").value.trim(),
    bairro: document.getElementById("bairro").value.trim(),
    uf: document.getElementById("uf").value.trim(),
    cep: document.getElementById("cep").value.trim(),
    cidade: document.getElementById("cidade").value.trim(),
    telefone: document.getElementById("telefone").value.trim(),
    celular: document.getElementById("celular").value.trim(),
    email: document.getElementById("email").value.trim(),
    data_cadastro: document.getElementById("data_cadastro").value.trim(),
    observacoes: document.getElementById("observacoes").value.trim()
  };
}

// Preenche o formulário com dados do cliente
function preencherFormulario(cliente) {
  for (const campo in cliente) {
    const elemento = document.getElementById(campo);
    if (elemento) {
      elemento.value = cliente[campo];
    }
  }
  fecharModalPesquisar();
}

// Atualiza exibição do overlay de fundo escuro
function atualizarOverlay() {
  const modalPesquisarAberta = document.getElementById('modal_pesquisar').style.display === 'block';
  const modalDetalhesAberta = document.getElementById('modalDetalhes').style.display === 'block';
  const overlay = document.getElementById('overlay');

  if (modalPesquisarAberta || modalDetalhesAberta) {
    overlay.style.display = 'block';
  } else {
    overlay.style.display = 'none';
  }
}

// Abre modal de pesquisa
function abrirModalPesquisar() {
  document.getElementById('modal_pesquisar').style.display = 'block';
  document.getElementById('campoBusca').focus();
  atualizarOverlay();
}

// Fecha modal de pesquisa e limpa dados
function fecharModalPesquisar() {
  document.getElementById('modal_pesquisar').style.display = 'none';
  document.getElementById('campoBusca').value = '';
  document.getElementById('resultadoPesquisa').innerHTML = '';
  atualizarOverlay();
}

// Fecha modal de detalhes
function fecharModalDetalhes() {
  document.getElementById('modalDetalhes').style.display = 'none';
  atualizarOverlay();
}

// Exibe detalhes do cliente na modal detalhes
function mostrarDetalhes(cliente) {
  const conteudo = `
    <p><strong>Nome:</strong> ${cliente.nome}</p>
    <p><strong>CPF:</strong> ${cliente.cpf || '-'}</p>
    <p><strong>CNPJ:</strong> ${cliente.cnpj || '-'}</p>
    <p><strong>RG:</strong> ${cliente.rg || '-'}</p>
    <p><strong>Data de Nascimento:</strong> ${cliente.data_nasc || '-'}</p>
    <p><strong>Sexo:</strong> ${cliente.sexo}</p>
    <p><strong>Email:</strong> ${cliente.email || '-'}</p>
    <p><strong>Telefone:</strong> ${cliente.telefone || '-'}</p>
    <p><strong>Celular:</strong> ${cliente.celular || '-'}</p>
    <p><strong>Endereço:</strong> ${cliente.endereco}, Nº ${cliente.num}</p>
    <p><strong>Complemento:</strong> ${cliente.complemento || '-'}</p>
    <p><strong>Bairro:</strong> ${cliente.bairro}</p>
    <p><strong>CEP:</strong> ${cliente.cep}</p>
    <p><strong>Estado:</strong> ${cliente.uf}</p>
    <p><strong>Cidade:</strong> ${cliente.cidade}</p>
    <p><strong>Data de Cadastro:</strong> ${cliente.data_cadastro}</p>
    <p><strong>Observações:</strong> ${cliente.observacoes || '-'}</p>
  `;
  document.getElementById('conteudoDetalhes').innerHTML = conteudo;
  document.getElementById('modalDetalhes').style.display = 'block';
  atualizarOverlay();
}

// Exibe resultados da pesquisa na modal
function mostrarResultados(resultados) {
  const container = document.getElementById('resultadoPesquisa');
  container.innerHTML = '';

  if (resultados.length === 0) {
    container.innerHTML = '<p>Nenhum cliente encontrado.</p>';
    return;
  }

  const ul = document.createElement('ul');
  ul.style.listStyle = 'none';
  ul.style.padding = '0';

  resultados.forEach(cliente => {
    const li = document.createElement('li');
    li.style.display = 'flex';
    li.style.justifyContent = 'space-between';
    li.style.alignItems = 'center';
    li.style.padding = '8px 0';
    li.style.borderBottom = '1px solid #ccc';

    const textoInfo = document.createElement('span');
    textoInfo.textContent = `${cliente.nome} - CPF: ${cliente.cpf || '-'}`;

    const botoesDiv = document.createElement('div');

    // Botão Preencher
    const btnPreencher = document.createElement('button');
    btnPreencher.type = 'button';
    btnPreencher.textContent = '🔄 Preencher';
    btnPreencher.style.marginRight = '5px';
    btnPreencher.onclick = () => preencherFormulario(cliente);

    // Botão Excluir
    const btnExcluir = document.createElement('button');
    btnExcluir.type = 'button';
    btnExcluir.textContent = '❌ Excluir';
    btnExcluir.style.marginRight = '5px';
    btnExcluir.onclick = () => {
      if (confirm(`Confirma a exclusão do cliente "${cliente.nome}"?`)) {
        const idx = listaClientes.findIndex(c => c.cpf === cliente.cpf);
        if (idx !== -1) {
          listaClientes.splice(idx, 1);
          pesquisarClientes(); // Atualiza lista na modal
        }
      }
    };

    // Botão Detalhes
    const btnDetalhes = document.createElement('button');
    btnDetalhes.type = 'button';
    btnDetalhes.textContent = '🔍 Detalhes';
    btnDetalhes.onclick = () => mostrarDetalhes(cliente);

    botoesDiv.appendChild(btnPreencher);
    botoesDiv.appendChild(btnExcluir);
    botoesDiv.appendChild(btnDetalhes);

    li.appendChild(textoInfo);
    li.appendChild(botoesDiv);

    ul.appendChild(li);
  });

  container.appendChild(ul);
}

// Função para filtrar clientes conforme o campo de busca
function pesquisarClientes() {
  const termo = document.getElementById('campoBusca').value.toLowerCase();
  const resultados = listaClientes.filter(cliente =>
    (cliente.nome.toLowerCase().includes(termo)) || (cliente.cpf && cliente.cpf.includes(termo))
  );
  mostrarResultados(resultados);
}

// Função para cadastrar ou atualizar cliente
function cadastrarCliente(event) {
  event.preventDefault();

  const containerErro = document.getElementById('mensagemErro');
  const containerSucesso = document.getElementById('mensagemSucesso');

  if (!camposObrigatoriosPreenchidos()) {
    containerErro.textContent = "Por favor, preencha todos os campos obrigatórios!";
    containerErro.style.display = "block";
    containerSucesso.style.display = "none";
    return;
  }

  const cliente = pegarDadosFormulario();

  // Verifica se já existe cliente com o CPF informado
  const idxExistente = listaClientes.findIndex(c => c.cpf === cliente.cpf);

  if (idxExistente !== -1) {
    // Atualiza
    listaClientes[idxExistente] = cliente;
    containerSucesso.textContent = "Cliente atualizado com sucesso!";
  } else {
    // Adiciona novo
    listaClientes.push(cliente);
    containerSucesso.textContent = "Cliente cadastrado com sucesso!";
  }

  containerSucesso.style.display = "block";
  containerErro.style.display = "none";

  // Resetar formulário após cadastro
  document.querySelector("form.formulario").reset();
}

// Configurações dos eventos após carregar o DOM
document.addEventListener("DOMContentLoaded", () => {
  // Referências
  const botaoCadastrar = document.getElementById("bt_cadastrar");
  const botaoPesquisar = document.getElementById("bt_pesquisar");
  const inputBusca = document.getElementById("campoBusca");
  const btnFecharPesquisar = document.getElementById("botaoFechar");
  const btnFecharDetalhes = document.getElementById("fecharDetalhes");
  const overlay = document.getElementById("overlay");

  // Containers de mensagens
  let containerErro = document.createElement("div");
  containerErro.id = 'mensagemErro';
  containerErro.style.color = "#721c24";
  containerErro.style.backgroundColor = "#f8d7da";
  containerErro.style.padding = "10px";
  containerErro.style.marginBottom = "10px";
  containerErro.style.border = "1px solid #f5c6cb";
  containerErro.style.borderRadius = "5px";
  containerErro.style.display = "none";

  let containerSucesso = document.createElement("div");
  containerSucesso.id = 'mensagemSucesso';
  containerSucesso.style.color = "#155724";
  containerSucesso.style.backgroundColor = "#d4edda";
  containerSucesso.style.padding = "10px";
  containerSucesso.style.marginBottom = "10px";
  containerSucesso.style.border = "1px solid #c3e6cb";
  containerSucesso.style.borderRadius = "5px";
  containerSucesso.style.display = "none";

  const formulario = document.querySelector("form.formulario");
  formulario.insertBefore(containerErro, formulario.firstChild);
  formulario.insertBefore(containerSucesso, formulario.firstChild);

  // Eventos
  botaoCadastrar.addEventListener("click", cadastrarCliente);

  botaoPesquisar.addEventListener("click", (e) => {
    e.preventDefault();
    abrirModalPesquisar();
  });

  inputBusca.addEventListener("input", pesquisarClientes);

  btnFecharPesquisar.addEventListener("click", fecharModalPesquisar);

  btnFecharDetalhes.addEventListener("click", fecharModalDetalhes);

  overlay.addEventListener("click", () => {
    // Fecha modais se estiverem abertos
    if (document.getElementById('modal_pesquisar').style.display === 'block') {
      fecharModalPesquisar();
    }
    if (document.getElementById('modalDetalhes').style.display === 'block') {
      fecharModalDetalhes();
    }
  });
});
