function adicionarNovaLinha() {
  const tabela = document.getElementById("corpo-tabela");

  const novaLinha = document.createElement("tr");
  novaLinha.innerHTML = `
    <td><input type="text" placeholder="Cliente" /></td>
    <td><textarea placeholder="Descrição do serviço" rows="2" class="descricao-textarea"></textarea></td>
    <td><input type="date" /></td>
    <td><input type="text" placeholder="R$ 0,00" class="valor-real" /></td>
    <td class="celula-status"></td>
    <td>
      <button class="editar" onclick="alternarEdicao(this)">✏️</button>
      <button class="deletar" onclick="deletarLinha(this)">🗑</button>
    </td>
  `;

  // Adiciona o select com estilo dinâmico
  const selectStatus = document.createElement("select");
  selectStatus.innerHTML = `
    <option value="andamento">Andamento</option>
    <option value="concluido">Concluído</option>
    <option value="pendente">Pendente</option>
  `;
  aplicarEstiloStatus(selectStatus);
  selectStatus.addEventListener("change", () => aplicarEstiloStatus(selectStatus));

  const tdStatus = novaLinha.querySelector(".celula-status");
  tdStatus.appendChild(selectStatus);

  tabela.appendChild(novaLinha);

  const inputValor = novaLinha.querySelector('.valor-real');
  inputValor.addEventListener('input', function () {
    formatarMoedaReal(this);
  });
}

function deletarLinha(botao) {
  const linha = botao.closest("tr");
  linha.remove();
}

function alternarEdicao(botaoEditar) {
  const linha = botaoEditar.closest("tr");
  const celulas = linha.querySelectorAll("td");

  for (let i = 0; i < celulas.length - 1; i++) {
    const celula = celulas[i];
    const span = celula.querySelector("span");

    if (span) {
      const valorAntigo = span.dataset.valorOriginal || "";
      let campo;

      if (i === 2) {
        campo = document.createElement("input");
        campo.type = "date";
      } else if (i === 3) {
        campo = document.createElement("input");
        campo.type = "text";
        campo.classList.add("valor-real");
        campo.value = valorAntigo;
        campo.addEventListener("input", function () {
          formatarMoedaReal(this);
        });
      } else if (i === 4) {
        campo = document.createElement("select");
        campo.innerHTML = `
          <option value="andamento">Andamento</option>
          <option value="concluido">Concluído</option>
          <option value="pendente">Pendente</option>
        `;
        campo.value = valorAntigo;
        aplicarEstiloStatus(campo);
        campo.addEventListener("change", () => aplicarEstiloStatus(campo));
      } else if (i === 1) {
        campo = document.createElement("textarea");
        campo.rows = 2;
      } else {
        campo = document.createElement("input");
        campo.type = "text";
      }

      campo.value = valorAntigo;
      celula.innerHTML = '';
      celula.appendChild(campo);
    }
  }

  linha.classList.add("editando");
}

function salvarAlteracoes() {
  const linhas = document.querySelectorAll("#corpo-tabela tr.editando");

  linhas.forEach(linha => {
    const celulas = linha.querySelectorAll("td");

    for (let i = 0; i < celulas.length - 1; i++) {
      const celula = celulas[i];
      const campo = celula.querySelector("input, textarea, select");

      if (campo) {
        const span = document.createElement("span");
        if (campo.tagName.toLowerCase() === "select") {
          span.textContent = campo.options[campo.selectedIndex].text;
          span.dataset.valorOriginal = campo.value;
        } else {
          span.textContent = campo.value;
          span.dataset.valorOriginal = campo.value;
        }
        celula.innerHTML = '';
        celula.appendChild(span);
      }
    }

    linha.classList.remove("editando");
  });
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

// Aplica a cor de fundo no select de status
function aplicarEstiloStatus(select) {
  select.classList.remove("status-andamento", "status-concluido", "status-pendente");

  switch (select.value) {
    case "andamento":
      select.classList.add("status-andamento");
      break;
    case "concluido":
      select.classList.add("status-concluido");
      break;
    case "pendente":
      select.classList.add("status-pendente");
      break;
  }
}
