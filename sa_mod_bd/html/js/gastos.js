// ========== Máscaras e Formatações ==========
function aplicarMascaraValor(input) {
  input.addEventListener('input', () => {
    let valor = input.value.replace(/\D/g, '');
    valor = (parseInt(valor, 10) / 100).toFixed(2);
    input.value = 'R$ ' + valor.replace('.', ',');
  });
}

// ========== Validação ==========
function validarCampos(descricao, valor) {
  if (!descricao || !valor || valor === 'R$ 0,00') {
    alert('Preencha todos os campos corretamente.');
    return false;
  }
  return true;
}

// ========== LocalStorage ==========
function carregarDespesas() {
  return JSON.parse(localStorage.getItem('despesas')) || [];
}

function salvarDespesas(despesas) {
  localStorage.setItem('despesas', JSON.stringify(despesas));
}

// ========== CRUD ==========
function adicionarDespesa(despesa) {
  const despesas = carregarDespesas();
  despesas.push(despesa);
  salvarDespesas(despesas);
  renderizarDespesas();
}

function editarDespesa(index, novaDespesa) {
  const despesas = carregarDespesas();
  despesas[index] = novaDespesa;
  salvarDespesas(despesas);
  renderizarDespesas();
}

function excluirDespesa(index) {
  if (confirm('Tem certeza que deseja excluir esta despesa?')) {
    const despesas = carregarDespesas();
    despesas.splice(index, 1);
    salvarDespesas(despesas);
    renderizarDespesas();
  }
}

// ========== Renderização ==========
function renderizarDespesas() {
  const lista = document.getElementById('lista-despesas');
  lista.innerHTML = '';

  const despesas = carregarDespesas();
  despesas.sort((a, b) => a.status.localeCompare(b.status)); // Ordenar por status

  despesas.forEach((despesa, index) => {
    const item = document.createElement('div');
    item.className = 'despesa';

    item.innerHTML = `
      <strong>${despesa.descricao}</strong> - 
      ${despesa.valor} - 
      <em>${despesa.status}</em>
      <button onclick="carregarEdicao(${index})">Editar</button>
      <button onclick="excluirDespesa(${index})">Excluir</button>
    `;

    lista.appendChild(item);
  });
}

// ========== Edição ==========
function carregarEdicao(index) {
  const despesas = carregarDespesas();
  const despesa = despesas[index];

  document.getElementById('descricao').value = despesa.descricao;
  document.getElementById('valor').value = despesa.valor;
  document.getElementById('status').value = despesa.status;
  document.getElementById('indice-edicao').value = index;

  document.getElementById('btn-salvar').textContent = 'Salvar edição';
}

// ========== Inicialização ==========
document.addEventListener('DOMContentLoaded', () => {
  const inputValor = document.getElementById('valor');
  aplicarMascaraValor(inputValor);

  document.getElementById('form-despesa').addEventListener('submit', e => {
    e.preventDefault();

    const descricao = document.getElementById('descricao').value.trim();
    const valor = document.getElementById('valor').value.trim();
    const status = document.getElementById('status').value;
    const indiceEdicao = document.getElementById('indice-edicao').value;

    if (!validarCampos(descricao, valor)) return;

    const novaDespesa = { descricao, valor, status };

    if (indiceEdicao === '') {
      adicionarDespesa(novaDespesa);
    } else {
      editarDespesa(Number(indiceEdicao), novaDespesa);
      document.getElementById('indice-edicao').value = '';
      document.getElementById('btn-salvar').textContent = 'Adicionar despesa';
    }

    document.getElementById('form-despesa').reset();
  });

  renderizarDespesas();
});
