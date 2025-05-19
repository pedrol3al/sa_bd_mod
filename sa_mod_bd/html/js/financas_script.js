// Aplica máscara simples de valor (exemplo básico)
function aplicarMascaraValor() {
  const inputs = document.querySelectorAll(".input-valor");
  inputs.forEach(input => {
    input.addEventListener("input", () => {
      let v = input.value.replace(/\D/g, "");
      v = (Number(v) / 100).toFixed(2) + "";
      v = v.replace(".", ",");
      v = "R$ " + v.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      input.value = v;
    });
  });
}

function adicionarNovaLinha() {
  const tabela = document.getElementById("corpo-tabela");
  const novaLinha = document.createElement("tr");

  novaLinha.innerHTML = `
    <td><input type="number" class="input-os" placeholder="Nº OS" onwheel="return false;" /></td>
    <td><input type="text" class="input-cliente" placeholder="Nome do Cliente" /></td>
    <td><input type="text" class="input-descricao" placeholder="Descrição do Serviço" /></td>
    <td><input type="date" class="input-vencimento" /></td>
    <td><input type="text" class="input-valor" placeholder="R$ 0,00" /></td>
    <td>
      <select class="input-status">
        <option value="pendente">Pendente</option>
        <option value="pago">Pago</option>
        <option value="atrasado">Atrasado</option>
      </select>
    </td>
    <td>
      <button class="botao-remover-linha" title="Remover">
        <i class="bi bi-x-circle"></i>
      </button>
    </td>
  `;

  tabela.appendChild(novaLinha);
  aplicarMascaraValor();

  // Botão remover só apaga a linha e salva depois
  novaLinha.querySelector(".botao-remover-linha").addEventListener("click", () => {
    novaLinha.remove();
    salvarTodasAlteracoes();
  });
}

function salvarTodasAlteracoes() {
  const linhas = document.querySelectorAll("#corpo-tabela tr");
  const dados = [];
  let valido = true;

  linhas.forEach(linha => {
    // Remove classe de erro se existir
    linha.querySelectorAll("input, select").forEach(campo => campo.classList.remove("campo-invalido"));

    const os = linha.querySelector(".input-os").value.trim();
    const cliente = linha.querySelector(".input-cliente").value.trim();
    const descricao = linha.querySelector(".input-descricao").value.trim();
    const vencimento = linha.querySelector(".input-vencimento").value;
    const valor = linha.querySelector(".input-valor").value.trim();
    const status = linha.querySelector(".input-status").value;

    // Ignorar linhas completamente vazias
    if (!os && !cliente && !descricao && !vencimento && !valor) return;

    // Validação simples
    if (!os || !cliente || !descricao || !vencimento || !valor) {
      valido = false;
      if (!os) linha.querySelector(".input-os").classList.add("campo-invalido");
      if (!cliente) linha.querySelector(".input-cliente").classList.add("campo-invalido");
      if (!descricao) linha.querySelector(".input-descricao").classList.add("campo-invalido");
      if (!vencimento) linha.querySelector(".input-vencimento").classList.add("campo-invalido");
      if (!valor) linha.querySelector(".input-valor").classList.add("campo-invalido");
    }

    dados.push({ os, cliente, descricao, vencimento, valor, status });
  });

  if (!valido) {
    alert("Preencha todos os campos obrigatórios antes de salvar.");
    return;
  }

  localStorage.setItem("servicos", JSON.stringify(dados));
  alert("Alterações salvas!");
}

function carregarTabelaDoStorage() {
  const dados = JSON.parse(localStorage.getItem("servicos")) || [];
  const tabela = document.getElementById("corpo-tabela");
  tabela.innerHTML = "";

  dados.forEach(item => {
    const linha = document.createElement("tr");

    linha.innerHTML = `
      <td><input type="number" class="input-os" value="${item.os}" onwheel="return false;" /></td>
      <td><input type="text" class="input-cliente" value="${item.cliente}" /></td>
      <td><input type="text" class="input-descricao" value="${item.descricao}" /></td>
      <td><input type="date" class="input-vencimento" value="${item.vencimento}" /></td>
      <td><input type="text" class="input-valor" value="${item.valor}" /></td>
      <td>
        <select class="input-status">
          <option value="pendente" ${item.status === "pendente" ? "selected" : ""}>Pendente</option>
          <option value="pago" ${item.status === "pago" ? "selected" : ""}>Pago</option>
          <option value="atrasado" ${item.status === "atrasado" ? "selected" : ""}>Atrasado</option>
        </select>
      </td>
      <td>
        <button class="botao-remover-linha" title="Remover">
          <i class="bi bi-x-circle"></i>
        </button>
      </td>
    `;

    tabela.appendChild(linha);

    // Remover linha e salvar
    linha.querySelector(".botao-remover-linha").addEventListener("click", () => {
      linha.remove();
      salvarTodasAlteracoes();
    });
  });

  aplicarMascaraValor();
}

window.addEventListener("load", () => {
  carregarTabelaDoStorage();

  // Botão salvar
  document.querySelector(".botao.salvar").addEventListener("click", salvarTodasAlteracoes);

  // Botão novo
  document.querySelector(".botao.novo").addEventListener("click", adicionarNovaLinha);
});
