function adicionarNovaLinha(dados = {}) {
  const tabela = document.getElementById("corpo-tabela");
  const novaLinha = document.createElement("tr");

  const cliente = dados.cliente || "";
  const descricao = dados.descricao || "";
  const vencimento = dados.vencimento || "";
  const valor = dados.valor || "";
  const status = dados.status || "Andamento";

  const statusClasse = {
    "Andamento": "status-andamento",
    "Concluído": "status-concluido",
    "Pendente": "status-pendente"
  }[status] || "status-andamento";

  novaLinha.innerHTML = `
    <td><input type="text" placeholder="Cliente" value="${cliente}" /></td>
    <td><input type="text" placeholder="Descrição do serviço" value="${descricao}" /></td>
    <td><input type="date" value="${vencimento}" /></td>
    <td><input type="text" placeholder="R$ 0,00" class="valor-real" value="${valor}" /></td>
    <td>
      <button class="status-btn ${statusClasse}" onclick="alternarStatus(this)">${status}</button>
    </td>
    <td>
      <button class="editar" onclick="alternarEdicao(this)">✏️</button>
      <button class="deletar" onclick="deletarLinha(this)">🗑</button>
    </td>
  `;

  tabela.appendChild(novaLinha);

  const inputValor = novaLinha.querySelector('.valor-real');
  inputValor.addEventListener('input', function () {
    formatarMoedaReal(this);
  });

  salvarDadosTabela();
}

function deletarLinha(botao) {
  const linha = botao.closest("tr");
  const dados = coletarDadosDaLinha(linha);

  let edicao = JSON.parse(localStorage.getItem("linhasEmEdicao")) || [];
  edicao = edicao.filter(l =>
    l.cliente !== dados.cliente ||
    l.descricao !== dados.descricao ||
    l.vencimento !== dados.vencimento
  );
  localStorage.setItem("linhasEmEdicao", JSON.stringify(edicao));

  linha.remove();
  salvarDadosTabela();
}

function alternarEdicao(botaoEditar) {
  const linha = botaoEditar.closest("tr");
  const celulas = linha.querySelectorAll("td");

  for (let i = 0; i < celulas.length - 1; i++) {
    const celula = celulas[i];
    const input = celula.querySelector("input");

    if (input) {
      const valor = input.value;
      const span = document.createElement("span");
      span.textContent = valor;
      span.dataset.valorOriginal = valor;
      celula.innerHTML = '';
      celula.appendChild(span);
    } else if (i === 4) {
      // status: botão
      const botaoStatus = celula.querySelector("button");
      const status = botaoStatus.textContent.trim();
      celula.innerHTML = `
        <button class="status-btn ${
          status === "Concluído" ? "status-concluido" :
          status === "Pendente" ? "status-pendente" : "status-andamento"
        }" onclick="alternarStatus(this)">${status}</button>
      `;
    } else {
      const span = celula.querySelector("span");
      const valorAntigo = span?.dataset.valorOriginal || "";
      let campo;

      if (i === 2) {
        campo = document.createElement("input");
        campo.type = "date";
      } else if (i === 3) {
        campo = document.createElement("input");
        campo.type = "text";
        campo.classList.add("valor-real");
        campo.value = valorAntigo;
        campo.addEventListener('input', function () {
          formatarMoedaReal(this);
        });
        celula.innerHTML = '';
        celula.appendChild(campo);
        continue;
      } else {
        campo = document.createElement("input");
        campo.type = "text";
      }

      campo.value = valorAntigo;
      celula.innerHTML = '';
      celula.appendChild(campo);
    }
  }

  const dados = coletarDadosDaLinha(linha);
  salvarLinhaEmEdicao(dados);
}

function alternarStatus(botao) {
  const estados = [
    { texto: "Andamento", classe: "status-andamento" },
    { texto: "Concluído", classe: "status-concluido" },
    { texto: "Pendente", classe: "status-pendente" }
  ];

  const estadoAtual = botao.textContent.trim();
  const indexAtual = estados.findIndex(e => e.texto === estadoAtual);
  const proximo = estados[(indexAtual + 1) % estados.length];

  botao.textContent = proximo.texto;
  botao.className = `status-btn ${proximo.classe}`;

  salvarDadosTabela();
}

function coletarDadosDaLinha(linha) {
  const cliente = linha.querySelector("td:nth-child(1) input")?.value || linha.querySelector("td:nth-child(1) span")?.dataset.valorOriginal;
  const descricao = linha.querySelector("td:nth-child(2) input")?.value || linha.querySelector("td:nth-child(2) span")?.dataset.valorOriginal;
  const vencimento = linha.querySelector("td:nth-child(3) input")?.value || linha.querySelector("td:nth-child(3) span")?.dataset.valorOriginal;
  const valor = linha.querySelector("td:nth-child(4) input")?.value || linha.querySelector("td:nth-child(4) span")?.dataset.valorOriginal;
  const status = linha.querySelector("td:nth-child(5) button")?.textContent.trim();

  return { cliente, descricao, vencimento, valor, status };
}

function salvarLinhaEmEdicao(dados) {
  let linhas = JSON.parse(localStorage.getItem("linhasEmEdicao")) || [];

  const existe = linhas.some(l =>
    l.cliente === dados.cliente &&
    l.descricao === dados.descricao &&
    l.vencimento === dados.vencimento
  );

  if (!existe) {
    linhas.push(dados);
    localStorage.setItem("linhasEmEdicao", JSON.stringify(linhas));
  }
}

function salvarDadosTabela() {
  const linhasDOM = document.querySelectorAll("#corpo-tabela tr");
  const linhas = [];

  linhasDOM.forEach(linha => {
    const dados = coletarDadosDaLinha(linha);
    linhas.push(dados);
  });

  localStorage.setItem("linhasEmEdicao", JSON.stringify(linhas));
}

function carregarLinhasSalvas() {
  const linhas = JSON.parse(localStorage.getItem("linhasEmEdicao")) || [];
  linhas.forEach(linha => adicionarNovaLinha(linha));
}

function formatarMoedaReal(input) {
  let valor = input.value;

  valor = valor.replace(/\D/g, '');

  if (!valor) {
    input.value = '';
    return;
  }

  valor = (parseInt(valor, 10) / 100).toFixed(2);
  valor = valor.replace('.', ',');
  valor = valor.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

  input.value = 'R$ ' + valor;
}

window.onload = carregarLinhasSalvas;
