// Função para aplicar máscara de moeda nos campos com a classe 'input-valor'
function aplicarMascaraValor() {
  const campos = document.querySelectorAll('.input-valor');

  campos.forEach(campo => {
    // Adiciona evento ao digitar no campo
    campo.addEventListener('input', function (e) {
      let valor = e.target.value;

      // Remove tudo que não for número
      valor = valor.replace(/\D/g, '');

      // Se estiver vazio, define valor padrão
      if (valor === '') {
        e.target.value = 'R$ 0,00';
        return;
      }

      // Converte número para formato decimal e aplica formatação brasileira
      valor = (parseInt(valor, 10) / 100).toFixed(2);
      valor = valor.replace('.', ',');
      valor = valor.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

      e.target.value = 'R$ ' + valor;
    });

    // Define valor inicial caso campo esteja vazio
    if (!campo.value) {
      campo.value = 'R$ 0,00';
    }
  });
}

// Função para exibir mensagem temporária (tipo toast)
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

// Evento que navega entre os campos da mesma linha com Enter
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

// Configura o botão de remover linha com confirmação via modal
function configurarBotaoRemover(botao, linha) {
  botao.addEventListener("click", () => {
    const modal = document.getElementById("modal-confirmacao");
    const btnSim = document.getElementById("btn-sim");
    const btnNao = document.getElementById("btn-nao");

    modal.classList.remove("hidden");

    // Função chamada ao confirmar remoção
    const aoClicarSim = () => {
      linha.remove();
      salvarTodasAlteracoes(true);
      mostrarMensagem("Exclusão salva com sucesso!", "#d9534f");
      fecharModal();
    };

    // Função chamada ao cancelar
    const aoClicarNao = () => {
      fecharModal();
    };

    // Fecha o modal e remove os event listeners
    function fecharModal() {
      modal.classList.add("hidden");
      btnSim.removeEventListener("click", aoClicarSim);
      btnNao.removeEventListener("click", aoClicarNao);
    }

    btnSim.addEventListener("click", aoClicarSim);
    btnNao.addEventListener("click", aoClicarNao);
  });
}

// Valida campo de OS permitindo apenas números
function validarInputOS(input) {
  input.addEventListener('keypress', function(event) {
    if (!/[0-9]/.test(event.key)) {
      event.preventDefault();
    }
  });
}

// Valida campo de cliente permitindo apenas letras e acentos
function validarInputCliente(input) {
  input.addEventListener('keypress', function(event) {
    if (!/[a-zA-ZÀ-ÿ\s]/.test(event.key)) {
      event.preventDefault();
    }
  });
}

// Adiciona uma nova linha editável na tabela
function adicionarNovaLinha() {
  const tabela = document.getElementById("corpo-tabela");
  const novaLinha = document.createElement("tr");

  // HTML da nova linha com campos e botões
  novaLinha.innerHTML = `
    <td><input type="number" class="input-os" placeholder="Nº OS" onwheel="return false;" /></td>
    <td><input type="text" class="input-cliente" placeholder="Nome do Cliente" /></td>
    <td><input type="text" class="input-descricao" placeholder="Descrição do Serviço" /></td>
    <td><input type="date" class="input-vencimento" /></td>
    <td><input type="text" class="input-valor" placeholder="R$ 0,00" /></td>
    <td>
      <select class="input-status">
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

// Valida se uma string está em formato de data válida
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

// Salva todas as alterações das linhas da tabela
function salvarTodasAlteracoes(isExclusao = false) {
  const linhas = document.querySelectorAll("#corpo-tabela tr");
  const dados = [];
  let valido = true;
  const osMap = new Map();
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

    let camposInvalidos = false;

    // Valida campos obrigatórios
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
    if (!vencimento || !validarData(vencimento)) {
      linha.querySelector(".input-vencimento").classList.add("campo-invalido");
      camposInvalidos = true;
    }
    if (!valor) {
      linha.querySelector(".input-valor").classList.add("campo-invalido");
      camposInvalidos = true;
    }

    // Verifica duplicidade de OS
    if (osMap.has(os)) {
      valido = false;
      osDuplicadas = true;
      linha.querySelector(".input-os").classList.add("campo-invalido");
      osMap.get(os).classList.add("campo-invalido");
    } else {
      osMap.set(os, linha.querySelector(".input-os"));
    }

    if (camposInvalidos) valido = false;

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

// Bloqueia a edição de todas as linhas
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

// Carrega os dados da tabela a partir do localStorage
function carregarTabelaDoStorage() {
  let dados = JSON.parse(localStorage.getItem("servicos")) || [];

  // Ordena primeiro por status e depois por data
  dados.sort((a, b) => {
    const statusOrder = { "Atrasado": 0, "Concluído": 1 };
    const dataA = new Date(a.vencimento);
    const dataB = new Date(b.vencimento);
    if (statusOrder[a.status] !== statusOrder[b.status]) {
      return statusOrder[a.status] - statusOrder[b.status];
    } else {
      return dataA - dataB;
    }
  });

  const tabela = document.getElementById("corpo-tabela");
  tabela.innerHTML = "";

  // Cria as linhas da tabela com os dados salvos
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

// Ativa a edição da linha específica
function ativarEdicao(botao) {
  const linha = botao.closest("tr");
  linha.querySelectorAll("input, select").forEach(input => input.disabled = false);
  botao.disabled = true;
  botao.title = "Edição ativada - use o botão Salvar Alterações para salvar tudo";
}

// Aplica estilos visuais de acordo com o status
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
      }
    };
    aplicarCor();
    select.addEventListener('change', aplicarCor);
  });
}

// Adiciona estilos CSS para os status visualmente
const estilo = document.createElement('style');
estilo.innerHTML = `
  .status-concluido { background-color: #28a745; color: #ffffff; font-weight: bold; }
  .status-pendente  { background-color: #ffc107; color: #212529; font-weight: bold; }
  .status-atrasado  { background-color: #dc3545; color: #212529; font-weight: bold; }
`;
document.head.appendChild(estilo);

// Evento onLoad da página: carrega dados e configura botões principais
window.addEventListener("load", () => {
  carregarTabelaDoStorage();
  document.querySelector(".botao.salvar").addEventListener("click", () => salvarTodasAlteracoes());
  document.querySelector(".botao.novo").addEventListener("click", adicionarNovaLinha);
});

// Atualiza os valores dos cards com totais
function atualizarCards() {
  const valorPagarHoje = document.querySelectorAll('.valor')[0];
  const valorGastoSemanal = document.querySelectorAll('.valor')[1];
  const valorAPagar = document.querySelectorAll('.valor')[2];

  const dados = JSON.parse(localStorage.getItem("servicos")) || [];

  const hoje = new Date().toISOString().split('T')[0];
  const agora = new Date();
  
  // Calcula o início da semana
  function obterInicioSemana(data) {
    const diaSemana = data.getDay();
    const diferenca = diaSemana === 0 ? -6 : 1 - diaSemana;
    const inicio = new Date(data);
    inicio.setDate(data.getDate() + diferenca);
    inicio.setHours(0, 0, 0, 0);
    return inicio;
  }

  const inicioSemana = obterInicioSemana(agora);
  const fimSemana = new Date(inicioSemana);
  fimSemana.setDate(inicioSemana.getDate() + 6);

  let totalPagarHoje = 0;
  let totalGastoSemanal = 0;
  let totalAPagar = 0;

  dados.forEach(servico => {
    const dataVenc = servico.vencimento;
    const valor = parseFloat(servico.valor.replace(/[^\d,]/g, '').replace(',', '.')) || 0;
    const status = servico.status;

    const dataObj = new Date(dataVenc);

    if (dataObj >= inicioSemana && dataObj <= fimSemana) {
      totalGastoSemanal += valor;
    }

    if (status === 'Atrasado') {
      totalAPagar += valor;
      if (dataVenc === hoje) {
        totalPagarHoje += valor;
      }
    }
  });

  // Formata valor como moeda
  function formatarMoeda(valor) {
    return valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
  }

  valorPagarHoje.textContent = formatarMoeda(totalPagarHoje);
  valorGastoSemanal.textContent = formatarMoeda(totalGastoSemanal);
  valorAPagar.textContent = formatarMoeda(totalAPagar);
}

// Atualiza os cards ao carregar a página
window.addEventListener("load", () => {
  atualizarCards();
});
