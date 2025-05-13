const cadastros = [];
let resultados = []; 

function pesquisar() {
  document.getElementById('modal_pesquisar').style.display = "block";
  document.getElementById('overlay').style.display = "block";
}

function fecharModal() {
  document.getElementById('modal_pesquisar').style.display = "none";
  document.getElementById('overlay').style.display = "none";
}

document.getElementById("bt_novo").addEventListener("click", function (event) {
  event.preventDefault();
  const formulario = document.querySelector(".formulario");
  const campos = formulario.querySelectorAll("input, select, textarea");

  campos.forEach(campo => {
    if (campo.type === "select-one") {
      campo.selectedIndex = 0;
    } else {
      campo.value = "";
    }
  });
});

document.getElementById("bt_cadastrar").addEventListener("click", function (event) {
  event.preventDefault();

  const dados = {
    codigo: document.getElementById("codigo").value,
    empresa: document.getElementById("empresa").value.toLowerCase(),
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
    observacoes: document.getElementById("observacoes").value,
  };

  cadastros.push(dados);
  alert("Cadastro salvo com sucesso!");
});

document.getElementById("campoBusca").addEventListener("input", function () {
    const termo = this.value.toLowerCase();
    const resultadoDiv = document.getElementById("resultadoPesquisa");
    resultadoDiv.innerHTML = "";  // Limpa os resultados anteriores

    resultados = cadastros.filter(dado =>
        Object.values(dado).some(valor => valor.toLowerCase().includes(termo))
    );

    if (resultados.length === 0) {
        resultadoDiv.innerHTML = "<p>Nenhum resultado encontrado.</p>";
    } else {
        resultados.forEach((dado, index) => {
            const div = document.createElement("div");
            div.classList.add("resultado-item");
            div.innerHTML = `
                <div class="cadastro-item">
                    <p><strong>Código:</strong> ${dado.codigo}</p>
                    <p><strong>Empresa:</strong> ${dado.empresa}</p>
                    <p><strong>CNPJ:</strong> ${dado.cnpj}</p>
                    <button class="botao-detalhes" onclick="mostrarDetalhes(${index})" title="Ver detalhes">ℹ️</button>
                </div>
                <hr>
            `;
            resultadoDiv.appendChild(div);
        });
    }
});

function mostrarDetalhes(index) {
    const dado = resultados[index];
    const conteudo = `
        <p><strong>Empresa:</strong> ${dado.empresa}</p>
        <p><strong>CNPJ:</strong> ${dado.cnpj}</p>
        <p><strong>Endereço:</strong> ${dado.endereco}, ${dado.num}, ${dado.bairro}</p>
        <p><strong>UF:</strong> ${dado.uf} - <strong>Cidade:</strong> ${dado.cidade}</p>
        <p><strong>Email:</strong> ${dado.email}</p>
        <p><strong>Celular:</strong> ${dado.celular}</p>
        <p><strong>Telefone:</strong> ${dado.telefone}</p>
        <p><strong>Data de Cadastro:</strong> ${dado.dataCadastro}</p>
        <p><strong>Fornece:</strong> ${dado.fornece}</p>
        <p><strong>Observações:</strong> ${dado.observacoes}</p>
    `;
    document.getElementById("conteudoDetalhes").innerHTML = conteudo;
    document.getElementById("modalDetalhes").style.display = "block";  // Exibe o modal de detalhes
}

function fecharDetalhes() {
    document.getElementById("modalDetalhes").style.display = "none";  // Fecha o modal de detalhes
}
