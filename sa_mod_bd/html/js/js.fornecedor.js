const cadastros = [
  {
    codigo : "1",
    empresa : "Fornecedor Exemplo Ltda.",
    cnpj : "12.345.678/0001-99",
    cep : "89201-000",
    num : "123",
    endereco : "Rua Exemplo, 123",
    uf : "SC",
    complemento : "Sala 10",
    bairro : "Centro",
    cidade : "Joinville",
    email : "contato@fornecedorexemplo.com.br",
    celular : "(47) 99999-9999",
    telefone : "(47) 3456-7890",
    dataCadastro : "2025-05-10",
    fornece : "Materiais de escritório",
    observacoes : "Fornecedor confiável com bons prazos de entrega."
  }
];

document.getElementById("bt_cadastrar").addEventListener("click", () => {
  const dados = {
    codigo: document.getElementById("codigo").value,
    empresa: document.getElementById("empresa").value,
    cnpj: document.getElementById("cnpj").value,
    cep: document.getElementById("cep").value,
    num: document.getElementById("num").value,
    endereco: document.getElementById("endereco").value,
    uf: document.getElementById("uf").value,
    complemento: document.getElementById("complemento").value,
    bairro: document.getElementById("bairro").value,
    cidade: document.getElementById("cidade").value,
    email: document.getElementById("email").value,
    celular: document.getElementById("celular").value,
    telefone: document.getElementById("telefone").value,
    dataCadastro: document.getElementById("dataCadastro").value,
    fornece: document.getElementById("fornece").value,
    observacoes: document.getElementById("observacoes").value
  };

  // Verifique se o código já existe no array de cadastros
  const codigoExistente = cadastros.some(cadastro => cadastro.codigo === dados.codigo);
  const cnpjExistente = cadastros.some(cadastro => cadastro.cnpj === dados.cnpj);

  if (codigoExistente) {
    alert("Erro: Já existe um cadastro com o mesmo código.");
    return; // Impede o cadastro
  }

  if (cnpjExistente) {
    alert("Erro: Já existe um cadastro com o mesmo CNPJ.");
    return; // Impede o cadastro
  }

  // Se não houver duplicidade, adicione o novo cadastro
  cadastros.push(dados);
  alert("Cadastro salvo com sucesso!");
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
    Object.values(dado).some(valor =>
      valor.toLowerCase().includes(termo)
    )
  );

  if (resultados.length === 0) {
    resultadoDiv.innerHTML = "<p>Nenhum resultado encontrado.</p>";
  } else {
    resultados.forEach(dado => {
      const item = document.createElement("div");
      item.innerHTML = `
        <p><strong>Código:</strong> ${dado.codigo}</p>
        <p><strong>Empresa:</strong> ${dado.empresa}</p>
        <p><strong>CNPJ:</strong> ${dado.cnpj}</p>
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
  
  // Fecha o modal de pesquisa
  document.getElementById("modal_pesquisar").style.display = "none";
  document.getElementById("overlay").style.display = "none";
}

function excluirCadastro(codigo) {
  const index = cadastros.findIndex(cadastro => cadastro.codigo === codigo);
  if (index !== -1) {
    cadastros.splice(index, 1);
    alert("Cadastro excluído com sucesso!");
    document.getElementById("campoBusca").dispatchEvent(new Event("input"));  // Atualiza a lista
  } else {
    alert("Cadastro não encontrado.");
  }
}
