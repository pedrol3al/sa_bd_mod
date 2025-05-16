const cadastrosClientes = [
  {
    codigo: "1",
    nome: "Maria Silva",
    cnpj: "N/A",
    cep: "89012-345",
    num: "456",
    endereco: "Avenida Central, 456",
    uf: "SC",
    complemento: "Apto 202",
    bairro: "Bairro Alto",
    cidade: "Blumenau",
    email: "maria.silva@email.com",
    celular: "(47) 98888-7777",
    telefone: "(47) 3344-5566",
    dataCadastro: "2025-05-12",
    observacoes: "Cliente fiel, sempre realiza compras regulares.",
    cpf: "987.654.321-00",
    rg: "98.765.432-1",
    data_nasc: "1985-11-30",
    sexo: "F",
    tipo_cliente: "Físico",
    empresa: "",
    fornece: ""
  }
];

const cadastrosFornecedores = [
  {
    codigo: "1",
    empresa: "Fornecedor Exemplo Ltda.",
    cnpj: "12.345.678/0001-99",
    cep: "89201-000",
    num: "123",
    endereco: "Rua Exemplo, 123",
    uf: "SC",
    complemento: "Sala 10",
    bairro: "Centro",
    cidade: "Joinville",
    email: "contato@fornecedorexemplo.com.br",
    celular: "(47) 99999-9999",
    telefone: "(47) 3456-7890",
    dataCadastro: "2025-05-10",
    fornece: "Materiais de escritório",
    observacoes: "Fornecedor confiável com bons prazos de entrega.",
    cpf: "",
    rg: "",
    data_nasc: "1997-05-19",
    sexo: "M",
    tipo_cliente: "",
    nome: ""
  }
];

const tipoPagina = document.body.getAttribute("data-tipo-pagina") || "cliente";
const cadastros = tipoPagina === "cliente" ? cadastrosClientes : cadastrosFornecedores;

function getValor(id) {
  const el = document.getElementById(id);
  return el ? el.value : "";
}

document.getElementById("bt_cadastrar").addEventListener("click", () => {
  const dados = {
    codigo: getValor("codigo"),
    empresa: getValor("empresa"),
    cnpj: getValor("cnpj"),
    cep: getValor("cep"),
    num: getValor("num"),
    endereco: getValor("endereco"),
    uf: getValor("uf"),
    complemento: getValor("complemento"),
    bairro: getValor("bairro"),
    cidade: getValor("cidade"),
    email: getValor("email"),
    celular: getValor("celular"),
    telefone: getValor("telefone"),
    dataCadastro: getValor("dataCadastro"),
    fornece: getValor("fornece"),
    observacoes: getValor("observacoes"),
    cpf: getValor("cpf"),
    rg: getValor("rg"),
    data_nasc: getValor("data_nasc"),
    sexo: getValor("sexo"),
    tipo_cliente: tipoPagina === "cliente" ? getValor("tipo_cliente") : "",
    nome: getValor("nome")
  };

  if (tipoPagina === "cliente") {
    if (!dados.codigo.trim() || !dados.nome.trim() || !dados.cpf.trim() || !dados.dataCadastro.trim() || !dados.email.trim() || !dados.celular.trim() || !dados.telefone.trim() || !dados.cidade.trim() || !dados.cep.trim() || !dados.uf.trim() || !dados.bairro.trim() || !dados.complemento.trim() || !dados.tipo_cliente.trim() || !dados.num.trim() || !dados.endereco.trim() || !dados.sexo.trim() || !dados.rg.trim() || !dados.data_nasc.trim()) {
      alert("Preencha todos os campos obrigatórios.");
      return;
    }
  } else if (tipoPagina === "fornecedor") {
    if (!dados.codigo.trim() || !dados.empresa.trim() || !dados.cnpj.trim() || !dados.endereco.trim() || !dados.fornece.trim() || !dados.dataCadastro.trim() || !dados.telefone.trim() || !dados.celular.trim() || !dados.cidade.trim() || !dados.bairro.trim() || !dados.uf.trim() || !dados.complemento.trim() || !dados.cep.trim() || !dados.num.trim()) {
      alert("Preencha todos os campos obrigatórios.");
      return;
    }
  }

  const index = cadastros.findIndex(cadastro => cadastro.codigo === dados.codigo);

  if (index !== -1) {
    cadastros[index] = dados;
    alert("Cadastro atualizado com sucesso!");
  } else {
    const codigoExistente = cadastros.some(cadastro => cadastro.codigo === dados.codigo);
    const cnpjExistente = cadastros.some(cadastro =>
      cadastro.cnpj === dados.cnpj && dados.cnpj !== "N/A"
    );

    if (codigoExistente) {
      alert("Erro: Já existe um cadastro com o mesmo código.");
      return;
    }

    if (cnpjExistente) {
      alert("Erro: Já existe um cadastro com o mesmo CNPJ.");
      return;
    }

    cadastros.push(dados);
    alert("Cadastro salvo com sucesso!");
  }
});

document.getElementById("bt_novo").addEventListener("click", (e) => {
  e.preventDefault();
  document.querySelectorAll("input, select, textarea").forEach(el => {
    if (el.tagName === "SELECT") el.selectedIndex = 0;
    else el.value = "";
  });
});

document.getElementById("bt_pesquisar").addEventListener("click", () => {
  document.getElementById("modal_pesquisar").style.display = "block";
  document.getElementById("overlay").style.display = "block";
});

function fecharModal() {
  document.getElementById("modal_pesquisar").style.display = "none";
  document.getElementById("overlay").style.display = "none";
}

function fecharDetalhes() {
  document.getElementById("modalDetalhes").style.display = "none";
}

document.getElementById("campoBusca").addEventListener("input", function () {
  const termo = this.value.toLowerCase();
  const resultadoDiv = document.getElementById("resultadoPesquisa");
  resultadoDiv.innerHTML = "";

  const resultados = cadastros.filter(dado =>
    Object.values(dado).some(valor => valor.toLowerCase().includes(termo))
  );

  if (resultados.length === 0) {
    resultadoDiv.innerHTML = "<p>Nenhum resultado encontrado.</p>";
  } else {
    resultados.forEach(dado => {
      const resumo = (dado.nome && dado.nome.trim() !== "")
        ? `<p><strong>Código:</strong> ${dado.codigo}</p>
           <p><strong>Nome:</strong> ${dado.nome}</p>
           <p><strong>CPF:</strong> ${dado.cpf}</p>`
        : `<p><strong>Código:</strong> ${dado.codigo}</p>
           <p><strong>Empresa:</strong> ${dado.empresa}</p>
           <p><strong>CNPJ:</strong> ${dado.cnpj}</p>`;

      const item = document.createElement("div");
      item.innerHTML = `
        ${resumo}
        <button type="button" class="botao-detalhes" onclick='mostrarDetalhes(${JSON.stringify(dado)})'>Detalhes</button>
        <button type="button" class="botao-editar" onclick='editarCadastro(${JSON.stringify(dado)})'>Editar</button>
        <button type="button" class="botao-excluir" onclick='excluirCadastro("${dado.codigo}")'>Excluir</button>
        <hr />
      `;
      resultadoDiv.appendChild(item);
    });
  }
});

function mostrarDetalhes(dados) {
  const container = document.getElementById("conteudoDetalhes");
  container.innerHTML = Object.entries(dados).map(([k, v]) => `<p><strong>${k}:</strong> ${v}</p>`).join("");
  document.getElementById("modalDetalhes").style.display = "block";
}

function editarCadastro(dados) {
  document.getElementById("codigo").value = dados.codigo;
  document.getElementById("empresa").value = dados.empresa;
  document.getElementById("cnpj").value = dados.cnpj;
  document.getElementById("cep").value = dados.cep;
  document.getElementById("num").value = dados.num;
  document.getElementById("endereco").value = dados.endereco;
  document.getElementById("uf").value = dados.uf;
  document.getElementById("complemento").value = dados.complemento;
  document.getElementById("bairro").value = dados.bairro;
  document.getElementById("cidade").value = dados.cidade;
  document.getElementById("email").value = dados.email;
  document.getElementById("celular").value = dados.celular;
  document.getElementById("telefone").value = dados.telefone;
  document.getElementById("dataCadastro").value = dados.dataCadastro;
  document.getElementById("fornece").value = dados.fornece;
  document.getElementById("observacoes").value = dados.observacoes;
  document.getElementById("cpf").value = dados.cpf;
  document.getElementById("rg").value = dados.rg;
  document.getElementById("data_nasc").value = dados.data_nasc;
  document.getElementById("sexo").value = dados.sexo;
  document.getElementById("tipo_cliente").value = dados.tipo_cliente;
  if (document.getElementById("nome")) {
    document.getElementById("nome").value = dados.nome || "";
  }

  document.getElementById("modal_pesquisar").style.display = "none";
  document.getElementById("overlay").style.display = "none";
}

function excluirCadastro(codigo) {
  const index = cadastros.findIndex(cadastro => cadastro.codigo === codigo);
  if (index !== -1) {
    cadastros.splice(index, 1);
    alert("Cadastro excluído com sucesso!");
    document.getElementById("campoBusca").dispatchEvent(new Event("input"));
  } else {
    alert("Cadastro não encontrado.");
  }
}
