function aplicarMascaraValor() {
  const campos = document.querySelectorAll('.input-valor');

  campos.forEach(campo => {
    campo.addEventListener('input', function (e) {
      let valor = e.target.value;

      // Remove tudo que não for número
      valor = valor.replace(/\D/g, '');

      // Valor mínimo: 0
      if (valor === '') {
        e.target.value = 'R$ 0,00';
        return;
      }

      // Converte para número com duas casas decimais
      valor = (parseInt(valor, 10) / 100).toFixed(2);

      // Substitui ponto por vírgula
      valor = valor.replace('.', ',');

      // Adiciona separador de milhar se necessário
      valor = valor.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

      e.target.value = 'R$ ' + valor;
    });

    // Preenche com R$ 0,00 ao carregar vazio
    if (!campo.value) {
      campo.value = 'R$ 0,00';
    }
  });
}


// Mostra mensagem temporária flutuante
function mostrarMensagem(mensagem, cor = "#4CAF50") {
  const div = document.createElement("div");
  div.textContent = mensagem;
  div.style.position = "fixed";
  div.style.bottom = "20px";
  div.style.left = "50%";
  div.style.transform = "translateX(-50%)";
  div.style.background = cor;
  div.style.color = "#fff";
  div.style.padding = "10px 20px";
  div.style.borderRadius = "8px";
  div.style.zIndex = "9999";
  document.body.appendChild(div);
  setTimeout(() => div.remove(), 3000);
}

// Ação padrão do Enter: ir para próximo input da mesma linha
document.addEventListener("keydown", (e) => {
  if (e.key === "Enter") {
    const atual = e.target;
    if (["INPUT", "SELECT"].includes(atual.tagName)) {
      e.preventDefault();
      const linha = atual.closest("tr");
      const campos = Array.from(linha.querySelectorAll("input, select")).filter(el => !el.disabled);
      const index = campos.indexOf(atual);
      if (index >= 0 && index < campos.length - 1) {
        campos[index + 1].focus();
      } else if (index === campos.length - 1) {
        campos[0].focus();
      }
    }
  }
});

function configurarBotaoRemover(botao, linha) {
  botao.addEventListener("click", () => {
    const modal = document.getElementById("modal-confirmacao");
    const btnSim = document.getElementById("btn-sim");
    const btnNao = document.getElementById("btn-nao");

    modal.classList.remove("hidden");

    const aoClicarSim = () => {
      linha.remove();
      salvarTodasAlteracoes(true);
      mostrarMensagem("Exclusão salva com sucesso!", "#d9534f");
      fecharModal();
    };

    const aoClicarNao = () => {
      fecharModal();
    };

    function fecharModal() {
      modal.classList.add("hidden");
      btnSim.removeEventListener("click", aoClicarSim);
      btnNao.removeEventListener("click", aoClicarNao);
    }

    btnSim.addEventListener("click", aoClicarSim);
    btnNao.addEventListener("click", aoClicarNao);
  });
}

// Validação para input OS (só números)
function validarInputOS(input) {
  input.addEventListener('keypress', function (event) {
    if (!/[0-9]/.test(event.key)) {
      event.preventDefault();
    }
  });
}

// Validação para input Cliente (letras e espaço)
function validarInputCliente(input) {
  input.addEventListener('keypress', function (event) {
    if (!/[a-zA-ZÀ-ÿ\s]/.test(event.key)) {
      event.preventDefault();
    }
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
        
        <option value="Pendente">Pendente</option>
        <option value="Concluído">Concluído</option>
        <option value="Atrasado">Atrasado</option>

      </select>
    </td>
    <td>
      <button class="botao-salvar-linha" title="Editar" onclick="ativarEdicao(this)"><i class="bi bi-pencil"></i></button>
      <button class="botao-remover-linha" title="Remover"><i class="bi bi-x-circle"></i></button>
    </td>
  `;

  tabela.appendChild(novaLinha);
  aplicarMascaraValor();

  novaLinha.querySelectorAll("input, select").forEach(el => el.disabled = false);

  validarInputOS(novaLinha.querySelector('.input-os'));
  validarInputCliente(novaLinha.querySelector('.input-cliente'));

  configurarBotaoRemover(novaLinha.querySelector(".botao-remover-linha"), novaLinha);

  aplicarEstiloStatus();
}


function salvarTodasAlteracoes(isExclusao = false) {
  const linhas = document.querySelectorAll("#corpo-tabela tr");
  const dados = [];
  let valido = true;
  const osMap = new Map(); // Para verificar duplicidade
  let osDuplicadas = false;

  linhas.forEach(linha => {
    // Limpa todas as classes de erro no início
    linha.querySelectorAll("input, select").forEach(campo => campo.classList.remove("campo-invalido"));

    const os = linha.querySelector(".input-os").value.trim();
    const cliente = linha.querySelector(".input-cliente").value.trim();
    const descricao = linha.querySelector(".input-descricao").value.trim();
    const vencimento = linha.querySelector(".input-vencimento").value;
    const valor = linha.querySelector(".input-valor").value.trim();
    const status = linha.querySelector(".input-status").value;

    // Ignora linhas totalmente vazias
    if (!os && !cliente && !descricao && !vencimento && !valor) return;

    // Validação de campos obrigatórios — só marca se não houver duplicidade na OS nessa linha
    let camposInvalidos = false;

    if (!os) {
      linha.querySelector(".input-os").classList.add("campo-invalido");
      camposInvalidos = true;
    }
    if (!cliente) {
      linha.querySelector(".input-cliente").classList.add("campo-invalido");
      camposInvalidos = true;
    }
    if (!descricao) {
      linha.querySelector(".input-descricao").classList.add("campo-invalido");
      camposInvalidos = true;
    }
    if (!vencimento) {
      linha.querySelector(".input-vencimento").classList.add("campo-invalido");
      camposInvalidos = true;
    }
    if (!valor) {
      linha.querySelector(".input-valor").classList.add("campo-invalido");
      camposInvalidos = true;
    }

    // Verificar duplicidade de OS
    if (osMap.has(os)) {
      valido = false;
      osDuplicadas = true;
      linha.querySelector(".input-os").classList.add("campo-invalido");
      osMap.get(os).classList.add("campo-invalido"); // Marca a OS anterior também
    } else {
      osMap.set(os, linha.querySelector(".input-os"));
    }

    if (camposInvalidos) {
      valido = false;
    }

    dados.push({ os, cliente, descricao, vencimento, valor, status });
  });

  if (!valido) {
    if (osDuplicadas) {
      mostrarMensagem("Não é permitido repetir o número da Ordem de Serviço!", "#d9534f");
    } else {
      mostrarMensagem("Preencha todos os campos obrigatórios.", "#d9534f");
    }
    return;
  }

  localStorage.setItem("servicos", JSON.stringify(dados));

  if (!isExclusao) {
    mostrarMensagem("Alterações salvas com sucesso!");
  }

  bloquearEdicaoTodasLinhas();
}


function bloquearEdicaoTodasLinhas() {
  const linhas = document.querySelectorAll("#corpo-tabela tr");
  linhas.forEach(linha => {
    linha.querySelectorAll("input, select").forEach(input => input.disabled = true);
    const botaoEditar = linha.querySelector(".botao-salvar-linha");
    if (botaoEditar) {
      botaoEditar.disabled = false;
      botaoEditar.innerHTML = '<i class="bi bi-pencil"></i>';
      botaoEditar.title = "Editar";
    }
  });
}
function validarData(dataStr) {
  if (!dataStr) return false;

  const partes = dataStr.split("-");
  if (partes.length !== 3) return false;

  const ano = parseInt(partes[0], 10);
  const mes = parseInt(partes[1], 10);
  const dia = parseInt(partes[2], 10);

  if (isNaN(ano) || isNaN(mes) || isNaN(dia)) return false;

  if (ano < 1900 || ano > 2100) return false;

  const data = new Date(ano, mes - 1, dia);

  return (data.getFullYear() === ano && data.getMonth() === mes - 1 && data.getDate() === dia);
}

function salvarTodasAlteracoes(isExclusao = false) {
  const linhas = document.querySelectorAll("#corpo-tabela tr");
  const dados = [];
  let valido = true;
  const osMap = new Map(); // Para verificar duplicidade
  let osDuplicadas = false;

  linhas.forEach(linha => {
    linha.querySelectorAll("input, select").forEach(campo => campo.classList.remove("campo-invalido"));

    const os = linha.querySelector(".input-os").value.trim();
    const cliente = linha.querySelector(".input-cliente").value.trim();
    const descricao = linha.querySelector(".input-descricao").value.trim();
    const vencimento = linha.querySelector(".input-vencimento").value;
    const valor = linha.querySelector(".input-valor").value.trim();
    const status = linha.querySelector(".input-status").value;

    if (!os && !cliente && !descricao && !vencimento && !valor) return;

    // Validação de campos obrigatórios
    if (!os || !cliente || !descricao || !vencimento || !valor) {
      valido = false;
      if (!os) linha.querySelector(".input-os").classList.add("campo-invalido");
      if (!cliente) linha.querySelector(".input-cliente").classList.add("campo-invalido");
      if (!descricao) linha.querySelector(".input-descricao").classList.add("campo-invalido");
      if (!vencimento) linha.querySelector(".input-vencimento").classList.add("campo-invalido");
      if (!valor) linha.querySelector(".input-valor").classList.add("campo-invalido");
    }

    // Validação da data
    if (vencimento && !validarData(vencimento)) {
      valido = false;
      linha.querySelector(".input-vencimento").classList.add("campo-invalido");
    }

    // Verificar duplicidade de OS
    if (osMap.has(os)) {
      valido = false;
      osDuplicadas = true;
      linha.querySelector(".input-os").classList.add("campo-invalido");
      osMap.get(os).classList.add("campo-invalido");
    } else {
      osMap.set(os, linha.querySelector(".input-os"));
    }

    dados.push({ os, cliente, descricao, vencimento, valor, status });
  });

  if (!valido) {
    if (osDuplicadas) {
      mostrarMensagem("Não é permitido repetir o número da Ordem de Serviço!", "#d9534f");
    } else {
      mostrarMensagem("Preencha todos os campos obrigatórios ou corrija os dados inválidos.", "#d9534f");
    }
    return;
  }

  localStorage.setItem("servicos", JSON.stringify(dados));

  if (!isExclusao) {
    mostrarMensagem("Alterações salvas com sucesso!");
  }

  bloquearEdicaoTodasLinhas();
}


function carregarTabelaDoStorage() {
  let dados = JSON.parse(localStorage.getItem("servicos")) || [];


  dados.sort((a, b) => {
    const statusOrder = {
      "Atrasado": 0,
      "Concluído": 1,
    };

    const dataA = new Date(a.vencimento);
    const dataB = new Date(b.vencimento);

    if (statusOrder[a.status] !== statusOrder[b.status]) {
      return statusOrder[a.status] - statusOrder[b.status];
    } else {
      // Se o status for igual, ordena por data de vencimento (mais antigos primeiro)
      return dataA - dataB;
    }
  });

  const tabela = document.getElementById("corpo-tabela");
  tabela.innerHTML = "";

  dados.forEach(item => {
    const linha = document.createElement("tr");

    linha.innerHTML = `
      <td><input type="number" class="input-os" value="${item.os}" onwheel="return false;" disabled /></td>
      <td><input type="text" class="input-cliente" value="${item.cliente}" disabled /></td>
      <td><input type="text" class="input-descricao" value="${item.descricao}" disabled /></td>
      <td><input type="date" class="input-vencimento" value="${item.vencimento}" disabled /></td>
      <td><input type="text" class="input-valor" value="${item.valor}" disabled /></td>
      <td>
       <select class="input-status" disabled>
  <option value="Pendente" ${item.status === "Pendente" ? "selected" : ""}>Pendente</option>
  <option value="Concluído" ${item.status === "Concluído" ? "selected" : ""}>Concluído</option>
  <option value="Atrasado" ${item.status === "Atrasado" ? "selected" : ""}>Atrasado</option>
</select>

      </td>
      <td>
        <button class="botao-salvar-linha" title="Editar" onclick="ativarEdicao(this)"><i class="bi bi-pencil"></i></button>
        <button class="botao-remover-linha" title="Remover"><i class="bi bi-x-circle"></i></button>
      </td>
    `;

    tabela.appendChild(linha);

    validarInputOS(linha.querySelector('.input-os'));
    validarInputCliente(linha.querySelector('.input-cliente'));
    configurarBotaoRemover(linha.querySelector(".botao-remover-linha"), linha);
  });

  aplicarMascaraValor();
  aplicarEstiloStatus();
}


function ativarEdicao(botao) {
  const linha = botao.closest("tr");
  const inputs = linha.querySelectorAll("input, select");

  inputs.forEach(input => input.disabled = false);
  botao.disabled = true;
  botao.title = "Edição ativada - use o botão Salvar Alterações para salvar tudo";
}

window.addEventListener("load", () => {
  carregarTabelaDoStorage();

  document.querySelector(".botao.salvar").addEventListener("click", () => salvarTodasAlteracoes());
  document.querySelector(".botao.novo").addEventListener("click", adicionarNovaLinha);
});
function aplicarEstiloStatus() {
  const selects = document.querySelectorAll('.input-status');

  selects.forEach(select => {
    const aplicarCor = () => {
      select.classList.remove('status-concluido', 'status-pendente', 'status-atrasado');

      switch (select.value) {
        case 'Concluído':
          select.classList.add('status-concluido');
          break;
        case 'Atrasado':
          select.classList.add('status-atrasado');
          break;
        case 'Pendente':
          select.classList.add('status-pendente');
          break;
      }
    };

    aplicarCor(); // Aplica ao carregar
    select.addEventListener('change', aplicarCor); // Aplica ao trocar


    aplicarCor(); // Aplica ao carregar
    select.addEventListener('change', aplicarCor); // Aplica ao trocar

  });
}

// Adiciona estilos via JavaScript (ou mova isso para o seu CSS se preferir)
const estilo = document.createElement('style');
estilo.innerHTML = `
  .status-concluido { background-color: #28a745; color: #ffffff; font-weight: bold; }
  .status-pendente  { background-color: #ffc107; color: #212529; font-weight: bold; }
  .status-atrasado  { background-color: #dc3545; color: #212529; font-weight: bold; }
`;
document.head.appendChild(estilo);

// Chamada após carregar a tabela
window.addEventListener("load", () => {
  aplicarEstiloStatus();
});
function atualizarCards() {
  const valorReceberHoje = document.querySelectorAll('.valor')[0];
  const valorTotalReceber = document.querySelectorAll('.valor')[1];
  const valorTotalRecebido = document.querySelectorAll('.valor')[2];

  const dados = JSON.parse(localStorage.getItem("servicos")) || [];

  const hoje = new Date();
  const hojeStr = hoje.toISOString().split('T')[0];  // "YYYY-MM-DD"

  let totalReceberHoje = 0;
  let totalReceber = 0;
  let totalRecebido = 0;

  dados.forEach(servico => {
    const dataVenc = formatarDataParaComparacao(servico.vencimento);
    const valor = parseFloat(servico.valor.replace(/[^\d,]/g, '').replace(',', '.')) || 0;
    const status = servico.status;

    if (status === 'Pendente') {
      totalReceber += valor;

      if (dataVenc === hojeStr) {
        totalReceberHoje += valor;
      }
    }

    if (status === 'Concluído') {
      totalRecebido += valor;
    }
  });

  function formatarMoeda(valor) {
    return valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
  }

  valorReceberHoje.textContent = formatarMoeda(totalReceberHoje);
  valorTotalReceber.textContent = formatarMoeda(totalReceber);
  valorTotalRecebido.textContent = formatarMoeda(totalRecebido);
}

function formatarDataParaComparacao(dataStr) {
  // Suporta "DD/MM/AAAA" ou "YYYY-MM-DD"
  if (dataStr.includes('/')) {
    const [dia, mes, ano] = dataStr.split('/');
    return `${ano}-${mes.padStart(2, '0')}-${dia.padStart(2, '0')}`;
  }
  return dataStr; // Já está no formato esperado
}

window.addEventListener("load", () => {
  atualizarCards();
});
